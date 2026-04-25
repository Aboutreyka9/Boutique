<?php

class ControllerArticle extends Connexion
{

    // connexion utilisateur


    public static function createAntrepotArticle()
    {
        if (isset($_POST['btn_attribuer_entrepot_article'])) {

            extract($_POST);
            $msg["code"] = 400;
            $msg["message"] = "";

            if (empty($id_article) || empty($id_entrepot) || empty($prix_achat) || empty($prix_vente) || empty($stock_alert)) {
                $msg["message"] = "Veuillez renseigner tous les champs !";
            } elseif (!Soutra::verif_type($prix_achat) || $prix_achat < 0) {
                $msg["message"] = "Le Prix d'achat invalide !";
            } elseif (!Soutra::verif_type($prix_vente) || $prix_vente < 0) {
                $msg["message"] = "Le prix de vente invalide !";
            } elseif (!Soutra::verif_type($stock_alert) || $stock_alert < 0) {
                $msg["message"] = "La valeur du stock alert invalide!";
            } elseif (Soutra::exist2("entrepot_article", "entrepot_id", "article_id", $id_entrepot, $id_article)) {
                $msg["message"] = "Cet article existe déjà dans cet entrepôt !";
            } else {
                $date = date('Y-m-d');

                $dataArticle = array(
                    'article_id' => strtoupper($id_article),
                    'entrepot_id' => $id_entrepot,
                    'prix_achat' => $prix_achat,
                    'prix_vente' => $prix_vente,
                    'stock_alert' => $stock_alert,
                    'garantie_article' => $garantie_article ?? 0,
                    'etat_article' => 1,
                    'created_at' => $date
                );
                $dataMouvement = [
                    'article_id' => $id_article,
                    'entrepot_id' => $id_entrepot,
                    'employe_id' => $_SESSION["id_employe"],
                    'quantite' => 0,
                    'prix_achat' => $prix_achat,
                    'prix_vente' => $prix_vente,
                    'type_mouvement' => 'INVENTAIRE',
                    'date_mouvement' => $date
                ];
                // var_dump($dataArticle);
                // var_dump($dataMouvement);return
                // utiliser la fonction transaction
                $result = Soutra::transactionData(function () use ($dataArticle, $dataMouvement) {
                    $articleId = Soutra::inserted("entrepot_article", $dataArticle);
                    Soutra::insert("mouvement_stock", $dataMouvement);
                });
                // etape 1 : creation du article
                //etape 2 : enregistrement dans la table mouvement_stock
                if ($result) {
                    $msg['code'] = 200;
                    $msg["message"] = "Opération effectuée avec succès.";
                } else {
                    $msg["message"] = 'Une erreur est survenue !';
                }
            }
            echo json_encode($msg);
        }
    }


    public static function modalAttributionArticle()
    {
        if (isset($_POST["frm_attribution_action"])) {
            $output = "";
            $output_article = "";
            $output_entrepot = "";
            if ($_POST["frm_attribution_action"] == "article") {

                $article = Soutra::getByItem('article', 'ID_article', $_POST["id_action"]);
                $output_article .= '<label for="libelle_article">Libelle</label> <input type="text" readonly value="' . $article['libelle_article'] . '" class="form-control"> <input type="hidden" name="id_article" value="' . $article['ID_article'] . '">';

                $entrepots = Soutra::getAllTable('entrepot', 'etat_entrepot', 1);
                $output_entrepot .= '<label for="entrepot_id">Entrepot</label> <select name="id_entrepot" id="id_entrepot" class="form-control entrepot_search"> <option value="default"> --- Choisir un entrepot ---</option>';
                foreach ($entrepots as $row) {
                    $output_entrepot .= ' <option value="' . $row['ID_entrepot'] . '">' . $row['libelle_entrepot'] . '</option>';
                }
                $output_entrepot .= '</select>';
            } elseif ($_POST["frm_attribution_action"] == "entrepot") {

                $entrepot = Soutra::getByItem('entrepot', 'ID_entrepot', $_POST["id_action"]);

                $output_entrepot .= '<label for="libelle_entrepot">Entrepot </label> <input type="text" readonly value="' . $entrepot['libelle_entrepot'] . '" class="form-control"> <input type="hidden" name="id_entrepot" value="' . $entrepot['ID_entrepot'] . '">';

                $articles = Soutra::getAllTable('article', 'etat_article', 1);
                $output_article .= '
                 <label for="article_id">Article</label>
              <select name="id_article" id="article_id" class="form-control article_search">
              <option value="default"> --- Choisir un article ---</option>';
                foreach ($articles as $row) {
                    $output_article .= '
                    <option value="' . $row['ID_article'] . '">' . $row['libelle_article'] . '</option>
                    ';
                }

                $output_article .= '</select>';
            } else {
                $output_article = "";
            }

            // $entrepot = Soutra::getAllTable('entrepot', 'etat_entrepot', 1);

            $output = '
            <form action="" id="form_add_attribuer_entrepot_article" method="POST">
            <div class="row">
             <div class="col-md-6">
            <div class="form-group">';
            $output .= $output_article;
            $output .= '
            </div>
            </div>
        
             <div class="col-md-6">
            <div class="form-group">
              ' . $output_entrepot . '
            </div>
            </div>
            
            <div class="col-md-6">
            <div class="form-group">
              <label for="prix_achat">Prix achat</label>
               <input type="number" name="prix_achat"  min="0" id="prix_achat" class="form-control">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="prix_vente">Prix vente</label>
               <input type="number" name="prix_vente" min="0" id="prix_vente" class="form-control">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="stock_alert">Stock Alert</label>
               <input type="number" name="stock_alert" min="0" id="stock_alert" class="form-control">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="garantie_article">Garantie (Mois)</label>
               <input type="number" name="garantie_article" min="0" id="garantie_article" class="form-control">
            </div>
            </div>
            <div class="col-md-12 modal_footer">
              <input type="hidden" name="btn_attribuer_entrepot_article">

           <button type="submit" class="btn btn-primary w-25"> <i class="fa fa-save"></i> Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
            </div>
            </div>
            </form>
            

            ';


            echo json_encode(['data' => $output]);
        }
    }

    public static function getarticle()
    {
        if (isset($_POST["frm_uparticle"])) {
            $article = Soutra::getAllByItemsa('article', 'ID_article', $_POST['id_article']);
            $mark = Soutra::getAllTable('mark', 'etat_mark', 1);
            $unite = Soutra::getAllTable('unite', 'etat_unite', 1);
            $famille = Soutra::getAllTable('famille', 'etat_famille', 1);

            $output = '
             <div class="col-md-6">
            <div class="form-group">
              <label for="libelle_article">Libelle</label>
               <input type="text" name="libelle_article" value="' . $article['libelle_article'] . '" id="libelle_article" class="form-control">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="slug">Slug</label>
               <input type="text" name="slug" value="' . $article['slug'] . '" id="slug" class="form-control">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
              <label for="famille_id">Famille</label>
              <select name="famille_id" id="famille_id" class="form-control">
              ';
            foreach ($famille as $row) {
                $selected = $article["famille_id"] == $row["ID_famille"] ? " selected" : "";
                $output .= '
                <option ' . $selected . '  value="' . $row['ID_famille'] . '">' . $row['libelle_famille'] . '</option>
                ';
            }

            $output .= '
                
              </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <label for="mark_id">Mark</label>
            <select name="mark_id" id="mark_id" class="form-control">
            ';

            foreach ($mark as $row) {
                $selected = $article["mark_id"] == $row["ID_mark"] ? " selected" : "";
                $output .= '
              <option ' . $selected . '  value="' . $row['ID_mark'] . '">' . $row['libelle_mark'] . '</option>
              ';
            }
            $output .= '
            </select>
            </div>
            </div>
           <div class="col-md-4">
            <div class="form-group">
              <label for="unite">Uinité</label>
              <select name="unite" id="unite" class="form-control">
              ';
            foreach ($unite as $row) {
                $selected = $article["unite_id"] == $row["ID_unite"] ? " selected" : "";
                $output .= '
                <option ' . $selected . '  value="' . $row['ID_unite'] . '">' . $row['libelle_unite'] . '</option>
                ';
            }
            $output .= '
            </select>
            </div>
            </div>
            
            <input type="hidden" name="id_article" value="' . $article['ID_article'] . '" id="id_article" class="form-control">

            ';


            echo json_encode(['data' => $output]);
        }
    }

    public static function liste_article()
    {
        if (isset($_POST['btn_liste_article'])) {
            $output = '';
            $article = Soutra::getAllarticle();
            if (!empty($article)) {
                $i = 0;
                foreach ($article as $row) {
                    $i++;
                    //$etat = $row['etat_article'] == 1 ? "Disponible" : "Non disponible";
                    $output .= '
            <tr class="row' . $row['ID_article'] . '">
               <td>' . $i . '</td>
               <td>' . $row['libelle_article'] . '</td>
               <td>' . $row['famille'] . '</td>
               <td>' . $row['mark'] . '</td>
               <td>' . $row['unite'] . '</td>
               ';


                    $output .= '<td style="display: flex; flex-direction: row; align-items: center; gap: 10px;"> 
            <button data-id="' . $row['ID_article'] . '" title="Modifier article" class="btn btn-primary btn-sm btn_update_article">
            <i class="fa fa-edit"></i> </button>

            <button data-id="' . $row['ID_article'] . '" title="Atribuer article" class="btn btn-success btn-sm btn_attribuer_article"  data-action="article">
            <i class="fa fa-link"></i></button>
            
            <button data-id="' . $row['ID_article'] . '" title="Supprimer article" class="btn btn-warning btn-sm btn_remove_article">
            <i class="fa fa-trash"></i></button>
          </td>
             </tr>
             ';
                }
            }
            echo $output;
        }
    }


    public static function ajouter_article()
    {
        if (isset($_POST['btn_ajouter_article'])) {

            if (isset($_POST['id_article'])) {
                // mod()
                self::modifier_article();
            } else {
                // Ajouter
                self::createarticle();
            }
        }
    }

    public static function createarticle()
    {
        extract($_POST);
        $msg = "";
        if (empty($libelle_article) || empty($famille_id)) {
            $msg =  '2&Veuillez renseigner les champs obligatoires (*) !';
        } elseif (Soutra::existe("article", "libelle_article", $libelle_article)) {
            $msg = '2&Ce libelle article existe déjà !';
        } else {
            $date = date('Y-m-d');

            $dataArticle = array(
                'libelle_article' => strtoupper($libelle_article),
                'famille_id' => $famille_id,
                'mark_id' => $mark_id,
                'slug' => $slug,
                'unite_id' => $unite,
                'etat_article' => 1,
            );

            // utiliser la fonction transaction
            if (Soutra::inserted("article", $dataArticle)) {
                $msg = "1&Article Ajouté avec succès.";
            } else {
                $msg = '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_article()
    {
        extract($_POST);
        $msg = "";

        if (empty($libelle_article) || empty($famille_id) || empty($mark_id) || empty($unite)) {
            $msg = '2&Veuillez ressaisir les champs obligatoires (*) !';
        } elseif (Soutra::existe("article", "libelle_article", $libelle_article) && Soutra::libelle("article", "ID_article", "libelle_article", $libelle_article) != $id_article) {
            $msg = '2&Ce libelle existe déjà !';
        } else {
            $data = array(
                'libelle_article' => strtoupper($libelle_article),
                'famille_id' => $famille_id,
                'mark_id' => $mark_id,
                'slug' => strtoupper($slug),
                'unite_id' => $unite,
            );
            //var_dump($data);die();
            if (Soutra::updated("article", $data, [
                'ID_article' => $id_article
            ])) {
                $msg = "1&Article modifié avec succès.";
            } else {
                $msg = '2&Une erreur est survenue !';
            }
        }
        echo $msg;
    }

    public static function suppresion_article()
    {
        if (isset($_POST['btn_supprimer_article'])) {

            $data = array(
                'etat_article' => 0,
                'ID_article' => $_POST['id_article']
            );
            Soutra::update("article", $data);
            echo 1;
        }
    }

    // public static function enseignant_combobox() {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("article", "ID_type_article", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_article'] . '">
    //                 ' . $row['nom_article'] . ' ' . $row['prenom_article'] . ' : ' . $row['tel_article'] . '
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
    //         } elseif (Soutra::exite("article", "tel_article", $tel) && Soutra::libelle("article", "ID_article", "tel_article", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("article", "login_article", $login) && Soutra::libelle("article", "ID_article", "login_article", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("article", "email_article", $email) && Soutra::libelle("article", "ID_article", "email_article", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_article' => strtoupper($nom),
    //                 'prenom_article' => ucfirst($prenom),
    //                 'tel_article' => $tel,
    //                 'email_article' => $email,
    //                 'login_article' => $login,
    //                 'ID_article' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("article", $data)) {
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
    //                 'passe_article' => md5($passe),
    //                 'ID_article' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("article", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
    // }

    //article_combo
    // public static function article_combobox() {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("article", "nom_article") as $row) {
    //             if ($row['ID_type_article'] != 1) {
    //                 if ($row['ID_type_article'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_article'] . '">
    //                 ' . $row['nom_article'] . ' ' . $row['prenom_article'] . ' Tel : ' . $row['tel_article'] . ' Fonction : ' . Soutra::getItem("type_article", "libelle_type_article", "ID_type_article", $row['ID_type_article']) . ' 
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
