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


    // public static function etat_famille() {
    //     if (isset($_POST["etat_utilisateur"])) {
    //         echo (famille::verrif_etat_user($_SESSION["ISPWB"]));
    //     }
    // }

    // public static function liste_type() {
    //     $output = '';
    //     if (!empty(Soutra::getAllByItem3("type_famille", "ID_type_famille", 1))) {
    //         $i = 0;
    //         foreach (Soutra::getAllByItem3("type_famille", "ID_type_famille", 1) as $row) {
    //             $i++;
    //             $output .= '
    //             <tr>
    //                <td>' . $i . '</td>
    //                <td>' . $row['libelle_type_famille'] . '</td>
    //                <td>
    //                   <button type="button" libelle="' . $row['libelle_type_famille'] . '" ID="' . $row['ID_type_famille'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_famille">
    //                       <i class="fa fa-edit"></i> Modifier
    //                   </button>
    //                </td>
    //              </tr>
    //              ';
    //         }
    //     }
    //     echo $output;
    // }

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

    // public static function activation() {
    //     if (isset($_POST['active_famille'])) {
    //         if ($_POST['etat'] == 1) {
    //             $data = array(
    //                 'etat_famille' => 0,
    //                 'ID_famille' => $_POST['id']
    //             );
    //             if (Soutra::update("famille", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 3;
    //             }
    //         } elseif ($_POST['etat'] == 0) {
    //             $data = array(
    //                 'etat_famille' => 1,
    //                 'ID_famille' => $_POST['id']
    //             );
    //             if (Soutra::update("famille", $data)) {
    //                 echo 2;
    //             } else {
    //                 echo 3;
    //             }
    //         }
    //     }
    // }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_famille" class="form-control">';
    //         foreach (Soutra::getAll("type_famille", "libelle_type_famille") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_famille'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_famille'] != 1 && $row['ID_type_famille'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //         $output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
    // }

    // public static function type_combobox_2($ID_type) {
    //     $output = "";
    //     if($ID_type==5){
    //         foreach (Soutra::getAll("type_famille", "libelle_type_famille") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_famille'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_famille'] != 1 && $row['ID_type_famille'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_famille", "libelle_type_famille", "ID_type_famille", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_famille", "libelle_type_famille") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_famille'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_famille'] != 1 && $row['ID_type_famille'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_famille'] . '">
    //                         ' . $row['libelle_type_famille'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }

    //     $output .= "</select>";
    //     echo $output;
    // }

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

    // public static function ajouter_entrepot()
    // {
    //     if (isset($_POST['btn_ajouter_entrepot'])) {

    //         if (isset($_POST['id_entrepot'])) {
    //             // mod()
    //             self::modifier_famille();
    //         } else {
    //             // Ajouter
    //             self::createfamille();
    //         }
    //     }
    // }



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

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("famille", "ID_type_famille", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_famille'] . '">
    //                 ' . $row['nom_famille'] . ' ' . $row['prenom_famille'] . ' : ' . $row['tel_famille'] . '
    //             </option>';
    //         }
    //         $output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
    // }

    //liste des classe par enseignant
    // public static function liste_classe_prof_combo() {
    //     if (isset($_POST['liste_classe_prof_combo'])) {

    //         $query = "SELECT DISTINCT ID_classe,libelle_classe FROM faire_modules f,classe c,annee a WHERE a.ID_annee=f.annee AND c.ID_classe=f.classe AND a.etat_annee= 1 AND c.ID_ecole = ? AND a.ID_annee = ? AND c.ID_niveau = ? AND f.professeur = ?";
    //         $statement = self::getConnexion()->prepare($query);
    //         $statement->execute(array($_POST['ecole_x'], $_POST['annee_x'], $_POST['niveau_x'], $_SESSION["ISPWB"]));
    //         $results = $statement->fetchAll();
    //         $tab = array();
    //         $output = '<select id="classe_eva" class="form-control select_classe_prof"><option value="">Choisir une classe</option>';
    //         foreach ($results as $row) {
    //             $output .= '<option value="' . $row["ID_classe"] . '">' . ($row["libelle_classe"]) . '</option>';
    //         }

    //         echo $output;
    //     }
    // }

    // public static function btn_modifier_profil() {
    //     if (isset($_POST['btn_modif_profila'])) {
    //         //var_dump($_POST);die();
    //         $nom = htmlspecialchars(trim($_POST['nom']));
    //         $prenom = htmlspecialchars(trim($_POST['prenom']));
    //         $tel = htmlspecialchars(trim($_POST['tel']));
    //         $email = htmlspecialchars(trim($_POST['email']));
    //         $login = htmlspecialchars(trim($_POST['login']));
    //         $ID = htmlspecialchars(trim($_POST['id']));
    //         if (empty($nom) || empty($email) || empty($tel) || empty($prenom) || empty($login)) {
    //             echo 'Veuillez remplir tous les champs !';
    //         } elseif (!Soutra::verif_type($tel) || mb_strlen($tel) != 10) {
    //             echo 'Le numéro de téléphone doit être 10 chiffres !';
    //         } elseif (mb_strlen($login) < 4) {
    //             echo 'Le nom utilisateur doit être au moins 4 caractères !';
    //         } elseif (Soutra::exite("famille", "tel_famille", $tel) && Soutra::libelle("famille", "ID_famille", "tel_famille", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("famille", "login_famille", $login) && Soutra::libelle("famille", "ID_famille", "login_famille", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("famille", "email_famille", $email) && Soutra::libelle("famille", "ID_famille", "email_famille", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_famille' => strtoupper($nom),
    //                 'prenom_famille' => ucfirst($prenom),
    //                 'tel_famille' => $tel,
    //                 'email_famille' => $email,
    //                 'login_famille' => $login,
    //                 'ID_famille' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("famille", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    // public static function btn_modifier_passe() {
    //     if (isset($_POST['btn_modif_passe'])) {
    //         //var_dump($_POST);die();
    //         $passe = htmlspecialchars(trim($_POST['passe']));
    //         $passe_conf = htmlspecialchars(trim($_POST['passe_confirme']));
    //         $ID = htmlspecialchars(trim($_POST['id']));
    //         if (empty($passe) || empty($passe_conf)) {
    //             echo 'Veuillez remplir  les champs mots de passe  !';
    //         } elseif (mb_strlen($passe) < 4) {
    //             echo 'Le mot de passe  doit être au moins 4 caractères!';
    //         } elseif ($passe != $passe_conf) {
    //             echo 'Les mots de passe  ne sont pas conforment !';
    //         } else {
    //             $data = array(
    //                 'passe_famille' => md5($passe),
    //                 'ID_famille' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("famille", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //famille_combo
    // public static function famille_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("famille", "nom_famille") as $row) {
    //             if ($row['ID_type_famille'] != 1) {
    //                 if ($row['ID_type_famille'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_famille'] . '">
    //                 ' . $row['nom_famille'] . ' ' . $row['prenom_famille'] . ' Tel : ' . $row['tel_famille'] . ' Fonction : ' . Soutra::getItem("type_famille", "libelle_type_famille", "ID_type_famille", $row['ID_type_famille']) . ' 
    //             </option>';
    //                 }
    //             }
    //         }
    //         //$output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
    // }

}

//fin de la class
