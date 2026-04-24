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
            <tr class="row' . $row['ID_entrepot'] . '" ' . ($row['ID_entrepot'] == $_SESSION['id_entrepot'] ? 'style="background-color: #d4edda;"' : '') . '>
               <td>' . $i . '</td>
               <td>' . $row['libelle_entrepot'] . '</td>
               <td>' . $row['ville_entrepot'] . '</td>
               <td>' . $row['adresse_entrepot'] . '</td>
               <td>' . $row['responsable'] . '</td>
               <td>' . checkEtatData($row['etat_entrepot']) . '</td>
               <td>' . Soutra::date_format($row['created_at_entrepot']) . '</td>
               ';


                    $output .= '
              
              <td style="display: flex; flex-direction: row; align-items: center;"> 
            <button data-id="' . $row['ID_entrepot'] . '" title="Atribuer article" class="btn btn-success btn-sm btn_attribuer_article mr-2" data-action="entrepot">
            <i class="fa fa-link"></i></button>

            <button data-id="' . $row['ID_entrepot'] . '" title="Atribuer employé" class="btn btn-success btn-sm btn_attribuer_employe mr-2" data-action="attribuer_employe_a_entrepot">
            <i class="fa fa-users"></i></button>

            <button title="Modifier entrepot" data-id="' . $row['ID_entrepot'] . '" class="btn btn-primary mr-2 btn-sm btn_update_entrepot">
            <i class="fa fa-edit"></i>  </button>
                ' . $btn . '
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

    public static function set_entrepot()
    {
        if (isset($_POST['set_entrepot'])) {
            $msg = [];
            if (!empty($_POST['id_entrepot'])) {
                if (Soutra::exite('entrepot', 'ID_entrepot', $_POST['id_entrepot'])) {
                    // L'entrepôt existe, on peut continuer
                    $_SESSION['id_entrepot'] = $_POST['id_entrepot'];
                    Soutra::update("employe", ['entrepot' => $_POST['id_entrepot'], 'ID_employe' => $_SESSION['id_employe']]);
                    // var_dump($_SESSION['id_employe']);::
                    $msg = ['success' => true, 'message' => 'Entrepôt sélectionné avec succès'];
                } else {
                    $msg = ['success' => false, 'message' => 'Entrepôt non trouvé'];
                }
            } else {
                $msg = ['success' => false, 'message' => 'ID entrepôt manquant'];
            }
            echo json_encode($msg);
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

    public static function verifQteArticleTransfert()
    {
        if (isset($_POST['btn_verifQteArticleTransfert'])) {
            $stock = Soutra::getNiveauStockArticle('view_stock_produit', 'ID_article', 'ID_entrepot', $_POST['id'], $_SESSION['id_entrepot']);

            // $entree = Soutra::getCompterSum('entree', 'qte', 'article_id', $_POST['id']);
            // $sortie = Soutra::getCompterSum('sortie', 'qte', 'article_id', $_POST['id']);
            // $stock = abs($entree - $sortie);
            var_dump($stock);
            // echo json_encode();
            if (!empty($stock)) {

                if ($stock['quantite_disponible'] >= $_POST['qte']) {
                    echo 'ok';
                } else {
                    echo $stock['quantite_disponible'];
                }
            } else {
                echo "stock indisponible";
            }
        }
    }

    public static function ajouter_panier_transfert()
    {
        if (isset($_POST['btn_ajouter_panier_transfert'])) {
            $output = '';
            if (!empty($_POST['article'])) {

                $search = [];
                $achat = [];

                if (!isset($_SESSION['panier_transfert']))
                    $_SESSION['panier_transfert'] = [];

                // if (!empty($_POST['article'])) {

                for ($i = 0; $i < count($_POST['article']); $i++) {
                    $id = $_POST['article'][$i];
                    if (!in_array($id, $_SESSION['panier_transfert'])) {
                        $_SESSION['panier_transfert'][] = $id;
                        $search[] = $id;
                    }
                }

                // $transfert = Soutra::getPanierTransfert(implode(',', $_POST['article']));
                $transfert = Soutra::getPanierTransfert(implode(',', $_SESSION['panier_transfert']));
                // $achat = Soutra::getPanierAchat(implode(',', $_SESSION['panier']), $_SESSION['id_entrepot']);
                // var_dump($transfert);

                // }
                echo json_encode($transfert);
            }
        }
    }


    public static function ajouter_transfert()
    {
        if (isset($_POST['btn_ajouter_transfert'])) {

            extract($_POST);
            $verifEmpty = false;
            $verifType = false;
            $msg['code'] = 400;

            for ($i = 0; $i < count($pu); $i++) {
                if (empty(trim($pu[$i])) || empty(trim($qte[$i])) || empty($total[$i])) {
                    $verifEmpty = true;
                } elseif (!ctype_digit($pu[$i]) || !ctype_digit($qte[$i]) || $qte[$i] < 1 || !ctype_digit($total[$i])) {
                    $verifType = true;
                }
            }

            if ($verifEmpty) {
                $msg['message'] =  'Veuillez Entrer toutes les valeurs !';
            } elseif ($verifType) {
                $msg['message'] = 'Verifier les valeurs renseignées';
            } else {

                $date = date('Y-m-d');
                $code = strtoupper(self::checkCode());
                $employe_id = $_SESSION['id_employe'];
                // $entrepot_source = $_POST['source'];
                // $entrepot_destination = $_POST['destination'];

                $data = array(
                    'code_transfert' => $code,
                    'employe_id' => $employe_id,
                    'entrepot_source_id' => $source,
                    'entrepot_destination_id' => $destination,
                    'date_transfert' => $date,
                    'created_at' => $date,
                    'statut_transfert' => STATUT_COMMANDE[0]
                );

                $results = Soutra::transactionData(function () use ($data, $pu, $qte, $id, $code) {
                    Soutra::inserted("transfert", $data);
                    for ($i = 0; $i < count($pu); $i++) {
                        $transfert = array(
                            'transfert_id' => $code,
                            'article_id' => $id[$i],
                            'prix_transfert' => $pu[$i],
                            'qte' => $qte[$i]
                        );

                        Soutra::inserted("ligne_transfert", $transfert);
                    }
                });

                if ($results) {
                    unset($_SESSION['transfert']);
                    unset($_SESSION['panier_transfert']);
                    $msg['code'] = 200;
                    $msg['message'] = "Echange enregistré avec succès.";
                } else {
                    $msg['message'] = 'Une erreur est survenue! ';
                }
            }

            echo json_encode($msg);
        }
    }

    public static function validation_transfert()
    {
        if (isset($_POST['btn_action_transfert']) && $_POST['btn_action_transfert'] == "btn_validation_transfert") {
            extract($_POST);
            $msg = [];

            $data = array(
                'statut_achat' => STATUT_COMMANDE[1],
                'code_achat' => $code
            );


            $ligneAchat = Soutra::getDetailAchat($code);


            $results = Soutra::transactionData(
                function () use ($data, $ligneAchat) {
                    Soutra::update("achat", $data);
                    $employe = $_SESSION['id_employe'];
                    $entrepot = $_SESSION['id_entrepot'] ?? 7;
                    $date = date('Y-m-d');

                    $rows = array_map(function ($value) use ($employe, $entrepot, $date) {
                        return [
                            'article_id'     => $value['article_id'],
                            'type_mouvement' => STATUT_MOUVEMENT[0],
                            'quantite'       => $value['qte'],
                            'employe_id'     => $employe,
                            'prix_achat'     => $value['prix_achat'],
                            'entrepot_id'    => $entrepot,
                            'date_mouvement' => $date
                        ];
                    }, $ligneAchat);

                    // 4. Insert multiple (1 seule requête 🔥)
                    Soutra::insertMultiple('mouvement_stock', $rows);
                }
            );

            if ($results) {
                $msg = ["success" => true, "msg" => "Commande validée avec succès"];
            } else {
                $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
            }

            echo json_encode($msg);
        }
    }

    public static function encaissement_transfert()
    {
        if (isset($_POST['btn_action_transfert']) && $_POST['btn_action_transfert'] == "btn_encaisser_transfer") {
            extract($_POST);
            $msg = [];

            $data = array(
                'statut_achat' => STATUT_COMMANDE[2],
                'code_achat' => $code
            );
            if (Soutra::update("achat", $data)) {
                $msg = ["success" => true, "msg" => "Commande encaissée avec succès"];
            } else {
                $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
            }
            echo json_encode($msg);
        }
    }

    public static function retourner_transfert()
    {
        if (isset($_POST['btn_action_transfert']) && $_POST['btn_action_transfert'] == "btn_retourner_transfer") {
            extract($_POST);
            $msg = [];

            $data = array(
                'statut_achat' => STATUT_COMMANDE[3],
                'code_achat' => $code
            );

            $ligneAchat = Soutra::getDetailAchat($code);


            $results = Soutra::transactionData(
                function () use ($data, $ligneAchat) {
                    Soutra::update("achat", $data);
                    $employe = $_SESSION['id_employe'];
                    $date = date('Y-m-d');

                    $rows = array_map(function ($value) use ($employe, $date) {
                        return [
                            'article_id'     => $value['article_id'],
                            'type_mouvement' => STATUT_MOUVEMENT[5],
                            'quantite'       => $value['qte'],
                            'employe_id'     => $employe,
                            'prix_achat'     => $value['prix_achat'],
                            'entrepot_id'    => $value['entrepot_id'],
                            'date_mouvement' => $date
                        ];
                    }, $ligneAchat);

                    // 4. Insert multiple (1 seule requête 🔥)
                    Soutra::insertMultiple('mouvement_stock', $rows);
                }
            );

            if ($results) {
                $msg = ["success" => true, "msg" => "Commande retournée avec succès"];
            } else {
                $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
            }

            echo json_encode($msg);
        }
    }
    public static function annulation_transfert()
    {
        if (isset($_POST['btn_action_transfert']) && $_POST['btn_action_transfert'] == "btn_annuler_transfer") {
            extract($_POST);
            $msg = [];

            $data = array(
                'statut_achat' => STATUT_COMMANDE[4],
                'code_achat' => $code
            );
            if (Soutra::update("achat", $data)) {
                $msg = ["success" => true, "msg" => "Commande retournée avec succès"];
                $msg = ["success" => true, "msg" => "Commande retournée avec succès"];
                $msg = ["success" => true, "msg" => "Commande annulée avec succès"];
            } else {
                $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
            }
            echo json_encode($msg);
        }
    }

    public static function btn_remove_ajouter_panier_transfert()
    {
        if (isset($_POST['remove_ajouter_panier_transfert'])) {

            $article = $_POST['id_article'];


            $_SESSION['panier_transfert'] = array_filter($_SESSION['panier_transfert'], function ($item) use ($article) {
                return $item != $article;
            });

            echo json_encode([
                'code' => '200',
                'message' => 'Produit retiré de la liste avec succès!',
                'panier' => $_SESSION['panier_transfert']
            ]);
        }
    }

    public static function checkCode()
    {
        $code = "TR" . date('y') . date('d') . rand(10, 999);
        if (!empty(Soutra::libelleExiste('transfert', 'code_transfert', $code))) {
            self::checkCode();
        }
        return $code;
    }
}

//fin de la class

//fin de la class
