<?php

class ControllerEmploye extends Connexion
{

    // connexion utilisateur
    public static function authentification()
    {
        if (isset($_POST["btn_connexion"])) {
            extract($_POST);
            $msg['code'] = 400;

            if (empty(htmlspecialchars(trim($telephone)))) {
                $msg['message'] = "Numero utilisateur requis !";
            } elseif (empty(htmlspecialchars(trim($password)))) {
                $msg['message'] = "Mot de passe requis !";
            } else {
                $msg['message'] = "Nom utilisateur ou mot de passe incorect !";
                $emp = Soutra::loginEmployer($telephone, md5($password));
                if (!empty($emp)) {
                    $_SESSION["id_employe"] = $emp["ID_employe"];
                    $_SESSION["role"] = $emp["role"];
                    $_SESSION["nom"] = $emp["nom_employe"];
                    $_SESSION["id_entrepot"] = $emp["ID_entrepot"] ?? null;
                    Soutra::update("employe", ['login' => date("Y-m-d h:i:s"), "ID_employe" => $emp['ID_employe']]);
                    $msg['code'] = 200;
                    $msg['message'] = "Connexion réussie";
                }
            }
            echo json_encode($msg);
        }
    }

    public static function logout()
    {
        if (isset($_POST["btn_deconnexion"])) {

            $_SESSION = [];
            session_destroy();
            $msg['code'] = 200;
            $msg['message'] = "Déconnexion réussie";
            echo json_encode($msg);
        }
    }

    public static function getEmploye()
    {
        if (isset($_POST["frm_upemploye"])) {
            $employe = Soutra::getAllByItemsa('employe', 'ID_employe', $_POST['id_employe']);
            $roles = Soutra::getAllTable('role', 'etat_role', 1);
            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="nom_employe">Nom</label>
               <input type="text" name="nom_employe" value="' . $employe['nom_employe'] . '" id="nom_employe" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="prenom_employe">Prenoms</label>
               <input type="text" name="prenom_employe" value="' . $employe['prenom_employe'] . '" id="prenom_employe" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="telephone_employe">Telephone</label>
              <input type="text" name="telephone_employe" value="' . $employe['telephone_employe'] . '" id="telephone_employe" class="form-control">
              <input type="hidden" name="id_employe" value="' . $employe['ID_employe'] . '" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_employe">Role</label>
              <select name="role_employe" id="role_employe" class="form-control" id="">
              ';
            foreach ($roles as $row) {
                $selected = $employe["role_id"] == $row["ID_role"] ? " selected" : "";
                $output .= '
                <option ' . $selected . '  value="' . $row['ID_role'] . '">' . $row['libelle_role'] . '</option>
                ';
            }
            $output .= '
              </select>
            </div>
          </div>
            ';


            echo $output;
        }
    }


    // public static function etat_employe() {
    //     if (isset($_POST["etat_utilisateur"])) {
    //         echo (Employe::verrif_etat_user($_SESSION["ISPWB"]));
    //     }
    // }

    // public static function liste_type() {
    //     $output = '';
    //     if (!empty(Soutra::getAllByItem3("type_employe", "ID_type_employe", 1))) {
    //         $i = 0;
    //         foreach (Soutra::getAllByItem3("type_employe", "ID_type_employe", 1) as $row) {
    //             $i++;
    //             $output .= '
    //             <tr>
    //                <td>' . $i . '</td>
    //                <td>' . $row['libelle_type_employe'] . '</td>
    //                <td>
    //                   <button type="button" libelle="' . $row['libelle_type_employe'] . '" ID="' . $row['ID_type_employe'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_employe">
    //                       <i class="fa fa-edit"></i> Modifier
    //                   </button>
    //                </td>
    //              </tr>
    //              ';
    //         }
    //     }
    //     echo $output;
    // }

    public static function liste_employe()
    {
        if (isset($_POST['btn_liste_employe'])) {
            $output = '';
            $emp = Soutra::getAllEmployer($_SESSION['id_employe']);
            if (!empty($emp)) {
                $i = 0;
                foreach ($emp as $row) {
                    $i++;
                    $output .= '
                <tr class="row' . $row['ID_employe'] . '">
                   <td>' . $i . '</td>
                   <td>' . $row['code_employe'] . '</td>
                   <td>' . $row['nom_employe'] . '</td>
                   <td>' . $row['prenom_employe'] . '</td>
                   <td>' . $row['telephone_employe'] . '</td>
                   <td>' . $row['role'] . '</td>';

                    $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                   <button data-id="' . $row['ID_employe'] . '" class="btn btn-primary btn-sm btn_update_employe">
                   <i class="fa fa-edit"></i> modiier </button>
                   <div class="d-inline">
                       <button data-id="' . $row['ID_employe'] . '" class="btn btn-warning btn-sm btn_remove_employe">
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
    //     if (isset($_POST['active_employe'])) {
    //         if ($_POST['etat'] == 1) {
    //             $data = array(
    //                 'etat_employe' => 0,
    //                 'ID_employe' => $_POST['id']
    //             );
    //             if (Soutra::update("employe", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 3;
    //             }
    //         } elseif ($_POST['etat'] == 0) {
    //             $data = array(
    //                 'etat_employe' => 1,
    //                 'ID_employe' => $_POST['id']
    //             );
    //             if (Soutra::update("employe", $data)) {
    //                 echo 2;
    //             } else {
    //                 echo 3;
    //             }
    //         }
    //     }
    // }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_employe" class="form-control">';
    //         foreach (Soutra::getAll("type_employe", "libelle_type_employe") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_employe'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_employe'] != 1 && $row['ID_type_employe'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
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
    //         foreach (Soutra::getAll("type_employe", "libelle_type_employe") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_employe'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_employe'] != 1 && $row['ID_type_employe'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_employe", "libelle_type_employe", "ID_type_employe", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_employe", "libelle_type_employe") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_employe'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_employe'] != 1 && $row['ID_type_employe'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_employe'] . '">
    //                         ' . $row['libelle_type_employe'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }

    //     $output .= "</select>";
    //     echo $output;
    // }

    public static function ajouter_employe()
    {
        if (isset($_POST['btn_ajouter_employe'])) {
            if (isset($_POST['id_employe'])) {
                // mod();
                self::modifier_employe();
            } else {
                // Ajouter
                self::createEmploye();
            }
        }
    }

    public static function createEmploye()
    {
        extract($_POST);
        $msg = "";
        if (empty($nom_employe) || empty($prenom_employe) || empty($telephone_employe) || empty($role_employe)) {
            $msg =  '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_employe) || mb_strlen($telephone_employe) != 10) {
            $msg = '2&Le numéro de téléphone invalide !';
            // $msg = mb_strlen($telephone_employe);
        } 
        elseif (!filter_var($email_employe, FILTER_VALIDATE_EMAIL)) {
            $msg = '2&L\'email invalide !';
        } 
        
        elseif (Soutra::existe("employe", "telephone_employe", $telephone_employe)) {
            $msg = '2&Le téléphone ' . $telephone_employe . ' existe déjà !';
        } else {
            $date = "NOW()";
            $code = self::checkCode();
            $data = array(
                'nom_employe' => strtoupper($nom_employe),
                'prenom_employe' => ucfirst($prenom_employe),
                'telephone_employe' => $telephone_employe,
                'email_employe' => $email_employe,
                'role_id' => $role_employe,
                'etat_employe' => 1,
                'code_employe' => $code,
                'password_employe' => md5("123@123"),
                //'date_con'=> $date
            );
            //var_dump($data);die();
            if (Soutra::insert("employe", $data)) {
                  $mail = new ControllerMailer();
                  $nom = $nom_employe . ' ' . $prenom_employe;
                  $email = $email_employe;
                  $tel = $telephone_employe;
                  $pass = '123@123';
                  $sendMail = $mail->sendUserCredentials($email, $nom, $tel, $pass);
                  if($sendMail){
                    $msg = "1&Employé enregistré avec succès";
                  }else{
                    $msg = '2&Une erreur est survenue ! ';
                  }
            } else {
                $msg = '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_employe()
    {
        extract($_POST);
        $msg = "";

        if (empty($nom_employe) || empty($telephone_employe) || empty($prenom_employe) || empty($role_employe)) {
            $msg = '2&Veuillez remplir tous les champs !';
        } elseif (!Soutra::verif_type($telephone_employe) || mb_strlen($telephone_employe) != 10) {
            $msg = '2&Le numéro de téléphone doit être 10 chiffres !';
        } elseif (Soutra::existe("employe", "telephone_employe", $telephone_employe) && Soutra::libelle("employe", "ID_employe", "telephone_employe", $telephone_employe) != $id_employe) {
            $msg = '2&Le numero de téléphone ' . $telephone_employe . ' existe déjà !';
        } else {
            $data = array(
                'nom_employe' => strtoupper($nom_employe),
                'prenom_employe' => ucfirst($prenom_employe),
                'telephone_employe' => $telephone_employe,
                'role_id' => $role_employe,
                'ID_employe' => $id_employe
            );
            //var_dump($data);die();
            if (Soutra::update("employe", $data)) {
                $msg = "1&Employé modifié avec succès";
            } else {
                $msg = '2&Une erreur est survenue !';
            }
        }
        echo $msg;
    }

    public static function modifier_login_employe()
    {
        if (isset($_POST['btn_update_login_employe'])) {
            extract($_POST);
            $msg = "";

            if (empty($password) || empty($new_password)) {
                $msg = '2&Veuillez remplir tous les champs !';
            } else {
                $emp = Soutra::libelle("employe", "password_employe", "ID_employe", $_SESSION['id_employe']);

                if (empty($emp) || $emp != md5($password)) {
                    $msg = '2&Desolé ancien mot de passe incorrect !';
                } else {
                    $data = array(
                        'password_employe' => md5($new_password),
                        'ID_employe' => $_SESSION['id_employe']
                    );
                    if (Soutra::update("employe", $data)) {
                        $msg = "1&Mot de passe modifié avec succès";
                    } else {
                        $msg = '2&Une erreur est survenue !';
                    }
                }
            }
            echo $msg;
        }
    }

    public static function suppresion_employe()
    {
        if (isset($_POST['btn_supprimer_employe'])) {

            $data = array(
                'etat_employe' => 0,
                'ID_employe' => $_POST['id_employe']
            );
            Soutra::update("employe", $data);
            echo 1;
        }
    }

    public static function checkCode()
    {
        $code = "EM" . date('y') . date('d') . rand(19, 9999);
        if (!empty(Soutra::libelleExiste('employe', 'code_employe', $code))) {
            self::checkCode();
        }
        return $code;
    }

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("employe", "ID_type_employe", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_employe'] . '">
    //                 ' . $row['nom_employe'] . ' ' . $row['prenom_employe'] . ' : ' . $row['tel_employe'] . '
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
    //         } elseif (Soutra::exite("employe", "tel_employe", $tel) && Soutra::libelle("employe", "ID_employe", "tel_employe", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("employe", "login_employe", $login) && Soutra::libelle("employe", "ID_employe", "login_employe", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("employe", "email_employe", $email) && Soutra::libelle("employe", "ID_employe", "email_employe", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_employe' => strtoupper($nom),
    //                 'prenom_employe' => ucfirst($prenom),
    //                 'tel_employe' => $tel,
    //                 'email_employe' => $email,
    //                 'login_employe' => $login,
    //                 'ID_employe' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("employe", $data)) {
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
    //                 'passe_employe' => md5($passe),
    //                 'ID_employe' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("employe", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //employe_combo
    // public static function employe_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("employe", "nom_employe") as $row) {
    //             if ($row['ID_type_employe'] != 1) {
    //                 if ($row['ID_type_employe'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_employe'] . '">
    //                 ' . $row['nom_employe'] . ' ' . $row['prenom_employe'] . ' Tel : ' . $row['tel_employe'] . ' Fonction : ' . Soutra::getItem("type_employe", "libelle_type_employe", "ID_type_employe", $row['ID_type_employe']) . ' 
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

//fin de la class
