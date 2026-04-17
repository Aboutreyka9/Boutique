<?php

class ControllerEntrepot extends Connexion
{




    public static function getEntrepot()
    {
        if (isset($_POST["frm_update_entrepot"])) {

            $entrepot = Soutra::getSingleEntrepot($_POST['id_entrepot']);
            $employes = Soutra::getEmployeForResponsableEntrepot();
            $output = '
             <form action="" id="btn_modifier_entrepot" method="POST">
            <input type="hidden" name="btn_modifier_entrepot">
            <input type="hidden"  name="id_entrepot" value="' . $entrepot['ID_entrepot'] . '" >

            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="libelle_entrepot">Nom</label>
                  <input type="text" name="libelle_entrepot" value="' . $entrepot['libelle_entrepot'] . '" id="libelle_entrepot" class="form-control">
                </div>
              </div>
            <div class="col-md-12">
            <div class="form-group">
              <label for="responsable_entrepot">Responsable</label>
              <select name="responsable_entrepot" id="responsable_entrepot" class="form-control">
              ';
            foreach ($employes as $row) {
                $selected = ($row["responsable"] == 1) ? "selected" : "";
                $output .= '
                <option ' . $selected . '  value="' . $row['ID_employe'] . '">' . $row['nom_employe'] . ' ' . $row['prenom_employe'] . '</option>
                ';
            }
            $output .= '
              </select>
            </div>
          </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label for="ville_entrepot">Ville</label>
                  <input type="text" name="ville_entrepot" value="' . $entrepot['ville_entrepot'] . '" id="ville_entrepot" class="form-control">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="adresse_entrepot">Adresse</label>
                  <textarea rows="3" name="adresse_entrepot" id="adresse_entrepot" class="form-control">' . $entrepot['adresse_entrepot'] . '</textarea>
                </div>
              </div>

                 <div class="col-md-12 modal_footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div>
            </div><!-- /.row -->
          </form><!-- /.modal -->
            ';


            echo json_encode(['data' => $output]);
        }
    }


    public static function liste_entrepot()
    {
        if (isset($_POST['btn_liste_entrepot'])) {
            $output = '';
            $entrepot = Soutra::getAllEntrepot();
            if (!empty($entrepot)) {
                $i = 0;
                foreach ($entrepot as $row) {
                    $i++;
                    $btn = '<button title="Désactiver entrepot" data-statut="' . $row['etat_entrepot'] . '" data-code="' . $row['ID_entrepot'] . '"  class="btn btn-danger btn-sm btnChangeStatutEntrepot">
                <i class="bi bi-x-circle"></i> </button>';
                    $etat = '<span class="badge badge-success">Actif</span>';

                    if ($row['etat_entrepot'] !== 1) {
                        $etat = '<span class="badge badge-danger">Inactif</span>';
                        $btn = '<button title="activer entrepot" data-statut="' . $row['etat_entrepot'] . '" data-code="' . $row['ID_entrepot'] . '" class="btn btn-success btn-sm  btnChangeStatutEntrepot">
                <i class="bi bi-check-circle"></i> </button>';
                    }
                    $output .= '
                <tr class="row' . $row['ID_entrepot'] . '">
                   <td>' . $i . '</td>
                   <td>' . $row['libelle_entrepot'] . '</td>
                   <td>' . $row['categorie'] . '</td>
                   <td>' . $etat . '</td>
                   <td>' . Soutra::date_format($row['created_at']) . '</td>
                   ';

                    $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                   <button data-id="' . $row['ID_famille'] . '" class="btn btn-primary btn-sm btn_update_famille">
                   <i class="fa fa-edit"></i> 
    
</button>
                   <div class="d-inline">
                       <button data-id="' . $row['ID_famille'] . '" class="btn btn-warning btn-sm btn_remove_famille">
                       <i class="fa fa-trash"></i> </button>
                   </div>
                 </td>
                    </tr>
                    ';
                }
            }
            echo $output;
        }
    }

    public static function changeStatutEntrepot()
    {
        if (isset($_POST['btnChangeStatutEntrepot'])) {
            extract($_POST);
            $msg['code'] = 400;
            $data['etat_entrepot'] = $statut == 1 ? 0 : 1;
            $data['ID_entrepot'] = $code;

            if (Soutra::update('entrepot', $data)) {
                $msg['code'] = 200;
                $msg['message'] = "Statut entrepot changé avec succès.";
            } else {
                $msg['message'] = 'Une erreur est survenue ! ';
            }
            echo json_encode($msg);
        }
    }


    public static function ajouter_entrepot()
    {
        if (isset($_POST['btn_ajouter_entrepot'])) {
            extract($_POST);
            $msg['code'] = 400;

            if (empty($libelle_entrepot) || empty($responsable_entrepot) || empty($ville_entrepot)) {

                $msg['message'] = 'Veuillez renseigner tous les champs !';
            } elseif (Soutra::existe("entrepot", "libelle_entrepot", $libelle_entrepot)) {

                $msg['message'] = "Ce libelle d'entrepot existe déjà !";
            } else {
                $date = date('Y-m-d');
                $data = array(
                    'libelle_entrepot' => $libelle_entrepot,
                    'ville_entrepot' => $ville_entrepot,
                    'etat_entrepot' => 1,
                    'created_at_entrepot' => $date
                );
                $dataService = array(
                    'entrepot_id' => "",
                    'employe_id' => $responsable_entrepot,
                    'etat_service' => 0,
                    'responsable' => 1,
                    'created_at_service' => $date
                );
                $result = Soutra::transactionData(function () use ($data, $dataService) {
                    Soutra::insert("entrepot", $data);
                    $lastId = Soutra::lastInsertId();
                    $dataService['entrepot_id'] = $lastId;
                    Soutra::insert("service", $dataService);
                });

                //var_dump($data);die();
                if ($result) {
                    $msg['code'] = 200;
                    $msg['message'] = "Entrepot Creer avec succès.";
                } else {
                    $msg['message'] = 'Une erreur est survenue ! ';
                }
            }
            echo json_encode($msg);
        }
    }

    public static function modifier_entrepot()
    {
        if (isset($_POST['btn_modifier_entrepot'])) {

            extract($_POST);
            $msg['code'] = 400;
            $msg['message'] = "";

            if (empty($libelle_entrepot) || empty($responsable_entrepot) || empty($ville_entrepot)) {
                $msg["message"] = 'Veuillez renseigner tous les champs !';
            } elseif (Soutra::existe("entrepot", "libelle_entrepot", $libelle_entrepot) && Soutra::libelle("entrepot", "ID_entrepot", "libelle_entrepot", $libelle_entrepot) != $id_entrepot) {
                $msg['message'] = "Ce libelle d'entrepot existe déjà !";
            } else {
                $result = true;

                $employe = Soutra::getSingleEmployeServiceEntrepot($id_entrepot, $responsable_entrepot);



                if (!empty($employe)) {
                    if ($employe['responsable'] == 0) {
                        // existe et modif
                        $result = Soutra::transactionData(function () use ($id_entrepot, $responsable_entrepot) {
                            Soutra::updated("service", ['responsable' => '0'], ['entrepot_id' => $id_entrepot]);
                            Soutra::updated("service", ['responsable' => '1'], ['entrepot_id' => $id_entrepot, 'employe_id' => $responsable_entrepot]);
                        });
                    }
                } else {
                    // pas encore creer
                    $date = date('Y-m-d');
                    $dataService = [
                        'entrepot_id' => $id_entrepot,
                        'employe_id' => $responsable_entrepot,
                        'etat_service' => $service['etat_service'] ?? 0,
                        'responsable' => 1,
                        'created_at_service' => $date
                    ];

                    $result = Soutra::transactionData(function () use ($dataService, $id_entrepot) {

                        Soutra::updated("service", ['responsable' => '0'], ['entrepot_id' => $id_entrepot]);
                        Soutra::inserted("service", $dataService);
                    });
                }

                $dataEntrepot = [
                    'libelle_entrepot' => $libelle_entrepot,
                    'ville_entrepot' => $ville_entrepot,
                    'adresse_entrepot' => $adresse_entrepot
                ];

                Soutra::updated("entrepot", $dataEntrepot, ['ID_entrepot' => $id_entrepot]);


                if ($result) {
                    $msg['message'] = "Entrepot modifié avec succès.";
                    $msg['code'] = 200;
                } else {
                    $msg['message'] = 'Une erreur est survenue !';
                }
            }

            echo json_encode($msg);
        }
    }

    public static function suppresion_famille()
    {
        if (isset($_POST['btn_supprimer_famille'])) {

            $data = array(
                'etat_famille' => 0,
                'ID_famille' => $_POST['id_famille']
            );
            Soutra::update("famille", $data);
            echo 1;
        }
    }

    public static function getEntrepotForTransfert()
    {
        if (isset($_POST["btn_search_entrepot_transfert"])) {
            $msg["code"] = 400;
            if (!empty($_POST['id_entrepot'])) {

                $entrepot = Soutra::getAllByItemsa('entrepot', 'ID_entrepot', $_POST['id_entrepot']);
                $msg["code"] = 200;
                if (!empty($entrepot)) {
                    $msg["entrepot"] = $entrepot;
                } else {
                    $msg['entrepot'] = 'Erreur de récupération';
                }
            }
            echo json_encode($msg);
        }
    }



    public static function ajouter_panier_transfert()
    {
        if (isset($_POST['btn_ajouter_panier_transfert'])) {
            $output = '';
            if (!empty($_POST['article'])) {
                $transfert = Soutra::getPanierTransfert(implode(',', $_POST['article']));
                var_dump($_POST);
                return;
                if (!empty($transfert)) {
                    $i = 0;
                    foreach ($transfert as $row) {
                        $i++;

                        $output .= '
              <tr class="row' . $row['ID_article'] . '">
                 <td class="col id d_none">' . $row['ID_article'] . '</td>
                 <td>' . $i . '</td>
                 <td>' . $row['libelle_article'] . '</td>
                 <td>' . $row['famille'] . '</td>
                 <td>' . $row['mark'] . '</td>
                <td class="label-price col pu" contenteditable="true">' . $row['prix_achat'] . '</td>
                <td class="label-price col qte" contenteditable="true">0</td>
                <td class="col total">0</td>
                 ';

                        $output .= '
                 <td> 
                     <button data-id="' . $row['ID_article'] . '" title="Supprimer l\'article de la liste" class="btn btn-danger btn-sm btn_remove_data_panier">
                     <i class="fa fa-trash"></i> </button>
                 
               </td>
                  </tr>
                  ';
                    }
                }
                echo $output;
            }
        }
    }
}

//fin de la class
