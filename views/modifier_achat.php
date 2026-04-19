<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $code = $_GET['id'] ?? '';

  $merge = [];

  // TODO: Get command data from database
  $achat = Soutra::getSingleAchatByCode($code);
  $merge = Soutra::getPanierModifierAchat($code);

  if (empty($merge) && !isset($_SESSION['achat'])) {
    pageNotFound();
    return;
  }

  if (!isset($_SESSION['achat']) || $_SESSION['achat'] != $code) {
    $_SESSION['achat'] = $code;
    $_SESSION['panier'] = [];
    foreach ($merge as  $value) {
      $_SESSION['panier'][] = $value['ID_article'];
    }
  }

  if (!empty($_SESSION['panier'])) {

    $data2 = Soutra::getPanierAchat(implode(',', $_SESSION['panier']), $_SESSION['id_entrepot']);

    if (count($merge) < count($data2))
      $merge = mergeByKeyArticlesCommande($merge, $data2, ['prix_achat', 'qte', 'total_ttc']);
  }
} else {
  // error 404
  pageNotFound();
  return;
}
?>
<header class="page-title-bar">
  <h1 class="page-title mb-3"> Espace réapprovisionement</h1>
  <!-- <p class="text-muted"> Ajouter un achat</p> -->
  <!-- floating action -->
  <button type="button" data-code="<?= $achat['reference'] ?>" id="btn_modifier_achat" class="btn btn-success btn-floated" title="Modifier la commande"><span style="line-height: 45px" class="fa fa-plus"></span></button>

  <!-- floating action -->
  <?php if (Soutra::getState('fournisseur') == 1): ?>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form method="post">
              <div class="row my-3">
                <div class="col-md-4">
                  <div style="position: relative;" class="form-group">
                    <label for="fournisseur">Fournisseur</label>
                    <select name="fournisseur" class="form-control fournisseur_search" id="fournisseur">
                      <option value="--- CHOISIR ---"></option>
                      <?php
                      $fournisseur = Soutra::getAllFournisseur();
                      $output = "";
                      foreach ($fournisseur as $row) {
                        $select = $row['ID_fournisseur'] == $achat['ID_fournisseur'] ? 'selected' : '';
                        $output .= '
                  <option ' . $select . ' value="' . $row['ID_fournisseur'] . '">' . $row['nom_fournisseur'] . ' ' . $row['telephone_fournisseur'] . '</option>
                  ';
                      }
                      echo $output;
                      ?>
                    </select>
                    <div id="fournisseur-data-modal" class="wrap-mini-btn">

                      <i data-title="Ajouter un nouveau fournisseur" class="fas fa-user-plus fa-lg"></i>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nom</label>
                    <input readonly type="text" value="<?= $achat['nom_fournisseur'] ?>
                    " id="nom_fournisseur" class="form-control">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>telephone</label>
                    <input readonly type="text" value="<?= $achat['telephone_fournisseur'] ?>
                    " id="telephone_fournisseur"
                      class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Email</label>
                    <input readonly type="email" value="<?= $achat['email_fournisseur'] ?>
                    " id="email_fournisseur" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date d'emission</label>
                    <input type="date"
                      name="date_emission"
                      value="<?= date('Y-m-d', strtotime($achat['date_emission'])) ?>"
                      id="date_emission"
                      class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date d'échéance</label>
                    <input type="date" name="date_echeance" id="date_echeance" class="form-control">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <?php else : ?>
    <input type="hidden" name="fournisseur" id="fournisseur" value="1">
  <?php endif; ?>

  <!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->
<div class="card">
  <div class="card-header">
    <form id="btn_modifier_panier_achat" action="" method="post">
      <div class="row">
        <div class="col-md-10">
          <div class="form-group">
            <label for="article">Article - Mark - Slug</label>
            <select name="article[]" class="form-control" id="select_article" required multiple>

              <?php
              $article = Soutra::getAllArticleFamilleMark();
              $output = "";
              foreach ($article as $row) {
                $output .= '
                  <option value="' . $row['ID_article'] . '">' . $row['libelle_article'] . ' - ' . $row['mark'] . ' - ' . $row['slug'] . '</option>
                  ';
              }
              echo $output;
              ?>
            </select>
          </div>
          <input type="hidden" name="btn_modifier_panier_achat">
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label style="color:transparent ;">readonly</label>
            <button class="btn btn-primary w-100" type="submit"> <i class="fa fa-plus"></i>&ensp; Ajouter</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="card-body">
    <div class="row row_montant">
      <div class="col-md-12 mb-3 ">
        <span style="font-size: 35px;">Montant :</span> <span class="mtt" style="font-size: 35px;"> 0</span> <span style="font-size: 35px;"> FCFA</span>
      </div>
    </div>
    <div class="table-responsive panier_achat_content ">
      <!-- .table -->
      <table class="table table-striped table-hover table_total table_commande">
        <!-- thead -->
        <thead class="thead-dark">
          <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 20%;">Article</th>
            <th style="width: 10%;">Catégorie</th>
            <th style="width: 8%;">Mark</th>
            <th style="width: 8%;">PU</th>
            <th style="width: 10%;">Quantité</th>
            <th style="width: 10%;">Total</th>
            <th style="width: 10%;">Action</th>
          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="achat-table">
          <?php
          $i = 0;
          $output = '';
          foreach ($merge as $row) {
            $i++;

            $output .= '
              <tr data-code="' . $row['ID_article'] . '">
                 <td>' . $i . '</td>
                 <td>' . $row['libelle_article'] . '</td> 
                 <td>' . $row['famille'] . '</td>
                 <td>' . $row['mark'] . '</td>
                <td class="label-price col pu" contenteditable="true">' . $row['prix_achat'] . '</td>
                <td class="label-price col qte" contenteditable="true">' . $row['qte'] . '</td>
                <td class="col total">' . $row['total_ttc'] . '</td>
                 ';

            $output .= '
                  <td> 
                      <button data-achat="' . $_SESSION['achat'] . '" data-id="' . $row['ID_article'] . '" title="Supprimer l\'article de la liste" class="btn btn-danger btn-sm btn_remove_data_modifier_panier">
                      <i class="fa fa-trash"></i> </button> 
                  
                </td>
                  </tr>
                  ';
          }
          echo $output;
          ?>

        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive -->
  </div>
</div>
<?= modalAchatFournisseur() ?>