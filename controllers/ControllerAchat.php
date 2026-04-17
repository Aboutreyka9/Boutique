<?php

class ControllerAchat extends Connexion
{

  // connexion utilisateur


  public static function getAchat()
  {
    if (isset($_POST["frm_upachat"])) {

      $id_entree = $_POST['id_achat'];
      $article = Soutra::getSingleAchatArticle($id_entree);
      $approvision = Soutra::getAllTable('entree', 'ID_entree', $id_entree);

      $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="article_id">Famille</label>
              <select disabled id="article_id" class="form-control" id="">
              ';
      $output .= '
                <option   value="' . $article['ID_article'] . '">' . $article['libelle_article'] . ' - ' . $article['mark'] . '</option>
                ';

      $output .= '
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="prix_achat">Prix Achat</label>
               <input disabled type="number" min="0"  value="' . $approvision[0]['prix_achat'] . '" id="prix_achat" class="form-control">
            </div>
            <input type="hidden"  name="id_approvision" value="' . $approvision[0]['ID_entree'] . '" class="form-control">

          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="qte">Quantité</label>
               <input type="number" min="0" name="qte" value="' . $approvision[0]['qte'] . '" id="qte" class="form-control">
            </div>
          </div>
            ';


      echo $output;
    }
  }


  // public static function etat_achat() {
  //     if (isset($_POST["etat_utilisateur"])) {
  //         echo (achat::verrif_etat_user($_SESSION["ISPWB"]));
  //     }
  // }

  // public static function liste_type() {
  //     $output = '';
  //     if (!empty(Soutra::getAllByItem3("type_achat", "ID_type_achat", 1))) {
  //         $i = 0;
  //         foreach (Soutra::getAllByItem3("type_achat", "ID_type_achat", 1) as $row) {
  //             $i++;
  //             $output .= '
  //             <tr>
  //                <td>' . $i . '</td>
  //                <td>' . $row['libelle_type_achat'] . '</td>
  //                <td>
  //                   <button type="button" libelle="' . $row['libelle_type_achat'] . '" ID="' . $row['ID_type_achat'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_achat">
  //                       <i class="fa fa-edit"></i> Modifier
  //                   </button>
  //                </td>
  //              </tr>
  //              ';
  //         }
  //     }
  //     echo $output;
  // }

  public static function liste_achat_detail($code_achat)
  {
    $output = '';
    $detail = Soutra::getDetailAchat($code_achat);

    if (!empty($detail)) {
      $i = 0;
      foreach ($detail as $row) {
        $i++;
        $output .= '
              <tr class="row' . $row['ID_entree'] . '">
                 <td class="col id d_none">' . $row['ID_entree'] . '</td>
                 <td>' . $i . '</td>
                 <td>' . $row['article'] . '</td>
                 <td>' . $row['mark'] . '</td>
                <td>' . $row['famille'] . '</td>
                <td class="pu">' . number_format($row['prix_achat'], 0, ",", " ") . '</td>
                <td class="qte">' . $row['qte'] . '</td>
                <td class="total">' . number_format($row['prix_achat'] * $row['qte'], 0, ",", " ") . '</td>
                 ';

        $output .= '
                 <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                 <button data-id="' . $row['ID_entree'] . '" class="btn btn-primary btn-sm btn_update_achat">
                  <i class="fa fa-edit"></i> modifier</button>
                 <div class="d-inline">
                     <button data-id="' . $row['ID_entree'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_achat_detail">
                     <i class="fa fa-trash"></i> </button>
                 </div>';

        $output .= '   
               </td>
                  </tr>
                  ';
      }
    }
    return $output;
  }

  public static function liste_detail_achat_fournisseur()
  {
    if (isset($_POST["btn_achat_fournisseur"])) {
      $id = $_POST["codeachat"];

      $detail = Soutra::getDetailAchat($id);

      $output = "";
      foreach ($detail as $row) {

        $output .= '
            <tr>
              <td>' . $row['article'] . '</td>
              <td>' . $row['mark'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td class="pu">' . number_format($row['prix_achat'], 0, ",", " ") . '</td>
              <td class="qte">' . $row['qte'] . '</td>
              <td class="total">' . number_format($row['prix_achat'] * $row['qte'], 0, ",", " ") . '</td>
            </tr>
                ';
      }
      echo $output;
    }
  }


  public static function ajouter_panier_achat()
  {
    if (isset($_POST['btn_ajouter_panier_achat'])) {
      $output = '';
      if (!empty($_POST['article'])) {
        $achat = Soutra::getPanierAchat(implode(',', $_POST['article']), $_SESSION['id_entrepot']);
        if (!empty($achat)) {
          $i = 0;
          foreach ($achat as $row) {
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

  public static function validation_achat()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_validation_achat") {
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

  public static function encaissement_achat()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_encaisser_achat") {
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





  public static function retourner_achat()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_retourner_achat") {
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
  public static function annulation_achat()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_annuler_achat") {
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

  public static function createAchat()
  {
    extract($_POST);
    $verifEmpty = false;
    $verifType = false;

    for ($i = 0; $i < count($pu); $i++) {
      if (empty(trim($pu[$i])) || empty(trim($qte[$i])) || empty($total[$i])) {
        $verifEmpty = true;
      } elseif (!ctype_digit($pu[$i]) || !ctype_digit($qte[$i]) || $qte[$i] < 1 || !ctype_digit($total[$i])) {
        $verifType = true;
      }
    }

    $msg = "";

    if ($verifEmpty) {
      $msg =  '2&Veuillez Entrer toutes les valeurs !';
    } elseif ($verifType) {
      $msg = '2&Verifier les valeurs renseignées';
    } else {

      $date = date('Y-m-d');
      $code = strtoupper(self::checkCode());
      $employe_id = $_SESSION['id_employe'];
      $entrepot_id = $_SESSION['id_entrepot'];

      $data = array(
        'code_achat' => $code,
        'employe_id' => $employe_id,
        'fournisseur_id' => $fournisseur,
        'created_at' => $date,
        'entrepot_id' => $entrepot_id
      );

      $results = Soutra::transactionData(function () use ($data, $pu, $qte, $id, $code) {
        Soutra::inserted("achat", $data);
        for ($i = 0; $i < count($pu); $i++) {
          $achat = array(
            'achat_id' => $code,
            'article_id' => $id[$i],
            'prix_achat' => $pu[$i],
            'qte' => $qte[$i]
          );

          Soutra::inserted("entree", $achat);
        }

        // return false;
      });
      if ($results) {
        $msg = "1&Approvisionement effectué avec succès.";
      } else {
        $msg = '2&Une erreur est survenue! ';
      }
    }

    echo $msg;
  }


  public static function checkCode()
  {
    $code = "AC" . date('y') . date('d') . rand(10, 999);
    if (!empty(Soutra::libelleExiste('achat', 'code_achat', $code))) {
      self::checkCode();
    }
    return $code;
  }

  public static function modifier_achat()
  {
    extract($_POST);
    $msg = "";

    if (empty($qte)) {
      $msg = '2&Veuillez remplir le champ Quantité !';
    } elseif (!ctype_digit($qte) || $qte <= 0) {
      $msg = '2&La quantité est invalide !';
    } else {

      $data = array(
        'qte' => $qte,
        'ID_entree' => $id_approvision
      );

      if (Soutra::update("entree", $data)) {
        $code_achat = Soutra::libelle('entree', 'achat_id', 'ID_entree', $id_approvision);
        $retour = self::liste_achat_detail($code_achat);
        $msg = "1&$retour&Element modifié avec succès.";
      } else {
        $msg = '2&Une erreur est survenue !';
      }
    }
    echo $msg;
  }

  public static function suppresion_achat()
  {
    if (isset($_POST['btn_supprimer_achat'])) {

      $data = array(
        'etat_achat' => 0,
        'ID_achat' => $_POST['id_achat']
      );
      Soutra::update("achat", $data);
      echo 1;
    }
  }

  public static function btn_remove_achat_detail()
  {
    if (isset($_POST['remove_achat_detail'])) {

      $data = array(
        'etat_entree' => 0,
        'ID_entree' => $_POST['id_achat']
      );
      Soutra::update("entree", $data);
      echo 1;
    }
  }


  // CANVAS ACHAT

  public static function getCanvasfournisseur()
  {
    if (isset($_POST['getCanvasFournisseurData'])) {
      $fournisseur = $_POST['fournisseur'];
      $annee = $_POST['select_year'];
      $code = 400;
      $achat = Soutra::getTotalAchatByMonthFournisseur($fournisseur, $annee);
      if (!empty($achat)) {
        $code = 200;
      }

      echo json_encode(['achat' => $achat, 'code' => $code]);
    }
  }

  // DASHBOARD CANVAS
  public static function getCanvasMonthAchat()
  {
    if (isset($_POST['getCanvasMonthDataAchat'])) {
      $annee = $_POST['year_select'];
      $code = 400;
      $achat = Soutra::getTotalAchatByMonth($annee);
      if (!empty($achat)) {
        $code = 200;
      }

      echo json_encode(['achat' => $achat, 'code' => $code]);
      // echo $_POST['year_select'];
    }
  }


  public static function ajouter_achat()
  {
    if (isset($_POST['btn_ajouter_achat'])) {

      if (isset($_POST['id_approvision'])) {
        // mod()
        self::modifier_achat();
      } else {
        // Ajouter
        self::createAchat();
      }
    }
  }

  // public static function enseignant_combobox() {
  //     if (isset($_POST['enseignant_combobox'])) {
  //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
  //                 . '<option value="">Veuillz choisir un enseignant</option>';
  //         foreach (Soutra::getAllByItem("achat", "ID_type_achat", 7) as $row) {
  //             $output .= '
  //             <option value="' . $row['ID_achat'] . '">
  //                 ' . $row['nom_achat'] . ' ' . $row['prenom_achat'] . ' : ' . $row['tel_achat'] . '
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
  //         } elseif (Soutra::exite("achat", "tel_achat", $tel) && Soutra::libelle("achat", "ID_achat", "tel_achat", $tel) != $ID) {
  //             echo 'Le téléphone ' . $tel . ' existe déjà !';
  //         } elseif (Soutra::exite("achat", "login_achat", $login) && Soutra::libelle("achat", "ID_achat", "login_achat", $login) != $ID) {
  //             echo 'Veuillez un autre nom utilisateur  !';
  //         } elseif (!Soutra::verif_email($email)) {
  //             echo 'Veuillez entrer une adresse valide !';
  //         } elseif (Soutra::exite("achat", "email_achat", $email) && Soutra::libelle("achat", "ID_achat", "email_achat", $email) != $ID) {
  //             echo 'L\'adresse ' . $email . ' existe déjà !';
  //         } else {
  //             $data = array(
  //                 'nom_achat' => strtoupper($nom),
  //                 'prenom_achat' => ucfirst($prenom),
  //                 'tel_achat' => $tel,
  //                 'email_achat' => $email,
  //                 'login_achat' => $login,
  //                 'ID_achat' => strtoupper($ID)
  //             );
  //             //var_dump($data);die();
  //             if (Soutra::update("achat", $data)) {
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
  //                 'passe_achat' => md5($passe),
  //                 'ID_achat' => strtoupper($ID)
  //             );
  //             //var_dump($data);die();
  //             if (Soutra::update("achat", $data)) {
  //                 echo 1;
  //             } else {
  //                 echo 'Une erreur est survenue ! ';
  //             }
  //         }
  //     }
  // }

  //achat_combo
  // public static function achat_combobox() {
  //     if (isset($_POST['btnEmpCombo'])) {
  //         $output = '<option value="">Veuillz choisir un employé</option>';
  //         foreach (Soutra::getAll("achat", "nom_achat") as $row) {
  //             if ($row['ID_type_achat'] != 1) {
  //                 if ($row['ID_type_achat'] != 7) {
  //                     $output .= '
  //             <option value="' . $row['ID_achat'] . '">
  //                 ' . $row['nom_achat'] . ' ' . $row['prenom_achat'] . ' Tel : ' . $row['tel_achat'] . ' Fonction : ' . Soutra::getItem("type_achat", "libelle_type_achat", "ID_type_achat", $row['ID_type_achat']) . ' 
  //             </option>';
  //                 }
  //             }
  //         }
  //         //$output .= "</select>";
  //         //var_dump($output);
  //         echo $output;
  //     }
  // }

  //         public static function initDateRangeFilter()
  //     {
  //         if (isset($_POST['start_date'], $_POST['end_date'])) {
  //             // Conversion des dates Flatpickr en Y-m-d
  //             $start = DateTime::createFromFormat('d-m-Y', $_POST['start_date'])->format('Y-m-d');
  //             $end = DateTime::createFromFormat('d-m-Y', $_POST['end_date'])->format('Y-m-d');

  //             if (isset($_POST['btn_filter_achat'])) {
  //                 // Récupérer les achats filtrés par date
  //         $achats = Soutra::getAllListeAchatByDateRange($start, $end); // méthode adaptée que l'on a créée
  //         $output = '';
  //                 if (!empty($achats)) {
  //                     $i = 0;
  //                     foreach ($achats as $row) {
  //                         ++$i;
  //                         $output .= '<tr class="row'.$row['ID_achat'].'">
  //                     <td>'.$i.'</td>
  //                     <td class="text-right">'.$row['code_achat'].'</td>
  //                     <td class="text-right">'.$row['article'].'</td>
  //                     <td class="text-right">'.number_format($row['total'], 0, ',', ' ').'</td>
  //                     <td>
  //                         <a href="#" class="fournisseur-link" data-id="'.$row['code_fournisseur'].'" title="Voir fournisseur">
  //                             '.$row['code_fournisseur'].'
  //                         </a>
  //                     </td>
  //                     <td>'.Soutra::date_format($row['created_at']).'</td>
  //                     <td class="text-right"> 
  //                         <a href="'.URL.'detail_achat&id='.$row['code_achat'].'" title="Detail achat" class="btn btn-primary btn-sm">
  //                         <i class="fa fa-eye"></i> Detail </a>
  //                         <div class="d-inline ">
  //                             <button data-id="'.$row['ID_achat'].'" title="Supprimer achat" class="btn btn-warning btn-sm btn_remove_achat d_none">
  //                             <i class="fa fa-trash"></i> </button>
  //                         </div>
  //                     </td>
  //                 </tr>';
  //                     }
  //                 }else{
  //                   $output = '<tr><td colspan="7" class="text-center">Aucun achat trouvé pour la plage de dates sélectionnée.</td></tr>';
  //                 }
  //                 echo json_encode([
  //                     'html' => $output,
  //                 ]);
  //             }
  //             if (isset($_POST['btn_filter_achat_by_article'])) {
  //                 // Récupérer les achats filtrés par date
  //         $achats = Soutra::getAllListeAchatByDateRangeGroupByArticle($start, $end); // méthode adaptée que l'on a créée
  //         $output = '';
  //                 if (!empty($achats)) {
  //                     $i = 0;
  //                     foreach ($achats as $row) {
  //                         ++$i;
  //                         $output .= '
  //                       <tr class="row'.$row['ID_article'].'">
  //                         <td>'.$i.'</td>
  //                         <td class="text-right">'.$row['libelle_article'].'</td>
  //                         <td class="text-right">'.$row['nb_article'].'</td>
  //                         <td class="text-right">'.number_format($row['total'], 0, ',', ' ').'</td>
  //                         <td>
  //                             <a href="#" class="fournisseur-link" data-id="'.$row['code_fournisseur'].'" title="Voir fournisseur">
  //                                 '.$row['code_fournisseur'].'
  //                             </a>
  //                         </td>

  //                       </tr>
  //                       ';
  //                     }
  //                 }else{
  //                   $output = '<tr><td colspan="5" class="text-center">Aucun achat trouvé pour la plage de dates sélectionnée.</td></tr>';
  //                 }
  //                  echo json_encode([
  //                     'html' => $output,
  //                 ]);
  //             }
  //  if (isset($_POST['btn_filter_vente'])) {
  //     $totaux = Soutra::getTotauxVenteByDateRange($start, $end);
  //     $ventes = Soutra::getAllListeVenteByDateRange($start, $end);

  //     $output = '';
  //     if (!empty($ventes)) {
  //         $i = 0;
  //         foreach ($ventes as $row) {
  //             $i++;
  //             $output .= '
  //             <tr class="row'.$row['ID_vente'].'">
  //               <td>' . $i . '</td>
  //               <td class="text-right">' . $row['code_vente'] . '</td>
  //               <td class="text-right">' . $row['article'] . '</td>
  //               <td class="text-right">' . number_format($row['total'],0,","," ") . '</td>
  //               <td>' . $row['nom_client'] .' '. $row['prenom_client'] .'</td>
  //               <td>'. $row['code_client'] .' </td>
  //               <td>' . Soutra::date_format($row['created_at']) . '</td>
  //               ';
  //             $output .= '<td class="text-right"> 
  //             <a href="'.URL.'detail&id='. $row['code_vente'].'" title="Detail vente" class="btn btn-primary btn-sm">
  //             <i class="fa fa-eye"></i> Detail </a>';
  //             if (strtolower($_SESSION['role']) == ADMIN ) {

  //             $output.= '<div class="d-inline">
  //                 <button data-id="'. $row['ID_vente'].'" title="Supprimer vente" class="btn btn-warning btn-sm btn_remove_vente d_none">
  //                 <i class="fa fa-trash"></i> Supprimer
  //                 </button>
  //             </div>
  //             ';
  //           }
  //     $output.='
  //           </td>
  //              </tr>
  //              ';
  //         }
  //     } else {
  //         $output = '<tr><td colspan="8" class="text-center">Aucune vente trouvée pour la plage de dates sélectionnée.</td></tr>';
  //     }

  //     echo json_encode([
  //         'html' => $output,
  //         'totaux' => $totaux
  //     ]);
  // }
  //  if (isset($_POST['btn_filter_vente_by_article'])) {
  //     $totaux = Soutra::getTotauxVenteByDateRangeByArticle($start, $end);
  //     $ventes = Soutra::getAllListeVenteByDateRangeByArticle($start, $end);

  //     $output = '';
  //   if (!empty($ventes)) {
  //     $i = 0;
  //     foreach ($ventes as $row) {
  //         $i++;
  //         $output .= '
  //         <tr>
  //             <td>' . $i . '</td>
  //             <td class="text-right">' . $row['libelle_article'] . '</td>
  //             <td class="text-right">' . $row['nb_article'] . '</td>
  //             <td class="text-right">' . number_format($row['total'], 0, ",", " ") . '</td>
  //             <td class="text-right">
  //                 <a href="'.URL.'detail&id='. $row['ID_article'].'" class="btn btn-primary btn-sm">
  //                     <i class="fa fa-eye"></i> Detail
  //                 </a>';
  //                 if (strtolower($_SESSION['role']) == ADMIN ) {
  //                     $output .= '
  //                     <button data-id="'. $row['ID_article'].'" class="btn btn-warning btn-sm btn_remove_vente d_none">
  //                         <i class="fa fa-trash"></i> Supprimer
  //                     </button>';
  //                 }
  //         $output .= '</td></tr>';
  //     }
  // } else {
  //     $output = '<tr><td colspan="7" class="text-center">Aucune vente trouvée pour la période sélectionnée.</td></tr>';
  // }


  //     echo json_encode([
  //         'html' => $output,
  //         'totaux' => $totaux
  //     ]);
  // }

  //         }
  //     }

  public static function getDataDateRangeFilterAchat()
  {
    if (isset($_POST['btn_filter_achat'])) {
      $btn_filter_achat = $_POST['btn_filter_achat'];
      $dateDebut = $_POST['dateDebut'] ?? null;
      $dateFin = $_POST['dateFin'] ?? null;
      $total_achat = 0;
      $mont_achat = 0;
      $totaux = Soutra::getTotauxAchatByDateRange($dateDebut, $dateFin); // méthode adaptée que l'on a créée

      // si le btn = 1 on get par achat
      if ($btn_filter_achat == 1) {

        $data = Soutra::getAllListeBonCommandeFournisseur($dateDebut, $dateFin);
      }
      // si le btn = 2 on get par article
      if ($btn_filter_achat == 2) {
        $data = Soutra::getAllListeAchatByDateRangeByArticle($dateDebut, $dateFin);
      }

      $output = '';
      // si le btn = 2 on affiche par article
      if ($btn_filter_achat == 2) {
        $output .= self::returnDataAchatByArticle($data);
      }
      // si le btn = 1 on affiche par achat
      if ($btn_filter_achat == 1) {
        $output .= self::returnDatAachat($data);
      }

      $data = [
        'output' => $output,
        'total_article' => $totaux['article'],
        'montant_total_achat' => number_format($totaux['total'] ?? 0, 0, ',', ' ')
      ];

      echo json_encode($data);
    }
  }
  private static function returnDataAchatByArticle($data)
  {
    $output = '';
    if (!empty($data)) {
      $i = 0;
      foreach ($data as $row) {
        ++$i;
        $output .= '
    <tr class="row' . $row['ID_article'] . '">
       <td>' . $i . '</td>
       <td class="text-right">' . $row['libelle_article'] . '</td>
       <td class="text-right">' . $row['article'] . '</td>
       <td class="text-right">' . number_format($row['total'], 0, ',', ' ') . '</td>
       <td>
           <a href="#" class="fournisseur-link" data-id="' . $row['code_fournisseur'] . '" title="Voir fournisseur">
               ' . $row['code_fournisseur'] . '
           </a>
       </td>

     </tr>
     ';
      }
    } else {
      $output = '<tr><td colspan="7" class="text-center">Aucune achat trouvé pour la période sélectionnée.</td></tr>';
    }
    return $output;
  }

  private static function returnDataAchat($data)
  {
    $output = '';
    // $achat = Soutra::getAllListeachatByDateRange();
    if (!empty($data)) {
      $i = 0;
      foreach ($data as $row) {
        ++$i;
        $output .= '<tr class="row' . $row['ID_achat'] . '">
                    <td>' . $i . '</td>
                    <td class="text-right">' . $row['code_achat'] . '</td>
                    <td class="text-right">' . $row['article'] . '</td>
                    <td class="text-right">' . number_format($row['total'], 0, ',', ' ') . '</td>
                    <td>
                        <a href="#" class="fournisseur-link" data-id="' . $row['code_fournisseur'] . '" title="Voir fournisseur">
                            ' . $row['code_fournisseur'] . '
                        </a>
                    </td>
                    <td>' . Soutra::date_format($row['created_at']) . '</td>
                    <td class="text-right"> 
                        <a href="' . URL . 'detail_achat&id=' . $row['code_achat'] . '" title="Detail achat" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> Detail </a>
                        <div class="d-inline ">
                            <button data-id="' . $row['ID_achat'] . '" title="Supprimer achat" class="btn btn-warning btn-sm btn_remove_achat d_none">
                            <i class="fa fa-trash"></i> </button>
                        </div>
                    </td>
                </tr>';
      }
    }

    return $output;
  }



  public static function ajouter_depense()
  {
    if (isset($_POST['btn_ajouter_depense'])) {

      if (isset($_POST['id_depense']) && !empty($_POST['id_depense'])) {
        // mod()
        self::modifier_depense();
      } else {
        // Ajouter
        self::createDepense();
      }
    }
  }

  /**
   * Vérifie la validité des données envoyées
   */
  private static function validateDepense($data)
  {
    $errors = "";

    if (empty($data['type_id'])) {
      $errors = "Le type de dépense est obligatoire.";
    }
    if (empty($data['montant'])) {
      $errors = "Le montant est obligatoire.";
    } elseif (!is_numeric($data['montant'])) {
      $errors = "Le montant doit être un nombre.";
    }
    if (empty($data['periode'])) {
      $errors = "La date est obligatoire.";
    }

    return $errors;
  }

  /**
   * Insère une dépense dans la base
   */
  private static function saveDepense($data)
  {
    $code = strtoupper(self::checkCode());
    $date = date('Y-m-d');
    $insertData = [
      'type_id'      => $data['type_id'],
      'employe_id'   => $_SESSION['id_employe'] ?? null,
      'montant'      => $data['montant'],
      'description'  => $data['description'],
      'periode'      => $data['periode'],
      'date_created'   => $date
    ];

    return Soutra::insert("depense",   $insertData);
  }

  public static function modifier_depense()
  {
    extract($_POST);
    $msg = "";

    // Étape 1 : validation
    $errors = self::validateDepense($_POST);

    if (!empty($errors)) {
      echo "2& $errors";
      return;
    }
    $insertData = [
      'montant'      => $montant,
      'description'  => $description,
      'periode'      => $periode,
      'type_id'      => $type_id,
      'id_depense'   => $id_depense,
    ];
    if (Soutra::update("depense", $insertData)) {
      // $retour = self::liste_depense_detail($code_depense);
      $msg = "1&Dépendence modifiée avec succès.";
    } else {
      $msg = '2&Une erreur est survenue !';
    }

    echo $msg;
  }


  /**
   * Méthode publique appelée pour traiter le formulaire
   */
  public static function createDepense()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_ajouter_depense'])) {
      $data = $_POST;

      // Étape 1 : validation
      $errors = self::validateDepense($data);

      if (!empty($errors)) {
        echo "2& $errors";
        return;
      }

      // Étape 2 : insertion
      if (self::saveDepense($data)) {
        echo "1&Dépense ajoutée avec succès.";
      } else {
        echo "2&Une erreur est survenue lors de l'enregistrement.";
      }
    }
  }
  // }

  public static function getDepense()
  {
    if (isset($_POST["frm_updepense"])) {

      $id_depense = $_POST['id_depense'];
      $depense = Soutra::getSingleDepense($id_depense);
      // $approvision = Soutra::getAllTable('entree','ID_entree',$id_entree);

      $output = '
                     <div class="form-row menu-modal">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="nom">Dépende</label>
                                 <select name="type_id" class="form-control select" id="">
                                    <option value="' . $depense['ID_type'] . '">' . $depense['libelle_type'] . '</option>
                                    ';

      $data = Soutra::getAllByFromTable("type_depense", "libelle_type");
      foreach ($data as $value) {
        $output .= '
                                        <option value="' . $value['ID_type'] . '">' . $value['libelle_type'] . '</option>
                                        ';
      }
      $output .= '
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="montant">Montant</label>
                                 <input type="text" value="' . $depense['montant'] . '" name="montant" id="montant"
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                             <input type="hidden"  name="id_depense" value="' . $depense['id_depense'] . '" class="form-control" />
                                 <label for="periode">date</label>
                                 <input type="date" name="periode" value="' . $depense['periode_depense'] . '" id="periode" 
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="Description">Description</label>
                                 <textarea name="description" class="form-control" id="Description" rows="3"> ' . $depense['description'] . ' </textarea>
                             </div>
                         </div>

                     </div>
            ';


      echo $output;
    }
  }

  public static function suppresion_depense()
  {
    if (isset($_POST['btn_supprimer_depense'])) {

      $data = [
        'etat_depense' => 0,
        'id_depense' => $_POST['id_depense']
      ];
      Soutra::update("depense", $data);
      echo 1;
    }
  }


  public static function getDataDateRangeFilterDepense()
  {
    if (isset($_POST['btn_filtemmlklkkmr_depense555'])) {
      extract($_POST);
      $btn_filter654454_depense = $_POST['btn_filter_deùmmùùlùlpense'];
      $dateDebut = $_POST['dateDebut'] ?? null;
      $dateFin = $_POST['dateFin'] ?? null;
      $depense_precedente = 0;

      // si le btn = 1 on get par depense
      if ($btn_filt32355er_depense == 1) {
        $totaux_depense = Soutra::getTotauxDepenseByMouth($dateDebut, $dateFin);
        $data_depense = Soutra::getDepensesByMouth($dateDebut, $dateFin);
      }


      $depense_precedente = number_format($totaux_depense['total'], 0, ",", " ") . ' FCFA';

      $output = '';
      // si le btn = 1 on affiche par depense
      $output .= self::returnDatADepense($data_depense);


      $data_json = [
        'output' => $output,
        'depense_precedente' => $depense_precedente
      ];

      echo json_encode($data_json);
      return;
    }
  }

  private static function returnDataDepense($data)
  {
    $output = '';

    // $achat = Soutra::getAllListeachatByDateRange();
    if (!empty($data)) {

      $i = 0;
      foreach ($data as $row) {
        ++$i;
        $output .= '
  <tr class="row' . $row['id_depense'] . '">
     <td>' . $i . '</td>
     <td>' . Soutra::date_format($row['date_created']) . '</td>
     <td class="text-right">' . $row['libelle_type'] . '</td>
     <td class="text-right">' . number_format($row['montant'], 0, ',', ' ') . '</td>
     <td title="' . $row['description'] . '" >
     ...
     </td>
     <td>' . Soutra::date_format($row['periode']) . '</td>
     <td class="text-right">' . $row['employe'] . '</td>
     <td class="text-right"> 
          <div class="d-inline ">
              <button data-id="' . $row['id_depense'] . '" title="Modifier depense" class="btn btn-primary btn-sm btn_update_depense">
              <i class="fa fa-edit"></i> Modifier</button>
              <button data-id="' . $row['id_depense'] . '" title="Supprimer depense" class="btn btn-danger btn-sm btn_remove_depense">
              <i class="fa fa-trash"></i> </button>
          </div>
     </td>
   </tr>
   ';
      }
    } else {
      $output .= '<tr><td colspan="7" class="text-center">Aucun achat trouvé pour la plage de dates sélectionnée.</td></tr>';
    }

    return $output;
  }

  public static function ajouter_versement_achat()
  {
    if (isset($_POST['btn_encaisser_achat'])) {

      extract($_POST);
      $msg = [];
      // var_dump($_POST);return;

      if (isset($montant_versement) && !empty($montant_versement)) {
        if (isset($code_achat) && !empty($code_achat)) {
          $achat = Soutra::getByItem("achat", "code_achat", $code_achat);
          if (!empty($achat)) {
            $montant_total = Soutra::getSumMontantAchatByAchat(1, $code_achat);
            $montant_versement_total = Soutra::getSumMontantVersementByAchat(1, $code_achat);
            if ($montant_total >= ($montant_versement + $montant_versement_total)) {

              if (Soutra::verif_type($montant_versement)) {
                $date = date('Y-m-d');
                $code = strtoupper(self::checkCode());
                $data_versement = array(
                  'montant_versement' => $montant_versement,
                  'fournisseur_id' => $achat["fournisseur_id"],
                  'employe_id' => $_SESSION['id_employe'],
                  'etat_versement' => 1,
                  'code_versement' => $code,
                  'created_at' => $date,
                  'transaction_code' => $code_achat,
                  'type_versement' => 'achat'
                );

                $connect = Soutra::getConnexion();
                $connect->query("SET AUTOCOMMIT = 0");
                $connect->beginTransaction();
                try {

                  if (Soutra::insert("versement", $data_versement)) {
                    if (Soutra::getSumMontantachatByachat(1, $code_achat) == Soutra::getSumMontantVersementByachat(1, $code_achat)) {
                      $data_updated = [
                        'statut_achat' => STATUT_COMMANDE[2],
                        'code_achat' => $code_achat
                      ];
                      Soutra::update('achat', $data_updated);
                    }
                    $connect->commit();
                    $msg = ['status' => true, 'message' => 'Versement enregistré avec succès.'];
                  } else {

                    $connect->rollBack();
                  }
                  // $connect->commit();
                } catch (Exception $ex) {
                  //throw $th;
                  $connect->rollBack();
                  $msg = ['status' => false, 'message' => 'Une erreur est survenue !' . $ex->getMessage()];
                }
              } else {
                $msg = ['status' => false, 'message' => 'Le montant invalide !'];
              }
            } else {
              $reste = Soutra::getSumMontantachatByachat(1, $code_achat) - Soutra::getSumMontantVersementByachat(1, $code_achat);
              $msg = ['status' => false, 'message' => "Il reste " . $reste . " pour finaliser le paiement"];
            }
          } else {
            $msg = ['status' => false, 'message' => 'achat introuvable'];
          }
        } else {
          $msg = ['status' => false, 'message' => 'Le code de achat invalide !'];
        }
      } else {
        $msg =  ['status' => false, 'message' => 'Veuillez remplir tous les champs !'];
      }
      echo json_encode($msg);
    }
  }
}

//fin de la class
