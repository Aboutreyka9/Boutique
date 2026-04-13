<?php

class ControllerEntrepot extends Connexion
{




    public static function getEntrepot()
    {
        if (isset($_POST["frm_update_entrepot"])) {

            $entrepot = Soutra::getEntrepotWithService($_POST['id_entrepot']);
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
                $selected = $entrepot["employe_id"] == $row["ID_employe"] ? " selected" : "";
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
            $entrepot = Soutra::getAllentrepot();
            if (!empty($entrepot)) {
                $i = 0;
                foreach ($entrepot as $row) {
                    $i++;
                    $etat = $row['etat_entrepot'] == 1 ? "Disponible" : "Non disponible";

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
                   <i class="fa fa-edit"></i> modiier </button>
                   <div class="d-inline">
                       <button data-id="' . $row['ID_famille'] . '" class="btn btn-warning btn-sm btn_remove_famille">
                       <i class="fa fa-trash"></i> Supprimer</button>
                   </div>
                 </td>
                    </tr>
                    ';
                }
            }
            echo $output;
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
                $result = Soutra::transactionEntrepotService(function () use ($data, $dataService) {
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

                $service = Soutra::getServiceEntrepot($id_entrepot, $responsable_entrepot);

                if ((!empty($service) && $service['employe_id'] != $responsable_entrepot)) {

                    $result = Soutra::transactionData(function () use ($id_entrepot, $responsable_entrepot) {
                        Soutra::updated("service", ['responsable' => '0'], ['entrepot_id' => $id_entrepot]);
                        Soutra::updated("service", ['responsable' => '1'], ['entrepot_id' => $id_entrepot, 'employe_id' => $responsable_entrepot]);
                    });
                } else {
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
                if(!empty($entrepot)){
                    $msg["entrepot"] = $entrepot;
                }else {
                    $msg['entrepot'] = 'Erreur de récupération';
                }
            }
            echo json_encode($msg);
        }
    }
}

//fin de la class

//fin de la class
