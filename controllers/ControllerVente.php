<?php

class ControllerVente extends Connexion
{

  // connexion utilisateur


  public static function getvente()
  {
    if (isset($_POST["frm_upvente"])) {
      $id_sortie = $_POST["id_sortie"];
      $article = Soutra::getSingleVenteArticle($id_sortie);
      $vente = Soutra::getAllTable('sortie', 'ID_sortie', $id_sortie);

      $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="article_id">Article - Slug - Mark</label>
              <select name="article_id" id="article_id" class="form-control">
              ';

      $output .= '
                <option  value="' . $article['ID_article'] . '">' . $article['libelle_article'] . ' - ' . $article['slug'] . ' - ' . $article['mark'] . '</option>
                ';

      // }
      $output .= '
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="prix_vente">Prix Vente</label>
               <input disabled type="number" min="0" name="prix_vente" value="' . $vente[0]['prix_vente'] . '" id="prix_vente" class="form-control">
            </div>
            <input type="hidden"  name="id_sortie" value="' . $vente[0]['ID_sortie'] . '" class="form-control">

          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="qte">Quantité</label>
               <input type="number" min="0" name="qte" value="' . $vente[0]['qte'] . '" id="qte" class="form-control qte_vente_detail">
            </div>
          </div>
            ';


      echo $output;
    }
  }

  public static function getEncaissementvente()
  {
    if (isset($_POST["frm_encaissement"])) {
      $code = $_POST["code"];
      // $article = Soutra::getSingleVenteArticle($id_sortie);
      // $vente = Soutra::getAllTable('sortie', 'ID_sortie', $id_sortie);

      $output = '
            <form id="form_encaisser_vente" method="POST">
            <div class="row">
            <input type="hidden" name="code_vente" value="' . $code . '">
            <input type="hidden" name="btn_encaisser_vente" class="form-control">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="article_id">Mode de paiement</label>
                  <select name="pay_mode" class="form-control">
                  ' . payement() . '
                  </select>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label for="montant_total">Montant à regler</label>
                  <input readOnly type="text" class="form-control" id="montant_total_vente" value="' . $_POST['reste_a_payer'] . '">
                </div>

              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="qte">Montant reçu</label>
                  <input type="number" min="0" name="montant_recu_vente" id="montant_recu_vente" class="form-control ">
                </div>
              </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label for="qte">Reste à payer</label>
                  <input type="number" min="0" id="reste_a_payer_vente" name="qte" class="form-control ">
                </div>
              </div>
              <div class="col-md-12 modal_footer">
              <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div>
              </div>
          </form>';


      echo json_encode($output);
    }
  }


  // public static function etat_vente() {
  //     if (isset($_POST["etat_utilisateur"])) {
  //         echo (vente::verrif_etat_user($_SESSION["ISPWB"]));
  //     }
  // }

  // public static function liste_type() {
  //     $output = '';
  //     if (!empty(Soutra::getAllByItem3("type_vente", "ID_type_vente", 1))) {
  //         $i = 0;
  //         foreach (Soutra::getAllByItem3("type_vente", "ID_type_vente", 1) as $row) {
  //             $i++;
  //             $output .= '
  //             <tr>
  //                <td>' . $i . '</td>
  //                <td>' . $row['libelle_type_vente'] . '</td>
  //                <td>
  //                   <button type="button" libelle="' . $row['libelle_type_vente'] . '" ID="' . $row['ID_type_vente'] . '" class="btn btn-default btn-sm btn_frm_modifier_type_vente">
  //                       <i class="fa fa-edit"></i> Modifier
  //                   </button>
  //                </td>
  //              </tr>
  //              ';
  //         }
  //     }
  //     echo $output;
  // }

  public static function liste_vente()
  {
    if (isset($_POST['btn_liste_vente'])) {
      $output = '';
      $vente = Soutra::getAllArticleFamilleMark();
      if (!empty($vente)) {
        $i = 0;
        foreach ($vente as $row) {
          $i++;
          $etat = $row['etat_vente'] == 1 ? "Disponible" : "Non disponible";

          $output .= '
                <tr>
                   <td>' . $i . '</td>
                   <td>' . $row['libelle_vente'] . '</td>
                   <td>' . $row['slug'] . '</td>
                  <td>' . $row['famille'] . '</td>
                  <td>' . $row['mark'] . '</td>
                  <td>' . number_format($row['prix_vente'], 0, ",", " ") . '</td>
                  <td>' . $row['stock_alert'] . '</td>
                  <td>' . $etat . '</td>
                   ';

          $output .= '<td> 
                   <a href="' . URL . 'approvision&id=' . $row['code_vente'] . '" title="Detail vente" class="btn btn-primary btn-sm">
                   <i class="fa fa-eye"></i> Detail </a>';
          if (strtolower($_SESSION['role']) == ADMIN) {

            $output .= '<div class="d-inline">
                       <button data-id="' . $row['ID_vente'] . '" title="Supprimer vente" class="btn btn-warning btn-sm btn_remove_vente">
                       <i class="fa fa-trash"></i> Supprimer
                       </button>
                   </div>
                   ';
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


  public static function liste_detail_vente($id)
  {
    $detail = Soutra::getDetailVente($id, $_SESSION['id_entrepot']);

    $i = 0;
    $output = "";
    foreach ($detail as $row) {
      $i++;

      $output .= '
        <tr class="row' . $row['ID_sortie'] . '">
           <td class="col id d_none">' . $row['ID_sortie'] . '</td>
           <td>' . $i . '</td>
           <td>' . $row['article'] . '</td>
           <td>' . $row['mark'] . '</td>
          <td>' . $row['famille'] . '</td>
          <td class="pu">' . number_format($row['prix_vente'], 0, ",", " ") . '</td>
          <td class="qte">' . $row['qte'] . '</td>
          <td class="total">' . number_format($row['prix_vente'] * $row['qte'], 0, ",", " ") . '</td>
           ';
      $garantie = $row['garantie'];
      $dvente = Soutra::date_format($row['date_vente'], false);
      // $testt = Soutra::dateDiff($dvente, $garantie);
      //if ($_SESSION["role"] == ADMIN || $emp['employe'] == $_SESSION["id_employe"]) {
      if (Soutra::dateDiff($dvente, $garantie)) {

        $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_sortie'] . '" class="btn btn-primary btn-sm btn_update_vente">
            <i class="fa fa-edit"></i> 
    
</button>
           <div class="d-inline">
               <button data-id="' . $row['ID_sortie'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_data_panier">
               <i class="fa fa-trash"></i> </button>
           </div>';
      } else {

        $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <span class="text-danger">Desolé date limite depassée! </span>
           </div>';
      }

      $output .= '   
         </td>
            </tr>
            ';
      //}
    }
    return $output;
  }

  public static function liste_detail_vente_client()
  {
    if (isset($_POST["btn_vente_client"])) {
      $id = $_POST["codevente"];

      $detail = Soutra::getDetailVente($id, $_SESSION['id_entrepot']);

      $output = "";
      foreach ($detail as $row) {

        $output .= '
            <tr>
              <td>' . $row['article'] . '</td>
              <td>' . $row['mark'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td class="pu">' . number_format($row['prix_vente'], 0, ",", " ") . '</td>
              <td class="qte">' . $row['qte'] . '</td>
              <td class="total">' . number_format($row['prix_vente'] * $row['qte'], 0, ",", " ") . '</td>
            </tr>
                ';
      }
      echo $output;
    }
  }


  public static function ajouter_panier_vente()
  {
    if (isset($_POST['btn_ajouter_panier_vente'])) {
      $output = '';
      if (!empty($_POST['article'])) {
        $vente = Soutra::getPanierVente(implode(',', $_POST['article']), $_SESSION['id_entrepot']);
        if (!empty($vente)) {
          $i = 0;
          foreach ($vente as $row) {
            $i++;

            $output .= '
              <tr class="row' . $row['ID_article'] . '">
                 <td class="col id d_none">' . $row['ID_article'] . '</td>
                 <td>' . $i . '</td>
                 <td>' . $row['libelle_article'] . '</td>
                <td>' . $row['famille'] . '</td>
                <td>' . $row['mark'] . '</td>
                <td class="label-price col pu" contenteditable="true">' . $row['prix_vente'] . '</td>
                <td class="label-price col qte" contenteditable="true">0</td>
                <td class="col total">0</td>
                 ';

            $output .= '
                 <td> <button  data-id="' . $row['ID_article'] . '" class="btn btn-danger btn-sm btn_remove_data_panier">
                     <i title="Supprimer l\'article de la liste" class="fa fa-trash"></i> </button>
                
               </td>
                  </tr>
                  ';
          }
        }
        echo $output;
      }
    }
  }

  public static function modifier_panier_vente()
  {
    if (isset($_POST['btn_modifier_panier_vente'])) {
      $output = '';
      if (!empty($_POST['article'])) {

        $search = [];
        $vente = [];

        // if (!empty($_POST['article'])) {

        for ($i = 0; $i < count($_POST['article']); $i++) {
          $id = $_POST['article'][$i];
          if (!in_array($id, $_SESSION['panier_vente'])) {
            $_SESSION['panier_vente'][] = $id;
            $search[] = $id;
          }
        }

        $vente = Soutra::getPaniervente(implode(',', $_SESSION['panier_vente']), $_SESSION['id_entrepot']);

        // }
        echo json_encode($vente);
      }
    }
  }

  public static function btn_remove_modifier_panier_vente()
  {
    if (isset($_POST['remove_modifier_panier_vente'])) {

      $article = $_POST['id_article'];
      $vente = $_POST['id_vente'];

      if ($vente != 'undefined')
        Soutra::deleted('sortie', ['vente_id' => $vente, 'article_id' => $article]);

      $_SESSION['panier_vente'] = array_filter($_SESSION['panier_vente'], function ($item) use ($article) {
        return $item != $article;
      });

      echo json_encode([
        'code' => '200',
        'message' => 'Produit retiré de la liste avec succès!',
        'panier' => $_SESSION['panier_vente']
      ]);
    }
  }

  public static function btn_remove_vente_detail()
  {
    if (isset($_POST['remove_vente_detail'])) {

      $data = array(
        'etat_sortie' => 0,
        'ID_sortie' => $_POST['id_vente']
      );
      Soutra::update("sortie", $data);
      echo 1;
    }
  }
  public static function verifQteArticleVente()
  {
    if (isset($_POST['btn_verifQteArticleVente'])) {
      $stock = Soutra::getNiveauStockArticle('vue_stock_produit', 'article_id', 'entrepot_id', $_POST['id'], $_SESSION['id_entrepot']);


      // $entree = Soutra::getCompterSum('entree', 'qte', 'article_id', $_POST['id']);
      // $sortie = Soutra::getCompterSum('sortie', 'qte', 'article_id', $_POST['id']);
      // $stock = abs($entree - $sortie);

      // echo json_encode();
      if ($stock['quantite_disponible'] >= $_POST['qte']) {
        echo 'ok';
      } else {
        echo $stock['quantite_disponible'];
      }
    }
  }

  public static function verifDetail()
  {
    if (isset($_POST['btn_detail'])) {
      $vente = Soutra::singleVenteDetail($_POST['code_vent']);

      echo json_encode($vente);
    }
  }
  public static function getCanvasEmployeMonth()
  {
    if (isset($_POST['getCanvasEmployeMonth'])) {
      $annee = $_POST['select_year'];
      $id_employe = $_POST['id_employe'];
      $code = 400;
      $vente = Soutra::getTotalVenteByEmployeInMonth($id_employe, $annee);
      if (!empty($vente)) {
        $code = 200;
      }

      echo json_encode(['vente' => $vente, 'code' => $code]);
    }
  }

  public static function getCanvasWeek()
  {
    if (isset($_POST['getCanvasWeekData'])) {
      $vente = Soutra::getTotalVenteByWeek();
      echo json_encode($vente);
    }
  }

  public static function getCanvasCLient()
  {
    if (isset($_POST['getCanvasClientData'])) {
      $client = $_POST['client'];
      $annee = $_POST['select_year'];
      $code = 400;
      $vente = Soutra::getTotalVenteByMonthClient($client, $annee);
      if (!empty($vente)) {
        $code = 200;
      }

      echo json_encode(['vente' => $vente, 'code' => $code]);
    }
  }

  public static function getCanvasMonth()
  {
    if (isset($_POST['getCanvasMonthData'])) {
      $annee = $_POST['year_select'];
      $code = 400;
      $vente = Soutra::getTotalVenteByMonth($annee);
      if (!empty($vente)) {
        $code = 200;
      }

      echo json_encode(['vente' => $vente, 'code' => $code]);
      // echo $_POST['year_select'];
    }
  }

  public static function getCanvasMontantByArticle()
  {
    if (isset($_POST['getCanvasMontantByArticle'])) {
      $vente = Soutra::getSumMontantVenteByArticle(1);
      echo json_encode($vente);
    }
  }

  public static function activation()
  {
    //     if (isset($_POST['active_vente'])) {
    //         if ($_POST['etat'] == 1) {
    //             $data = array(
    //                 'etat_vente' => 0,
    //                 'ID_vente' => $_POST['id']
    //             );
    //             if (Soutra::update("vente", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 3;
    //             }
    //         } elseif ($_POST['etat'] == 0) {
    //             $data = array(
    //                 'etat_vente' => 1,
    //                 'ID_vente' => $_POST['id']
    //             );
    //             if (Soutra::update("vente", $data)) {
    //                 echo 2;
    //             } else {
    //                 echo 3;
    //             }
    //         }
    //     }
    // }

    // public static function type_combobox() {
    //     if (isset($_POST['type'])) {
    //         $output = '<select id="type_vente" class="form-control">';
    //         foreach (Soutra::getAll("type_vente", "libelle_type_vente") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_vente'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_vente'] != 1 && $row['ID_type_vente'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
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
    //         foreach (Soutra::getAll("type_vente", "libelle_type_vente") as $row) {
    //            if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_vente'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_vente'] != 1 && $row['ID_type_vente'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
    //                     </option>';
    //                 } 
    //            }
    //         }
    //     }else{
    //         $output = '<option value="' . $ID_type . '">' . Soutra::libelle("type_vente", "libelle_type_vente", "ID_type_vente", $ID_type) . '</option>';
    //         foreach (Soutra::getAll("type_vente", "libelle_type_vente") as $row) {
    //             if($_SESSION["IDTYPE"] == 1){
    //                 if ($row['ID_type_vente'] != 1) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
    //                     </option>';
    //                 }
    //            }else{
    //                 if ($row['ID_type_vente'] != 1 && $row['ID_type_vente'] != 5) {
    //                     $output .= '
    //                     <option value="' . $row['ID_type_vente'] . '">
    //                         ' . $row['libelle_type_vente'] . '
    //                     </option>';
    //                 } 
    //            }
    //         } 
    //     }

    //     $output .= "</select>";
    //     echo $output;
  }

  public static function ajouter_vente()
  {
    if (isset($_POST['btn_ajouter_vente'])) {
      // Ajouter
      self::createVente();
    }
  }


  public static function ajouter_versement_vente()
  {
    if (isset($_POST['btn_encaisser_vente'])) {

      extract($_POST);
      // var_dump($_POST);return;
      $msg = [];
      if (isset($montant_recu_vente) && !empty($montant_recu_vente)) {
        if (isset($code_vente) && !empty($code_vente)) {
          $vente = Soutra::getByItem("vente", "code_vente", $code_vente);
          if (!empty($vente)) {
            $montant_total = Soutra::getSumMontantVenteByVente($code_vente);
            $montant_recu_vente_total = Soutra::getSumMontantVersementByCode($code_vente);
            if ($montant_total >= ($montant_recu_vente + $montant_recu_vente_total)) {

              if (Soutra::verif_type($montant_recu_vente)) {
                $date = date('Y-m-d');
                $code = strtoupper(self::checkCode());
                $data_versement = [
                  'montant_versement' => $montant_recu_vente,
                  // 'client_id' => $vente["client_id"],
                  'employe_id' => $_SESSION['id_employe'],
                  'etat_versement' => 1,
                  'code_versement' => $code,
                  'created_at' => $date,
                  'transaction_code' => $code_vente,
                  'type_versement' => 'vente',
                  'pay_mode' => $pay_mode
                ];

                $connect = Soutra::getConnexion();
                $connect->query("SET AUTOCOMMIT = 0");
                $connect->beginTransaction();
                try {

                  if (Soutra::insert("versement", $data_versement)) {
                    if (Soutra::getSumMontantVenteByVente($code_vente) == Soutra::getSumMontantVersementByCode($code_vente)) {
                      $data_updated = [
                        'statut_vente' => STATUT_COMMANDE[2],
                        'code_vente' => $code_vente
                      ];
                      Soutra::update('vente', $data_updated);
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
              $reste = Soutra::getSumMontantVenteByVente($code_vente) - Soutra::getSumMontantVersementByCode($code_vente);
              $msg = ['status' => false, 'message' => "Il reste " . $reste . " pour finaliser le paiement"];
            }
          } else {
            $msg = ['status' => false, 'message' => 'vente introuvable'];
          }
        } else {
          $msg = ['status' => false, 'message' => 'Le code de vente invalide !'];
        }
      } else {
        $msg =  ['status' => false, 'message' => 'Montant invalide1 !'];
      }
      echo json_encode($msg);
    }
  }

  public static function createVente()
  {

    extract($_POST);
    // $montant_encaisse = $_POST['montant_encaisse'] ?? 0;
    // var_dump($montant_encaisse,'cool');return;

    $verifEmpty = false;
    $verifType = false;
    $msg = [];

    // || empty($qte[$i])

    if (empty($pu) || empty($qte)) {
      $msg = ['status' => false, 'message' => 'Desolé Verifier les informations.'];
    } else {

      for ($i = 0; $i < count($pu); $i++) {
        if (empty(trim($pu[$i])) || empty(trim($qte[$i]))) {
          $verifEmpty = true;
        } elseif (!ctype_digit($pu[$i]) || !ctype_digit($qte[$i]) || $qte[$i] < 1) {
          $verifType = true;
        }
      }

      if ($verifEmpty) {
        $msg = ['status' => false, 'message' => 'Veuillez Entrer toutes les valeurs !'];
      } elseif ($verifType) {
        $msg = ['status' => false, 'message' => 'Verifier les valeurs renseignées'];
      } else {
        $date = date('Y-m-d');
        $code = strtoupper(self::checkCode());
        $employe_id = $_SESSION['id_employe'];
        $entrepot_id = $_SESSION['id_entrepot'];

        $data = array(
          'code_vente' => $code,
          'client_id' => !empty($client) ? $client : 1,
          'employe_id' => $employe_id,
          'entrepot_id' => $entrepot_id,
          'etat_vente' => 1,
          'pay_mode' => PAYMENT_MODE[0],
          'statut_vente' => STATUT_COMMANDE[0],
          'created_at' => $date
        );

        $results = Soutra::transactionData(function () use ($data, $pu, $qte, $id, $code, $montant_encaisse, $pay_mode) {

          $mouve = false;
          if (Soutra::verif_type($montant_encaisse) && $montant_encaisse > 0) {
            $mouve = true;
          }

          Soutra::inserted("vente", $data);

          $mouvements = [];

          for ($i = 0; $i < count($pu); $i++) {
            $vente = array(
              'vente_id' => $code,
              'article_id' => $id[$i],
              'prix_vente' => $pu[$i],
              'qte' => $qte[$i]
            );

            Soutra::inserted("sortie", $vente);

            if ($mouve) {
              // 3. Préparer insertion multiple
              $mouvements[] = [
                'article_id'     => $id[$i],
                'type_mouvement' => STATUT_MOUVEMENT[1],
                'quantite'       => $qte[$i],
                'employe_id'     => $data['employe_id'],
                'prix_vente'     => $pu[$i],
                'entrepot_id'    => $data['entrepot_id'],
                'date_mouvement' => $data['created_at']
              ];

              // 4. Insert multiple (1 seule requête 🔥)
              if (!empty($mouvements)) {
                Soutra::insertMultiple('mouvement_stock', $mouvements);
              }
            }
            // return true;
          }



          if (Soutra::verif_type($montant_encaisse) && $montant_encaisse > 0) {

            $code_versement = strtoupper(self::checkCode());
            $data_versement = [
              'montant_versement' => (int)$montant_encaisse,
              'employe_id' => $data['employe_id'],
              'etat_versement' => ETATS[1],
              'code_versement' => $code_versement,
              'created_at' => $data['created_at'],
              'transaction_code' => $code,
              'type_versement' => 'vente',
              'pay_mode' => $pay_mode
            ];

            if (Soutra::insert("versement", $data_versement)) {

              if (Soutra::getSumMontantVenteByVente($code) == Soutra::getSumMontantVersementByCode($code)) {
                $data_updated = [
                  'statut_vente' => STATUT_COMMANDE[2],
                  'code_vente' => $code
                ];
              } else {
                $data_updated = [
                  'statut_vente' => STATUT_COMMANDE[1],
                  'code_vente' => $code
                ];
              }
              Soutra::update('vente', $data_updated);
            }
          }

          // return false;
        });
        if ($results) {
          $msg = ['status' => true, 'message' => 'Vente enregistrée avec succès.'];
        } else {
          $msg = ['status' => false, 'message' => 'Une erreur est survenue !'];
        }
      }
      // echo $msg;
    }
    echo json_encode($msg);
  }


  public static function checkCode()
  {
    $code = "VT" . date('y') . date('d') . rand(10, 9999);
    if (!empty(Soutra::libelleExiste('vente', 'code_vente', $code))) {
      self::checkCode();
    }
    return $code;
  }

  public static function modifier_vente()
  {
    if (isset($_POST['btn_modifier_vente'])) {
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
        $msg['message'] = 'Veuillez renseigner toutes les valeurs !';
      } elseif ($verifType) {
        $msg['message'] = 'Verifier les valeurs renseignées';
      } else {

        $entrepot_id = $_SESSION['id_entrepot'];

        $data = array(
          'client_id' => $client,
          'entrepot_id' => $entrepot_id,
          'code_vente' => $code_vente
        );

        $results = Soutra::transactionData(function () use ($data, $pu, $qte, $id, $code_vente) {
          Soutra::update("vente", $data);
          $date = date('Y-m-d');

          for ($i = 0; $i < count($pu); $i++) {
            $vente = array(
              'prix_vente' => $pu[$i],
              'qte' => $qte[$i],
              'article_id' => $id[$i],
              'vente_id' => $code_vente,
              'etat' => 1,
              'updated_at' => $date
            );

            Soutra::updateOrInsertvente($vente);
          }

          // return false;
        });

        if ($results) {
          unset($_SESSION['vente']);
          unset($_SESSION['panier_vente']);
          $msg['code'] = 200;
          $msg['message'] = 'Commande modifiée avec succès!';
        } else {
          $msg['message'] = 'Une erreur est survenue!';
        }
      }

      echo json_encode($msg);
    }
  }

  public static function suppresion_vente()
  {
    if (isset($_POST['btn_supprimer_vente'])) {

      $data = array(
        'etat_vente' => 0,
        'ID_vente' => $_POST['id_vente']
      );
      Soutra::update("vente", $data);
      echo 1;
    }
  }

  public static function enseignant_combobox()
  {
    //     if (isset($_POST['enseignant_combobox'])) {
    //         $output = '<select id="enseignant_combobox" class="form-control moduler">'
    //                 . '<option value="">Veuillz choisir un enseignant</option>';
    //         foreach (Soutra::getAllByItem("vente", "ID_type_vente", 7) as $row) {
    //             $output .= '
    //             <option value="' . $row['ID_vente'] . '">
    //                 ' . $row['nom_vente'] . ' ' . $row['prenom_vente'] . ' : ' . $row['tel_vente'] . '
    //             </option>';
    //         }
    //         $output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
  }

  //liste des classe par enseignant
  public static function liste_classe_prof_combo()
  {
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
  }

  public static function btn_modifier_profil()
  {
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
    //         } elseif (Soutra::exite("vente", "tel_vente", $tel) && Soutra::libelle("vente", "ID_vente", "tel_vente", $tel) != $ID) {
    //             echo 'Le téléphone ' . $tel . ' existe déjà !';
    //         } elseif (Soutra::exite("vente", "login_vente", $login) && Soutra::libelle("vente", "ID_vente", "login_vente", $login) != $ID) {
    //             echo 'Veuillez un autre nom utilisateur  !';
    //         } elseif (!Soutra::verif_email($email)) {
    //             echo 'Veuillez entrer une adresse valide !';
    //         } elseif (Soutra::exite("vente", "email_vente", $email) && Soutra::libelle("vente", "ID_vente", "email_vente", $email) != $ID) {
    //             echo 'L\'adresse ' . $email . ' existe déjà !';
    //         } else {
    //             $data = array(
    //                 'nom_vente' => strtoupper($nom),
    //                 'prenom_vente' => ucfirst($prenom),
    //                 'tel_vente' => $tel,
    //                 'email_vente' => $email,
    //                 'login_vente' => $login,
    //                 'ID_vente' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("vente", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
  }

  public static function btn_modifier_passe()
  {
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
    //                 'passe_vente' => md5($passe),
    //                 'ID_vente' => strtoupper($ID)
    //             );
    //             //var_dump($data);die();
    //             if (Soutra::update("vente", $data)) {
    //                 echo 1;
    //             } else {
    //                 echo 'Une erreur est survenue ! ';
    //             }
    //         }
    //     }
  }

  //vente_combo
  public static function vente_combobox()
  {
    //     if (isset($_POST['btnEmpCombo'])) {
    //         $output = '<option value="">Veuillz choisir un employé</option>';
    //         foreach (Soutra::getAll("vente", "nom_vente") as $row) {
    //             if ($row['ID_type_vente'] != 1) {
    //                 if ($row['ID_type_vente'] != 7) {
    //                     $output .= '
    //             <option value="' . $row['ID_vente'] . '">
    //                 ' . $row['nom_vente'] . ' ' . $row['prenom_vente'] . ' Tel : ' . $row['tel_vente'] . ' Fonction : ' . Soutra::getItem("type_vente", "libelle_type_vente", "ID_type_vente", $row['ID_type_vente']) . ' 
    //             </option>';
    //                 }
    //             }
    //         }
    //         //$output .= "</select>";
    //         //var_dump($output);
    //         echo $output;
    //     }
  }


  public static function getDataDateRangeFilterVente()
  {
    if (isset($_POST['btn_filter_vente'])) {
      $btn_filter_vente = $_POST['btn_filter_vente'];
      $dateDebut = $_POST['dateDebut'] ?? null;
      $dateFin = $_POST['dateFin'] ?? null;
      $total_vente = 0;
      $mont_vente = 0;
      // si le btn = 1 on get par vente
      if ($btn_filter_vente == 1) {

        $data = Soutra::getAllListeBonCommandeClient($dateDebut, $dateFin, $_SESSION['id_entrepot']);
      }
      // si le btn = 2 on get par article
      if ($btn_filter_vente == 2) {
        $data = Soutra::getAllListeVenteByDateRangeByArticle($dateDebut, $dateFin);
      }
      foreach ($data as $value) {
        $total_vente += $value['article'];
        $mont_vente += $value['total'];
      }
      $output = '';
      // si le btn = 2 on affiche par article
      if ($btn_filter_vente == 2) {
        $output .= self::returnDataVenteByArticle($data);
      }
      // si le btn = 1 on affiche par vente
      if ($btn_filter_vente == 1) {
        $output .= self::returnDataVente($data);
      }

      $data = [
        'output' => $output,
        'total_vente' => $total_vente,
        'mont_vente' => $mont_vente,
      ];

      echo json_encode($data);
    }
  }

  private static function returnDataVente($data)
  {
    $output = '';
    // $vente = Soutra::getAllListeVenteByDateRange();
    if (!empty($data)) {
      $i = 0;
      foreach ($data as $row) {
        $i++;
        $payment = '<span class="payment-method">' . $row['pay_mode'] . '</span>';
        $output .= '
            <tr class="row' . $row['ID_vente'] . '">
               <td>' . $i . '</td>
               <td>' . $row['code_vente'] . '</td>
               <td>' . checkStatusCommande($row['statut_vente']) . '</td>
               <td>' . $row['client'] . '</td>
               <td>' . $row['article'] . '</td>
               <td>' . number_format($row['total'], 0, ",", " ") . '</td>
               <td>' . $payment . '</td>
               <td>' . $row['employe'] . ' </td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
        $output .= '<td class="form-button-action"> 
          <a href="' . URL . 'detail&id=' . $row['code_vente'] . '" data-toggle="tooltip" title="" data-original-title="Voir les détails de la commande" class="btn btn-link btn-primary btn-sm">
            <i class="fa fa-eye text-icon-primary"></i> </a>
            ';

        // btn Valider la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '
              <button type="button" 
              id="btn_validation_vente"
              onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
              data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm" data-original-title="Valider la commande"> <i class="fa fa-save text-icon-success"></i> </button>
              ';
        endif;

        // btn Encaisser la facture
        if ($row['statut_vente'] == STATUT_COMMANDE[1]):
          $output .= '<button type="button" 
            id="btn_encaisser_vente"
            data-toggle="modal" data-target="#encaisser-modal"
            data-code="' . $row['code_vente'] . '"
            data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm" data-original-title="Encaisser la facture de la commande"> <i class="fbi bi-cash text-icon-success"></i> </button>';
        endif;

        // btn Modifier la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm" data-original-title="Modifier la commande"> <i class="fa fa-edit text-icon-primary"></i> </button>';
        endif;

        // btn Annuler la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '<button type="button" 
            id="btn_annuler_vente"
            onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
            data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Annuler la commande"> <i class="fa fa-times text-icon-danger"></i> </button>';
        endif;

        // btn Retourner la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[1] || $row['statut_vente'] == STATUT_COMMANDE[2]):
          $output .= '<button type="button"
            id="btn_retourner_vente"
            onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
            data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Retourner la commande"> <i class="fa fa-undo text-icon-danger"></i> </button>';
        endif;

        // btn Imprimer la facture
        $output .= '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-dark btn-sm" data-original-title="Imprimer la facture de la commande"> <i class="fa fa-print text-icon-dark"></i> </button>
            </td>
            </tr>';
      }
    }

    return $output;
  }
  private static function returnDataVenteByArticle($data)
  {
    $output = '';
    if (!empty($data)) {
      $i = 0;
      foreach ($data as $row) {
        $i++;
        $output .= '
                <tr>
                    <td>' . $i . '</td>
                    <td class="text-right">' . $row['libelle_article'] . '</td>
                    <td class="text-right">' . $row['article'] . '</td>
                    <td class="text-right">' . number_format($row['total'], 0, ",", " ") . '</td>
                    <td class="text-right">
                        <a href="' . URL . 'detail&id=' . $row['ID_article'] . '" class="btn btn-primary btn-sm">
                            <i class="fa fa-eye"></i> Detail
                        </a>';
        if (strtolower($_SESSION['role']) == ADMIN) {
          $output .= '
                            <button data-id="' . $row['ID_article'] . '" class="btn btn-warning btn-sm btn_remove_vente d_none">
                                <i class="fa fa-trash"></i> Supprimer
                            </button>';
        }
        $output .= '</td></tr>';
      }
    } else {
      $output = '<tr><td colspan="7" class="text-center">Aucune vente trouvée pour la période sélectionnée.</td></tr>';
    }
    return $output;
  }


  public static function getSearchByAnneeArticleToGetInventaire()
  {
    if (isset($_POST['btn_search_inventaire_annee_article_to_get_inventaire'])) {

      $annee = $_POST['annee'] ?? null;
      $article = $_POST['article'] ?? null;

      $data = Soutra::getInventaireDateByAnneeArticle($annee, $article);

      $output = "";

      foreach ($data as $row) {

        $date = date('d/m/Y', strtotime($row['date_mouvement']));

        $output .= '<option value="' . $row['ID_mouvement_stock'] . '">' . $row['type_mouvement'] . ' - ' . $date . '</option>';
      }

      echo json_encode(['code' => 200, 'html' => $output]);
    }
  }
  public static function getSearchByAnneeArticleMouvement()
  {
    if (isset($_POST['btn_search_inventaire_annee_article_mouvement'])) {

      $annee = $_POST['annee'] ?? null;
      $article = $_POST['article'] ?? null;
      $id_mouvement = $_POST['id_mouvement'] ?? null;

      var_dump($_POST);
      return;
      $data = Soutra::getInventaireDateByAnneeArticle($annee, $article);

      $output = "";

      foreach ($data as $row) {

        $date = date('d/m/Y', strtotime($row['date_mouvement']));

        $output .= '<option value="' . $row['ID_mouvement_stock'] . '">' . $row['type_mouvement'] . ' - ' . $date . '</option>';
      }

      echo json_encode(['code' => 200, 'html' => $output]);
    }
  }

  public static function getDataDateRangeFilterInventaire()
  {
    if (isset($_POST['btn_filter_inventaire'])) {
      // $btn_filter_vente = $_POST['btn_filter_vente'];
      $dateDebut = $_POST['dateDebut'] ?? null;
      $dateFin = $_POST['dateFin'] ?? null;
      $depenses_mois = 0;
      $vente_mois = 0;
      $achat_mois = 0;
      $benefice = 0;


      // Récupérer les achats du mois courant
      $depenses = Soutra::getTotauxDepenseByMouth($dateDebut, $dateFin); // méthode adaptée que l'on a créée
      $depenses_mois = !empty($depenses) ? $depenses['total'] : 0;

      // Récupérer les achats du mois courant
      $achat = Soutra::getTotauxAchatByDateRange($dateDebut, $dateFin); // méthode adaptée que l'on a créée
      $achat_mois = !empty($achat) ? $achat['total'] : 0;

      // Récupérer les achats du mois courant
      $vente = Soutra::getTotauxVenteByDateRange($dateDebut, $dateFin); // méthode adaptée que l'on a créée
      $vente_mois = !empty($vente) ? $vente['total_montant'] : 0;

      // benefice net
      $benefice = $vente_mois - ($depenses_mois + $achat_mois);
      $type = $benefice > 0 ? 'text-success' : 'text-danger';

      $depenses_mois = number_format($depenses_mois ?? 0, 0, ',', ' ');
      $vente_mois = number_format($vente_mois ?? 0, 0, ',', ' ');
      $achat_mois = number_format($achat_mois ?? 0, 0, ',', ' ');
      $benefice = number_format($benefice ?? 0, 0, ',', ' ');

      echo json_encode(compact('depenses_mois', 'vente_mois', 'achat_mois', 'benefice', 'type'));
      return;
    }
  }

  public static function validation_vente()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_validation_vente") {
      extract($_POST);
      $msg = [];

      $data = array(
        'statut_vente' => STATUT_COMMANDE[1],
        'code_vente' => $code
      );
      $ligneVente = Soutra::getDetailVente($code, $_SESSION['id_entrepot']);

      $results = Soutra::transactionData(function () use ($data, $ligneVente) {

        // if (empty($ligneVente)) {
        //   throw new Exception("Aucune ligne de vente trouvée");
        // }

        // 1. Update vente
        Soutra::update("vente", $data);

        // 2. Variables (une seule fois)
        $employe  = $_SESSION['id_employe'];
        $entrepot = $_SESSION['id_entrepot'] ?? null;
        $date     = date('Y-m-d');

        // 3. Préparer insertion multiple
        $rows = array_map(function ($value) use ($employe, $entrepot, $date) {
          return [
            'article_id'     => $value['article_id'],
            'type_mouvement' => STATUT_MOUVEMENT[1],
            'quantite'       => $value['qte'],
            'employe_id'     => $employe,
            'prix_vente'     => $value['prix_vente'],
            'entrepot_id'    => $entrepot,
            'date_mouvement' => $date
          ];
        }, $ligneVente);

        // 4. Insert multiple (1 seule requête 🔥)
        Soutra::insertMultiple('mouvement_stock', $rows);
      });

      if ($results) {
        $msg = ["success" => true, "msg" => "Commande validee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }

  public static function encaissement_vente()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_encaisser_vente") {
      extract($_POST);
      $msg = [];

      $data = array(
        'statut_vente' => STATUT_COMMANDE[2],
        'code_vente' => $code
      );
      if (Soutra::update("vente", $data)) {
        $msg = ["success" => true, "msg" => "Commande encaissee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }
  public static function retourner_vente()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_retourner_vente") {
      extract($_POST);
      $msg = [];

      $data = array(
        'statut_vente' => STATUT_COMMANDE[3],
        'code_vente' => $code
      );


      $ligneVente = Soutra::getDetailVente($code, $_SESSION['id_entrepot']);
      // var_dump($ligneVente);
      // return;


      $results = Soutra::transactionData(
        function () use ($data, $ligneVente) {
          Soutra::update("vente", $data);
          $employe = $_SESSION['id_employe'];
          // $entrepot = $_SESSION['id_entrepot'] ?? 7;
          foreach ($ligneVente as $value) {
            $dataMouvement = [
              'article_id' => $value['article_id'],
              'type_mouvement' => STATUT_MOUVEMENT[4],
              'quantite' => $value['qte'],
              'employe_id' => $employe,
              'prix_vente' => $value['prix_vente'],
              'entrepot_id' => $value['entrepot_id'],
              'date_mouvement' => date('Y-m-d')
            ];
            Soutra::inserted('mouvement_stock', $dataMouvement);
          }
        }
      );

      if ($results) {
        $msg = ["success" => true, "msg" => "Commande retournee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }
  public static function annulation_vente()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_annuler_vente") {
      extract($_POST);
      $msg = [];

      $data = array(
        'statut_vente' => STATUT_COMMANDE[4],
        'code_vente' => $code
      );
      if (Soutra::update("vente", $data)) {
        $msg = ["success" => true, "msg" => "Commande annulee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }
}

//fin de la class
