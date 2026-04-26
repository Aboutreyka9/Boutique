<?php

class ControllerFournisseur extends Connexion
{

    // connexion utilisateur


    public static function getFournisseur()
    {
        if (isset($_POST["frm_upfournisseur"])) {
            $fournisseur = Soutra::getAllByItemsa('fournisseur', 'ID_fournisseur', $_POST['id_fournisseur']);

            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="nom_fournisseur">Nom</label>
               <input type="text" name="nom_fournisseur" value="' . $fournisseur['nom_fournisseur'] . '" id="nom_fournisseur" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="telephone_fournisseur">Telephone</label>
              <input type="text" name="telephone_fournisseur" value="' . $fournisseur['telephone_fournisseur'] . '" id="telephone_fournisseur" class="form-control">
              <input type="hidden" name="id_fournisseur" value="' . $fournisseur['ID_fournisseur'] . '" class="form-control">
            </div>
          </div>
            <div class="col-md-12">
            <div class="form-group">
              <label for="email_fournisseur">Email</label>
              <input type="email" name="email_fournisseur" value="' . $fournisseur['email_fournisseur'] . '" id="email_fournisseur" class="form-control">
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <label for="adresse_fournisseur">Adresse</label>
              <textarea rows="3" name="adresse_fournisseur" class="form-control">' . $fournisseur['adresse_fournisseur'] . '</textarea>
            </div>
          </div>
            ';


            echo json_encode(['data' => $output]);
        }
    }

    public static function liste_fournisseur()
    {
        if (isset($_POST['btn_liste_fournisseur'])) {
            $output = '';
            $fournisseur = Soutra::getAllFournisseurEntrepot();
            if (!empty($fournisseur)) {
                $i = 0;
                foreach ($fournisseur as $row) {
                    $i++;
                    $output .= '
                <tr class="row' . $row['ID_fournisseur'] . '">
               <td>' . $i . '</td>
               <td>' . checkEtatData($row['etat_fournisseur']) . '</td>
               <td>' . $row['nom_fournisseur'] . '</td>
               <td>' . $row['telephone_fournisseur'] . '</td>
               <td>' . $row['email_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


                    $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                 <a  href="' . URL . 'fournisseur_profile&id=' . $row['ID_fournisseur'] . '" class="btn btn-success btn-link btn-sm " data-toggle="tooltip" title="" data-original-title="Voir details fournisseur">
                  <i class="fa fa-eye text-icon-success"></i> </a>

            <button data-id="' . $row['ID_fournisseur'] . '" class="btn btn-primary btn-sm btn_update_fournisseur">
            <i class="fa fa-edit"></i>  </button> ';

                    if (isAdminGestionnaire()) {
                        $output .= '<div class="d-inline">
                <button data-id="' . $row['ID_fournisseur'] . '" class="btn btn-warning btn-sm btn_remove_fournisseur">
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

    public static function checkCode()
    {
        $code = "FS" . date('y') . date('d') . rand(199, 9999);
        if (!empty(Soutra::libelleExiste('fournisseur', 'code_fournisseur', $code))) {
            self::checkCode();
        }
        return $code;
    }

    public static function activation()
    {
        if (isset($_POST['active_fournisseur'])) {
            if ($_POST['etat'] == 1) {
                $data = array(
                    'etat_fournisseur' => 0,
                    'ID_fournisseur' => $_POST['id']
                );
                if (Soutra::update("fournisseur", $data)) {
                    echo 1;
                } else {
                    echo 3;
                }
            } elseif ($_POST['etat'] == 0) {
                $data = array(
                    'etat_fournisseur' => 1,
                    'ID_fournisseur' => $_POST['id']
                );
                if (Soutra::update("fournisseur", $data)) {
                    echo 2;
                } else {
                    echo 3;
                }
            }
        }
    }

    public static function ajouter_fournisseur()
    {
        if (isset($_POST['btn_ajouter_fournisseur'])) {

            if (isset($_POST['id_fournisseur'])) {
                // mod()
                self::modifier_fournisseur();
            } else {
                // Ajouter
                self::createfournisseur();
            }
        }
    }

    public static function createFournisseur()
    {
        extract($_POST);
        $msg = "";
        if (empty($nom_fournisseur) || empty($telephone_fournisseur)) {
            $msg =  '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_fournisseur)) {
            $msg = '2&Le numéro de téléphone invalide !';
            // $msg = mb_strlen($telephone_fournisseur);
        } elseif (Soutra::existe("fournisseur", "telephone_fournisseur", $telephone_fournisseur)) {
            $msg = '2&Le numero téléphone ' . $telephone_fournisseur . ' existe déjà !';
        } else {
            $date = date('Y-m-d');
            $code = self::checkCode();
            $data = array(
                'nom_fournisseur' => strtoupper($nom_fournisseur),
                'telephone_fournisseur' => $telephone_fournisseur,
                'email_fournisseur' => $email_fournisseur,
                'adresse_fournisseur' => $adresse_fournisseur,
                'code_fournisseur' => $code,
                'etat_fournisseur' => 1,
                'created_at' => $date
            );
            //var_dump($data);die();
            if (Soutra::insert("fournisseur", $data)) {
                $msg = "1&Fournisseur enregistré avec succès.";
            } else {
                $msg = '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_fournisseur()
    {
        extract($_POST);
        $msg = "";

        if (empty($nom_fournisseur) || empty($telephone_fournisseur)) {
            $msg = '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_fournisseur)) {
            $msg = '2&Le numéro de téléphone invalide !';
        } elseif (Soutra::existe("fournisseur", "telephone_fournisseur", $telephone_fournisseur) && Soutra::libelle("fournisseur", "ID_fournisseur", "telephone_fournisseur", $telephone_fournisseur) != $id_fournisseur) {
            $msg = '2&Le numero de téléphone ' . $telephone_fournisseur . ' existe déjà !';
        } else {
            $data = array(
                'nom_fournisseur' => strtoupper($nom_fournisseur),
                'telephone_fournisseur' => $telephone_fournisseur,
                'email_fournisseur' => $email_fournisseur,
                'adresse_fournisseur' => $adresse_fournisseur,
                'ID_fournisseur' => $id_fournisseur
            );

            if (Soutra::update("fournisseur", $data)) {
                $msg = "1&Fournisseur modifié avec succès.";
            } else {
                $msg = '2&Une erreur est survenue !';
            }
        }
        echo $msg;
    }

    public static function suppresion_fournisseur()
    {
        if (isset($_POST['btn_supprimer_fournisseur'])) {

            $data = array(
                'etat_fournisseur' => 0,
                'ID_fournisseur' => $_POST['id_fournisseur']
            );
            Soutra::update("fournisseur", $data);
            echo 1;
        }
    }


    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("fournisseur", "ID_type_fournisseur", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_fournisseur'] . '">
    //                 ' . $row['nom_fournisseur'] . ' ' . $row['prenom_fournisseur'] . ' : ' . $row['tel_fournisseur'] . '
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
    //         } elseif (Soutra::exite("fournisseur", "tel_fournisseur", $tel) && Soutra::libelle("fournisseur", "ID_fournisseur", "tel_fournisseur", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("fournisseur", "login_fournisseur", $login) && Soutra::libelle("fournisseur", "ID_fournisseur", "login_fournisseur", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("fournisseur", "email_fournisseur", $email) && Soutra::libelle("fournisseur", "ID_fournisseur", "email_fournisseur", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_fournisseur' => strtoupper($nom),
    //                 'prenom_fournisseur' => ucfirst($prenom),
    //                 'tel_fournisseur' => $tel,
    //                 'email_fournisseur' => $email,
    //                 'login_fournisseur' => $login,
    //                 'ID_fournisseur' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("fournisseur", $data)) {
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
    //                 'passe_fournisseur' => md5($passe),
    //                 'ID_fournisseur' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("fournisseur", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //fournisseur_combo
    // public static function fournisseur_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("fournisseur", "nom_fournisseur") as $row) {
    //             if ($row['ID_type_fournisseur'] != 1) {
    //                 if ($row['ID_type_fournisseur'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_fournisseur'] . '">
    //                 ' . $row['nom_fournisseur'] . ' ' . $row['prenom_fournisseur'] . ' Tel : ' . $row['tel_fournisseur'] . ' Fonction : ' . Soutra::getItem("type_fournisseur", "libelle_type_fournisseur", "ID_type_fournisseur", $row['ID_type_fournisseur']) . ' 
    //             </option>';
    //                 }
    //             }
    //         }
    //         //$output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
    // }


    public static function get_fournisseur_info()
    {
        if (isset($_POST['btn_get_fournisseur'], $_POST['id_fournisseur'])) {
            $id = $_POST['id_fournisseur'];
            $fournisseur = Soutra::getInfoFournisseur($id); // méthode similaire à getAllfournisseur mais pour 1 seul

            if (!empty($fournisseur)) {
                $output = '';
                $output .= '<p><strong>Code :</strong> ' . $fournisseur['code_fournisseur'] . '</p>';
                $output .= '<p><strong>Nom :</strong> ' . $fournisseur['nom_fournisseur'] . '</p>';
                $output .= '<p><strong>Téléphone :</strong> ' . $fournisseur['telephone_fournisseur'] . '</p>';
                $output .= '<p><strong>Créé le :</strong> ' . Soutra::date_format($fournisseur['created_at']) . '</p>';

                echo $output;
            } else {
                echo '<p class="text-danger">Fournisseur introuvable</p>';
            }
        }
    }

    public static function getFournisseurForAchat()
    {
        if (isset($_POST["btn_search_fournisseur_achat"])) {
            $msg["code"] = 400;
            if (!empty($_POST['id_fournisseur'])) {

                $fournisseur = Soutra::getAllByItemsa('fournisseur', 'ID_fournisseur', $_POST['id_fournisseur']);
                $msg["code"] = 200;
                $msg["fournisseur"] = $fournisseur;
            }
            echo json_encode($msg);
        }
    }
}

//fin de la class
