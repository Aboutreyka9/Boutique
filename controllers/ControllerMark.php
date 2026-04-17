<?php

class ControllerMark extends Connexion {

    // connexion utilisateur
    

     public static function getMark() {
        if (isset($_POST["frm_upmark"])) {
            $mark = Soutra::getAllByItemsa('mark','ID_mark',$_POST['id_mark']);
            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="libelle_mark">Libelle popopo</label>
               <input type="text" name="libelle_mark" value="'.$mark['libelle_mark'].'" id="libelle_mark" class="form-control">
            </div>
            <input type="hidden" id="id_mark" name="id_mark" value="'.$mark['ID_mark'].'" class="form-control">

          </div>
            ';
            
            
            echo $output;
        }
    }
  

    // public static function etat_mark() {
    //     if (isset($_POST["etat_utilisateur"])) {
    //         echo (mark::verrif_etat_user($_SESSION["ISPWB"]));
    //     }
    // }

    // public static function liste_type() {
    //     $output = '';
    //     if (!empty(Soutra::getAllByItem3("type_mark", "ID_type_mark", 1))) {
    //         $i = 0;
    //         foreach (Soutra::getAllByItem3("type_mark", "ID_type_mark", 1) as $row) {
    //             $i++;
    //             $output .= '
    //             <tr>
    //                <td>' . $i . '</td>
    //                <td>' . $row['libelle_type_mark'] . '</td>
    //                <td>
    //                   <button type="button" libelle="' . $row['libelle_type_mark'] . '" ID="' . $row['ID_type_mark'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_mark">
    //                       <i class="fa fa-edit"></i> Modifier
    //                   </button>
    //                </td>
    //              </tr>
    //              ';
    //         }
    //     }
    //     echo $output;
    // }

    public static function liste_mark() {
        if(isset($_POST['btn_liste_mark'])){ 
        $output = '';
        $mark = Soutra::getAllmark();
        if (!empty($mark)) {
            $i = 0;
            foreach ($mark as $row) {
                $i++;
                $etat = $row['etat_mark'] == 1 ? "Disponible" : "Non disponible";

                $output .= '
                <tr class="row'.$row['ID_mark'].'">
                   <td>' . $i . '</td>
                   <td>' . $row['libelle_mark'] . '</td>
                   <td>' . $etat . '</td>
                   <td>' . Soutra::date_format($row['created_at']) . '</td>
                   ';
                
                   $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                   <button data-id="'. $row['ID_mark'].'" class="btn btn-primary btn-sm btn_update_mark">
                   <i class="fa fa-edit"></i> 
    <span class="phone-btn-text">Modifier</span>
</button>
                   <div class="d-inline">
                       <button data-id="'. $row['ID_mark'].'" class="btn btn-warning btn-sm btn_remove_mark">
                       <i class="fa fa-trash"></i> <span class="phone-btn-text">Supprimer</span></button>
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
    //     if (isset($_POST['active_mark'])) {
    //         if ($_POST['etat'] == 1) {
    //             $data = array(
    //                 'etat_mark' => 0,
    //                 'ID_mark' => $_POST['id']
    //             );
    //             if (Soutra::update("mark", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 3;
    //             }
    //         } elseif ($_POST['etat'] == 0) {
    //             $data = array(
    //                 'etat_mark' => 1,
    //                 'ID_mark' => $_POST['id']
    //             );
    //             if (Soutra::update("mark", $data)) {
    //                 echo 2;
    //             } else {
    //                 echo 3;
    //             }
    //         }
    //     }
    // }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_mark" class="form-control">';
    //         foreach (Soutra::getAll("type_mark", "libelle_type_mark") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_mark'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_mark'] != 1 && $row['ID_type_mark'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
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
    //         foreach (Soutra::getAll("type_mark", "libelle_type_mark") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_mark'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_mark'] != 1 && $row['ID_type_mark'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_mark", "libelle_type_mark", "ID_type_mark", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_mark", "libelle_type_mark") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_mark'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_mark'] != 1 && $row['ID_type_mark'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_mark'] . '">
    //                         ' . $row['libelle_type_mark'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }
        
    //     $output .= "</select>";
    //     echo $output;
    // }

    public static function ajouter_mark() {
        if (isset($_POST['btn_ajouter_mark'])) {

           if (isset($_POST['id_mark'])) {
            // mod()
            self::modifier_mark();

           }else{
            // Ajouter
            self::createmark();
           }

         
        }
    }

    public static function createmark()
    {
        extract($_POST);
        $msg = "";
        if (empty($libelle_mark)) {
           $msg =  '2&Veuillez remplir tous les champs !';
        } elseif (Soutra::existe("mark", "libelle_mark", $libelle_mark)) {
            $msg = '2&Ce libelle mark existe déjà !';
        } else {
            $date = date('Y-m-d');
            $data = array(
                'libelle_mark' => strtoupper($libelle_mark),
                'etat_mark'=> 1,
                'created_at'=> $date
            );
            //var_dump($data);die();
            if (Soutra::insert("mark", $data)) {
                $msg = "1&mark Ajouté avec succès.";
            } else {
                $msg= '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_mark() {
        extract($_POST);
        $msg = "";
    
            if (empty($libelle_mark)) {
                $msg = '2&Veuillez remplir tous les champs !';
            }elseif (Soutra::existe("mark", "libelle_mark", $libelle_mark) && Soutra::libelle("mark", "ID_mark", "libelle_mark", $libelle_mark) != $id_mark) {
                $msg = '2&Le libelle mark existe déjà !';
            }else {
                $data = array(
                    'libelle_mark' => strtoupper($libelle_mark),
                    'ID_mark' => $id_mark
                );
                //var_dump($data);die();
                if (Soutra::update("mark", $data)) {
                    $msg = "1&mark modifiée avec succès.";
                } else {
                    $msg = '2&Une erreur est survenue !';
                }
            }
            echo $msg;

        
    }

    public static function suppresion_mark() {
        if (isset($_POST['btn_supprimer_mark'])) {
          
            $data = array(
                'etat_mark' => 0,
                'ID_mark' => $_POST['id_mark']
            );
            Soutra::update("mark", $data);
            echo 1;
            
        }
    }

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("mark", "ID_type_mark", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_mark'] . '">
    //                 ' . $row['nom_mark'] . ' ' . $row['prenom_mark'] . ' : ' . $row['tel_mark'] . '
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
    //         } elseif (Soutra::exite("mark", "tel_mark", $tel) && Soutra::libelle("mark", "ID_mark", "tel_mark", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("mark", "login_mark", $login) && Soutra::libelle("mark", "ID_mark", "login_mark", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("mark", "email_mark", $email) && Soutra::libelle("mark", "ID_mark", "email_mark", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_mark' => strtoupper($nom),
    //                 'prenom_mark' => ucfirst($prenom),
    //                 'tel_mark' => $tel,
    //                 'email_mark' => $email,
    //                 'login_mark' => $login,
    //                 'ID_mark' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("mark", $data)) {
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
    //                 'passe_mark' => md5($passe),
    //                 'ID_mark' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("mark", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //mark_combo
    // public static function mark_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("mark", "nom_mark") as $row) {
    //             if ($row['ID_type_mark'] != 1) {
    //                 if ($row['ID_type_mark'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_mark'] . '">
    //                 ' . $row['nom_mark'] . ' ' . $row['prenom_mark'] . ' Tel : ' . $row['tel_mark'] . ' Fonction : ' . Soutra::getItem("type_mark", "libelle_type_mark", "ID_type_mark", $row['ID_type_mark']) . ' 
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
