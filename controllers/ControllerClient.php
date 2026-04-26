<?php

class ControllerClient extends Connexion
{

    // connexion utilisateur


    public static function getClient()
    {
        if (isset($_POST["frm_upclient"])) {
            $client = Soutra::getAllByItemsa('client', 'ID_client', $_POST['id_client']);
            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="nom_client">Nom</label>
               <input type="text" name="nom_client" value="' . $client['nom_client'] . '" id="nom_client" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="telephone_client">Telephone</label>
              <input type="text" name="telephone_client" value="' . $client['telephone_client'] . '" id="telephone_client" class="form-control">
              <input type="hidden" name="id_client" value="' . $client['ID_client'] . '" class="form-control">
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <label for="email_client">Email</label>
              <input type="email" name="email_client" value="' . $client['email_client'] . '" id="email_client" class="form-control">
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <label for="adresse_client">Adresse</label>
              <textarea rows="3" name="adresse_client" class="form-control">' . $client['adresse_client'] . '</textarea>
            </div>
          </div>
            ';


            echo $output;
        }
    }

    public static function getClientForVente()
    {
        if (isset($_POST["btn_search_client_vente"])) {
            $msg["code"] = 400;
            if (!empty($_POST['id_client'])) {

                $client = Soutra::getAllByItemsa('client', 'ID_client', $_POST['id_client']);
                $msg["code"] = 200;
                $msg["client"] = $client;
            }
            echo json_encode($msg);
        }
    }

    // public static function etat_client() {
    //     if (isset($_POST["etat_utilisateur"])) {
    //         echo (client::verrif_etat_user($_SESSION["ISPWB"]));
    //     }
    // }

    // public static function liste_type() {
    //     $output = '';
    //     if (!empty(Soutra::getAllByItem3("type_client", "ID_type_client", 1))) {
    //         $i = 0;
    //         foreach (Soutra::getAllByItem3("type_client", "ID_type_client", 1) as $row) {
    //             $i++;
    //             $output .= '
    //             <tr>
    //                <td>' . $i . '</td>
    //                <td>' . $row['libelle_type_client'] . '</td>
    //                <td>
    //                   <button type="button" libelle="' . $row['libelle_type_client'] . '" ID="' . $row['ID_type_client'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_client">
    //                       <i class="fa fa-edit"></i> Modifier
    //                   </button>
    //                </td>
    //              </tr>
    //              ';
    //         }
    //     }
    //     echo $output;
    // }

    public static function liste_client()
    {
        if (isset($_POST['btn_liste_client'])) {
            $output = '';
            $client = Soutra::getAllClientEntrepot();
            if (!empty($client)) {
                $i = 0;
                foreach ($client as $row) {
                    $i++;

                    $output .= '
             <tr class="row' . $row['ID_client'] . '">
               <td>' . $i . '</td>
               <td>' . checkEtatData($row['etat_client']) . '</td>
               <td>' . $row['nom_client'] . '</td>
               <td>' . $row['telephone_client'] . '</td>
               <td>' . $row['email_client'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


                    $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                <a  href="' . URL . 'client_profile&id=' . $row['ID_client'] . '" class="btn btn-success btn-link btn-sm " data-toggle="tooltip" title="" data-original-title="Voir details client">
                  <i class="fa fa-eye text-icon-success"></i> </a>
                  
            <button data-id="' . $row['ID_client'] . '" class="btn btn-primary btn-sm btn_update_client">
            <i class="fa fa-edit"></i> </button> ';

                    if (isAdminGestionnaire()) {
                        $output .= '<div class="d-inline">
                <button data-id="' . $row['ID_client'] . '" class="btn btn-warning btn-sm btn_remove_client">
                <i class="fa fa-trash"></i> </button>
            </div>';
                    }
                    $output .= '
          </td>
             </tr>
             ';
                }
            }
            echo $output;
        }
    }

    public static function activation()
    {
        if (isset($_POST['active_client'])) {
            if ($_POST['etat'] == 1) {
                $data = array(
                    'etat_client' => 0,
                    'ID_client' => $_POST['id']
                );
                if (Soutra::update("client", $data)) {
                    echo 1;
                } else {
                    echo 3;
                }
            } elseif ($_POST['etat'] == 0) {
                $data = array(
                    'etat_client' => 1,
                    'ID_client' => $_POST['id']
                );
                if (Soutra::update("client", $data)) {
                    echo 2;
                } else {
                    echo 3;
                }
            }
        }
    }

    public static function checkCode()
    {
        $code = "CL" . date('y') . date('d') . rand(11, 999);
        if (!empty(Soutra::libelleExiste('client', 'code_client', $code))) {
            self::checkCode();
        }
        return $code;
    }

    public static function checkCodeVersement()
    {
        $code = "VR" . date('y') . date('d') . rand(11, 999);
        if (!empty(Soutra::libelleExiste('client', 'code_client', $code))) {
            self::checkCode();
        }
        return $code;
    }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_client" class="form-control">';
    //         foreach (Soutra::getAll("type_client", "libelle_type_client") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_client'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_client'] != 1 && $row['ID_type_client'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
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
    //         foreach (Soutra::getAll("type_client", "libelle_type_client") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_client'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_client'] != 1 && $row['ID_type_client'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_client", "libelle_type_client", "ID_type_client", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_client", "libelle_type_client") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_client'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_client'] != 1 && $row['ID_type_client'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_client'] . '">
    //                         ' . $row['libelle_type_client'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }

    //     $output .= "</select>";
    //     echo $output;
    // }

    public static function ajouter_client()
    {
        if (isset($_POST['btn_ajouter_client'])) {

            if (isset($_POST['id_client'])) {
                // mod()
                self::modifier_client();
            } else {
                // Ajouter
                self::createClient();
            }
        }
    }

    public static function createClient()
    {
        extract($_POST);
        $msg = "";
        if (empty($nom_client) || empty($telephone_client)) {
            $msg =  '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_client)) {
            $msg = '2&Le numéro de téléphone invalide !';
            // $msg = mb_strlen($telephone_client);
        } elseif (Soutra::existe("client", "telephone_client", $telephone_client)) {
            $msg = '2&Le numero téléphone ' . $telephone_client . ' existe déjà !';
        } else {
            $date = date('Y-m-d');
            $code = self::checkCode();
            $data = array(
                'nom_client' => strtoupper($nom_client),
                'email_client' => $email_client,
                'adresse_client' => $adresse_client,
                'telephone_client' => $telephone_client,
                'employe_id' => $_SESSION['id_employe'],
                'etat_client' => 1,
                'code_client' => $code,
                'created_at' => $date
            );
            //var_dump($data);die();
            if (Soutra::insert("client", $data)) {
                $msg = "1&Client enregistré avec succès.";
            } else {
                $msg = '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_client()
    {
        extract($_POST);
        $msg = "";

        if (empty($nom_client) || empty($telephone_client)) {
            $msg = '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_client)) {
            $msg = '2&Le numéro de téléphone invalide !';
        } elseif (Soutra::existe("client", "telephone_client", $telephone_client) && Soutra::libelle("client", "ID_client", "telephone_client", $telephone_client) != $id_client) {
            $msg = '2&Le numero de téléphone ' . $telephone_client . ' existe déjà !';
        } else {
            $data = array(
                'nom_client' => strtoupper($nom_client),
                'email_client' => $email_client,
                'adresse_client' => $adresse_client,
                'telephone_client' => $telephone_client,
                'ID_client' => $id_client
            );
            //var_dump($data);die();
            if (Soutra::update("client", $data)) {
                $msg = "1&Client modifié avec succès.";
            } else {
                $msg = '2&Une erreur est survenue !';
            }
        }
        echo $msg;
    }

    public static function suppresion_client()
    {
        if (isset($_POST['btn_supprimer_client'])) {

            $data = array(
                'etat_client' => 0,
                'ID_client' => $_POST['id_client']
            );
            Soutra::update("client", $data);
            echo 1;
        }
    }

    public static function ajouter_versement()
    {
        if (isset($_POST['btn_ajouter_versement'])) {

            extract($_POST);
            $msg = "";

            if (empty($montant_versement)) {
                $msg =  '2&Veuillez remplir tous les champs !';
            } elseif (!Soutra::verif_type($montant_versement)) {
                $msg = '2&Le montant invalide !';
            } else {
                $date = date('Y-m-d');
                $code = self::checkCodeVersement();
                $data_versement = array(
                    'montant_versement' => $montant_versement,
                    'client_id' => $client,
                    'employe_id' => $_SESSION['id_employe'],
                    'etat_versement' => 1,
                    'code_versement' => $code,
                    'created_at' => $date
                );

                $connect = Soutra::getConnexion();
                $connect->query("SET AUTOCOMMIT = 0");
                $connect->beginTransaction();
                try {

                    if (Soutra::insert("versement", $data_versement)) {
                        Soutra::updateVersement($client, $montant_versement);
                        $connect->commit();

                        $montant = Soutra::getInfoClient($client);
                        $montant = number_format($montant["solde_client"], 0, ",", " ");
                        $liste = self::liste_versement($client);
                        $msg = "1 & $liste & $montant & Versement enregistré avec succès.";
                    } else {
                        $connect->rollBack();
                    }
                    // $connect->commit();
                } catch (Exception $ex) {
                    //throw $th;
                    $connect->rollBack();
                    $msg = "2&Une erreur est survenue !" . $ex->getMessage();
                }
            }
            echo $msg;
        }
    }

    public static function liste_versement($id_client)
    {
        // if(isset($_POST['btn_liste_client'])){ 
        $output = '';
        $liste_versement = Soutra::getListeVersement($id_client);

        if (!empty($liste_versement)) {
            $i = 0;
            foreach ($liste_versement as $row) {
                $i++;
                $output .= '
                <tr>
                    <td>
                        ' . $i . ' <span class="badge bg-teal">success</span>
                    </td>
                    <td>' . $row['code_versement'] . '</td>
                    <td class="text-right">' . number_format($row['montant_versement'], 0, ",", " ") . '</td>
                    <td>' . $row['code_employe'] . ' </td>
                    <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                 ';
            }
        }
        return $output;
        //   }
    }

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("client", "ID_type_client", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_client'] . '">
    //                 ' . $row['nom_client'] . ' ' . $row['prenom_client'] . ' : ' . $row['tel_client'] . '
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
    //         } elseif (Soutra::exite("client", "tel_client", $tel) && Soutra::libelle("client", "ID_client", "tel_client", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("client", "login_client", $login) && Soutra::libelle("client", "ID_client", "login_client", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("client", "email_client", $email) && Soutra::libelle("client", "ID_client", "email_client", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_client' => strtoupper($nom),
    //                 'prenom_client' => ucfirst($prenom),
    //                 'tel_client' => $tel,
    //                 'email_client' => $email,
    //                 'login_client' => $login,
    //                 'ID_client' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("client", $data)) {
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
    //                 'passe_client' => md5($passe),
    //                 'ID_client' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("client", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //client_combo
    // public static function client_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("client", "nom_client") as $row) {
    //             if ($row['ID_type_client'] != 1) {
    //                 if ($row['ID_type_client'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_client'] . '">
    //                 ' . $row['nom_client'] . ' ' . $row['prenom_client'] . ' Tel : ' . $row['tel_client'] . ' Fonction : ' . Soutra::getItem("type_client", "libelle_type_client", "ID_type_client", $row['ID_type_client']) . ' 
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