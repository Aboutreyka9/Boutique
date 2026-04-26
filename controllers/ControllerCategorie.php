<?php

class ControllerCategorie extends Connexion
{

    // connexion utilisateur


    public static function getCategorie()
    {
        if (isset($_POST["frm_upcategorie"])) {
            $categorie = Soutra::getAllByItemsa('categorie', 'ID_categorie', $_POST['id_categorie']);
            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="libelle_categorie">Libelle</label>
               <input type="text" name="libelle_categorie" value="' . $categorie['libelle_categorie'] . '" id="libelle_categorie" class="form-control">
            </div>
            <input type="hidden" id="id_categorie" name="id_categorie" value="' . $categorie['ID_categorie'] . '" class="form-control">
          </div>
            ';

            echo json_encode(['success' => true, 'html' => $output]);
        }
    }


    // public static function etat_categorie() {
    //     if (isset($_POST["etat_utilisateur"])) {
    //         echo (categorie::verrif_etat_user($_SESSION["ISPWB"]));
    //     }
    // }

    // public static function liste_type() {
    //     $output = '';
    //     if (!empty(Soutra::getAllByItem3("type_categorie", "ID_type_categorie", 1))) {
    //         $i = 0;
    //         foreach (Soutra::getAllByItem3("type_categorie", "ID_type_categorie", 1) as $row) {
    //             $i++;
    //             $output .= '
    //             <tr>
    //                <td>' . $i . '</td>
    //                <td>' . $row['libelle_type_categorie'] . '</td>
    //                <td>
    //                   <button type="button" libelle="' . $row['libelle_type_categorie'] . '" ID="' . $row['ID_type_categorie'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_categorie">
    //                       <i class="fa fa-edit"></i> Modifier
    //                   </button>
    //                </td>
    //              </tr>
    //              ';
    //         }
    //     }
    //     echo $output;
    // }

    public static function liste_categorie()
    {
        if (isset($_POST['btn_liste_categorie'])) {
            $output = '';
            $categorie = Soutra::getAllCategorie();
            if (!empty($categorie)) {
                $i = 0;
                foreach ($categorie as $row) {
                    $i++;
                    $etat = $row['etat_categorie'] == 1 ? "Disponible" : "Non disponible";

                    $output .= '
                  <tr class="row' . $row['ID_categorie'] . '">
               <td>' . $i . '</td>
               <td>' . $row['libelle_categorie'] . '</td>
               <td>' . $etat . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


                    $output .= '<td style="display: flex; gap: 30px;"> 
            <button data-id="' . $row['ID_categorie'] . '" class="btn btn-primary btn-link btn-sm btn_update_categorie" data-toggle="tooltip" title="" data-original-title="modifier categorie">
            <i class="fa fa-edit text-icon-primary"></i> 
    
          </button>
                <button data-id="' . $row['ID_categorie'] . '" class="btn btn-warning btn-link btn-sm btn_remove_categorie" data-toggle="tooltip" title="" data-original-title="Supprimer categorie">
                <i class="fa fa-trash text-icon-warning"></i> </button>
          </td>
             </tr>
                    ';
                }
            }
            echo $output;
        }
    }

    // public static function activation() {
    //     if (isset($_POST['active_categorie'])) {
    //         if ($_POST['etat'] == 1) {
    //             $data = array(
    //                 'etat_categorie' => 0,
    //                 'ID_categorie' => $_POST['id']
    //             );
    //             if (Soutra::update("categorie", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 3;
    //             }
    //         } elseif ($_POST['etat'] == 0) {
    //             $data = array(
    //                 'etat_categorie' => 1,
    //                 'ID_categorie' => $_POST['id']
    //             );
    //             if (Soutra::update("categorie", $data)) {
    //                 echo 2;
    //             } else {
    //                 echo 3;
    //             }
    //         }
    //     }
    // }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_categorie" class="form-control">';
    //         foreach (Soutra::getAll("type_categorie", "libelle_type_categorie") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_categorie'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_categorie'] != 1 && $row['ID_type_categorie'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
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
    //         foreach (Soutra::getAll("type_categorie", "libelle_type_categorie") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_categorie'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_categorie'] != 1 && $row['ID_type_categorie'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_categorie", "libelle_type_categorie", "ID_type_categorie", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_categorie", "libelle_type_categorie") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_categorie'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_categorie'] != 1 && $row['ID_type_categorie'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_categorie'] . '">
    //                         ' . $row['libelle_type_categorie'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }

    //     $output .= "</select>";
    //     echo $output;
    // }

    public static function ajouter_categorie()
    {
        if (isset($_POST['btn_ajouter_categorie'])) {

            if (isset($_POST['id_categorie'])) {
                // mod()
                self::modifier_categorie();
            } else {
                // Ajouter
                self::createcategorie();
            }
        }
    }

    public static function createcategorie()
    {
        extract($_POST);
        $msg = "";
        if (empty($libelle_categorie)) {
            $msg =  '2&Veuillez remplir tous les champs !';
        } elseif (Soutra::existe("categorie", "libelle_categorie", $libelle_categorie)) {
            $msg = '2&Ce libelle categorie existe déjà !';
        } else {
            $date = date('Y-m-d');
            $data = array(
                'libelle_categorie' => mb_strtoupper($libelle_categorie, 'UTF-8'),
                'etat_categorie' => 1,
                'created_at' => $datep
            );
            //var_dump($data);die();
            if (Soutra::insert("categorie", $data)) {
                $msg = "1&categorie Ajouté avec succès.";
            } else {
                $msg = '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_categorie()
    {
        extract($_POST);
        $msg = "";

        if (empty($libelle_categorie)) {
            $msg = '2&Veuillez remplir tous les champs !';
        } else {
            $categorie = Soutra::libelle("categorie", "ID_categorie", "libelle_categorie", $libelle_categorie);

            if (!empty($categorie) && $categorie != $id_categorie) {
                $msg = '2&Desolé cette categorie existe déjà !';
            } else {

                $data = array(
                    'libelle_categorie' => ucfirst($libelle_categorie),
                    'ID_categorie' => $id_categorie
                );
                if (Soutra::update("categorie", $data)) {
                    $msg = "1&categorie modifié avec succès.";
                } else {
                    $msg = '2&Une erreur est survenue !';
                }
            }
        }
        echo $msg;
    }

    public static function suppresion_categorie()
    {
        if (isset($_POST['btn_supprimer_categorie'])) {

            $data = array(
                'etat_categorie' => 0,
                'ID_categorie' => $_POST['id_categorie']
            );
            Soutra::update("categorie", $data);
            echo 1;
        }
    }

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("categorie", "ID_type_categorie", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_categorie'] . '">
    //                 ' . $row['nom_categorie'] . ' ' . $row['prenom_categorie'] . ' : ' . $row['tel_categorie'] . '
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
    //         } elseif (Soutra::exite("categorie", "tel_categorie", $tel) && Soutra::libelle("categorie", "ID_categorie", "tel_categorie", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("categorie", "login_categorie", $login) && Soutra::libelle("categorie", "ID_categorie", "login_categorie", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("categorie", "email_categorie", $email) && Soutra::libelle("categorie", "ID_categorie", "email_categorie", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_categorie' => strtoupper($nom),
    //                 'prenom_categorie' => ucfirst($prenom),
    //                 'tel_categorie' => $tel,
    //                 'email_categorie' => $email,
    //                 'login_categorie' => $login,
    //                 'ID_categorie' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("categorie", $data)) {
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
    //                 'passe_categorie' => md5($passe),
    //                 'ID_categorie' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("categorie", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //categorie_combo
    // public static function categorie_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("categorie", "nom_categorie") as $row) {
    //             if ($row['ID_type_categorie'] != 1) {
    //                 if ($row['ID_type_categorie'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_categorie'] . '">
    //                 ' . $row['nom_categorie'] . ' ' . $row['prenom_categorie'] . ' Tel : ' . $row['tel_categorie'] . ' Fonction : ' . Soutra::getItem("type_categorie", "libelle_type_categorie", "ID_type_categorie", $row['ID_type_categorie']) . ' 
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
