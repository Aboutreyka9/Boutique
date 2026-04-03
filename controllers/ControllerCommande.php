<?php

class ControllerCommande extends Connexion
{

  // connexion utilisateur


  public static function getcommande()
  {
    if (isset($_POST["frm_upcommande"])) {
      $id_sortie = $_POST["id_sortie"];
      $article = Soutra::getSingleventeArticle($id_sortie);
      $commande = Soutra::getAllTable('sortie', 'ID_sortie', $id_sortie);

      $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="article_id">Article - Slug - Mark</label>
              <select name="article_id" id="article_id" class="form-control">
              ';
      // foreach ($article as $row) {
      // $selected = $commande[0]["article_id"] == $row["ID_article"] ? " selected" : "";
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
              <label for="prix_commande">prix</label>
               <input type="number" min="0" name="prix_commande" value="' . $commande[0]['prix_commande'] . '" id="prix_commande" class="form-control">
            </div>
            <input type="hidden"  name="id_sortie" value="' . $commande[0]['ID_sortie'] . '" class="form-control">

          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="qte">Quantité</label>
               <input type="number" min="0" name="qte" value="' . $commande[0]['qte'] . '" id="qte" class="form-control qte_commande_detail">
            </div>
          </div>
            ';


      echo $output;
    }
  }


  public static function liste_commande($id_client)
  {
    $output = '';
    $vente_client = Soutra::getAllListeVenteClient($id_client);

    if (!empty($vente_client)) {
      $i = 0;
      foreach ($vente_client as $row) {
        $i++;

        $output .= ' 
                <div id="accordion" class="card-expansion">
                <section class="card card-expansion-item">
                  <header style="background-color: #c5c5c5;" class="card-header border-0" id="heading' . $i . '">
                    <button data-istrue="false" data-codevente="' . $row['code_vente'] . '" class="btn btn-reset collapsed open_vente_detail" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapse' . $i . '"><span class="collapse-indicator mr-2"><i class="fa fa-fw fa-caret-right"></i></span> <span>' . $row['code_vente'] . '#</span>
                    <span>(' . number_format($row['total'], 0, ",", " ") . ' FCFA) / </span>
                    <span>' . Soutra::date_format($row['created_at']) . '</span>
                  </button>
                    
                  </header>
                  <div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent="#accordion">
                    <div class="card-body pt-0">
                    <div class="table-responsive">
                          <table class="table table-hover">
                          <thead>
                          <tr>
                              <th> Article </th>
                              <th> MARK </th>
                              <th> FAMILLE </th>
                              <th> PRIX VENTE </th>
                              <th> QUANTITE </th>
                              <th> TOTAL </th>
                          </tr>
                          </thead>
                          <tbody id="' . $row['code_vente'] . '">
                              
                          </tbody>
                      </table>
                      </div>
                      
                    </div>
                  </div>
                </section>
            
            </div>
                ';
      }
    }
    return $output;
  }


  public static function liste_detail_commande($id)
  {
    $detail = Soutra::getDetailvente($id);

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
          <td class="text-right pu">' . number_format($row['prix_commande'], 0, ",", " ") . '</td>
          <td class="text-right qte">' . $row['qte'] . '</td>
          <td class="text-right total">' . number_format($row['prix_commande'] * $row['qte'], 0, ",", " ") . '</td>
           ';
      $garantie = $row['garantie'];
      $dcommande = Soutra::date_format($row['date_commande'], false);
      // $testt = Soutra::dateDiff($dcommande, $garantie);
      //if ($_SESSION["role"] == ADMIN || $emp['employe'] == $_SESSION["id_employe"]) {
      if (Soutra::dateDiff($dcommande, $garantie)) {

        $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_sortie'] . '" class="btn btn-primary btn-sm btn_update_commande">
            <i class="fa fa-edit"></i> modiier </button>
           <div class="d-inline">
               <button data-id="' . $row['ID_sortie'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_data_panier">
               <i class="fa fa-trash"></i> Supprimer</button>
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

  public static function ajouter_panier_commande()
  {
    if (isset($_POST['btn_ajouter_panier_commande'])) {
      $output = '';
      if (!empty($_POST['article'])) {
        $commande = Soutra::getPanierAchat(implode(',', $_POST['article']));
        if (!empty($commande)) {
          $i = 0;
          foreach ($commande as $row) {
            $i++;

            $output .= '
              <tr class="row' . $row['ID_article'] . '">
                 <td class="col id d_none">' . $row['ID_article'] . '</td>
                 <td>' . $i . '</td>
                 <td>' . $row['libelle_article'] . '</td>
                 <td>' . $row['mark'] . '</td>
                <td>' . $row['famille'] . '</td>
                <td class="text-right">' . number_format($row['prix_article'], 0, ",", " ") . '</td>
                <td class="text-right col pu" contenteditable="true">0</td>
                <td class="text-right col qte" contenteditable="true">0</td>
                <td class="text-right col total">0</td>
                 ';

            $output .= '
                 <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                 <div class="d-inline">
                     <button data-id="' . $row['ID_article'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_commande_panier">
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
  }

  public static function btn_remove_commande_detail()
  {
    if (isset($_POST['remove_commande_detail'])) {

      $data = array(
        'etat_sortie' => 0,
        'ID_sortie' => $_POST['id_commande']
      );
      Soutra::update("sortie", $data);
      echo 1;
    }
  }
  public static function verifQteArticlecommande()
  {
    if (isset($_POST['btn_verifQteArticlecommande'])) {
      $entree = Soutra::getCompterSum('entree', 'qte', 'article_id', $_POST['id']);
      $sortie = Soutra::getCompterSum('sortie', 'qte', 'article_id', $_POST['id']);
      $stock = abs($entree - $sortie);
      // echo json_encode();
      if ($stock >= $_POST['qte']) {
        echo 'ok';
      } else {
        echo $stock;
      }
    }
  }
  public static function verifDetail()
  {
    if (isset($_POST['btn_detail555'])) {
      $commande = Soutra::singleventeDetail($_POST['code_vent']);

      echo json_encode($commande);
    }
  }

  public static function ajouter_commande()
  {
    if (isset($_POST['btn_ajouter_commande'])) {

      if (isset($_POST['id_sortie'])) {
        // mod()
        self::modifier_commande();
      } else {
        // Ajouter
        self::createcommande();
      }
    }
  }

  public static function createcommande()
  {
    extract($_POST);

    $verifEmpty = false;
    $verifType = false;
    $msg = "";

    // || empty($qte[$i])

    if (empty($pu) || empty($qte)) {
      $msg = '2&Desolé Verifier les informations.';
    } else {

      for ($i = 0; $i < count($pu); $i++) {
        if (empty(trim($pu[$i])) || empty(trim($qte[$i]))) {
          $verifEmpty = true;
        } elseif (!ctype_digit($pu[$i]) || !ctype_digit($qte[$i]) || $qte[$i] < 1) {
          $verifType = true;
        }
      }

      if ($verifEmpty) {
        $msg =  '2&Veuillez Entrer toutes les valeurs !';
      } elseif ($verifType) {
        $msg = '2&Verifier les valeurs renseignées';
      } else {
        $date = date('Y-m-d');
        $code = self::checkCode();
        $code = strtoupper($code);

        $data = array(
          'code_vente' => $code,
          'client_id' => $client,
          'employe_id' => $_SESSION['id_employe'],
          'etat_vente' => 2,
          'created_at' => $date
        );
        $msg = '2&Une erreur est survenue! ';

        if (Soutra::insert("vente", $data)) {

          for ($i = 0; $i < count($pu); $i++) {
            $commande = array(
              'vente_id' => $code,
              'article_id' => $id[$i],
              'prix_vente' => $pu[$i],
              'qte' => $qte[$i]
            );
            if (Soutra::insert("sortie", $commande)) {
              $msg = "1&$code#commande Ajouté avec succès.";
            }
          }
        }
      }
      // echo $msg;
    }
    echo $msg;
  }


  public static function checkCode()
  {
    $code = "VT" . date('y') . date('d') . rand(10, 9999);
    if (!empty(Soutra::libelleExiste('vente', 'code_vente', $code))) {
      self::checkCode();
    }
    return $code;
  }
  public static function modifier_commande()
  {
    extract($_POST);
    $msg = "";

    if (empty($prix_commande) || empty($qte)) {
      $msg = '2&Veuillez remplir tous les champs !';
    } elseif (!ctype_digit($prix_commande) || $prix_commande < 0) {
      $msg = '2&Le montant est invalide !';
    } elseif (!ctype_digit($qte) || $qte <= 0) {
      $msg = '2&La quantité est invalide !';
    } else {
      $data = array(
        'prix_commande' => $prix_commande,
        'qte' => $qte,
        'ID_sortie' => $id_sortie
      );
      if (Soutra::update("sortie", $data)) {
        $code_commande = Soutra::libelle('sortie', 'commande_id', 'ID_sortie', $id_sortie);
        $retour = self::liste_detail_commande($code_commande);
        $msg = "1 & $retour & Element modifié avec succès.";
      } else {
        $msg = '2&Une erreur est survenue !';
      }
    }
    echo $msg;
  }

  public static function valider_commande()
  {
    $msg = "";
    if (isset($_POST['frm_valider_commande'])) {
      $code = $_POST['code'];
      $client = $_POST['client'];
      $montant = $_POST['montant'];

      $clientInfo = Soutra::getInfoClient($client);
      if (intval($clientInfo['solde_client']) < intval($montant)) {
        $msg = "2& Desolé Solde courant insuffisant!";
      } else {

        if (Soutra::updateVersement($client, -$montant)) {
          $date = date('Y-m-d h:i:s');

          $data = array(
            'etat_vente' => 1,
            'updated_at' => $date,
            'code_vente' => $code,
          );
          Soutra::update("vente", $data);

          $montant = Soutra::getInfoClient($client);
          $montant = number_format($montant["solde_client"], 0, ",", " ");
          $liste = self::liste_commande($client);

          $msg = "1&$liste&$montant&$code&Vente réalisée avec succès.";
        } else {
          $msg = "2& Une erreur est survenue!";
        }
      }
      echo $msg;
    }
  }

  public static function suppresion_commande()
  {
    if (isset($_POST['btn_supprimer_commande'])) {

      $data = array(
        'etat_commande' => 0,
        'ID_commande' => $_POST['id_commande']
      );
      Soutra::update("commande", $data);
      echo 1;
    }
  }
}

//fin de la class
