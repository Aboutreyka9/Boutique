<?php
if (!isAdminGestionnaire()) {
  pageNotFound();
  return;
}
?>
<header class="page-title-bar">
  <h1 class="page-title mb-3"> Espace réapprovisionement</h1>
  <!-- <p class="text-muted"> Ajouter un achat</p> -->
  <!-- floating action -->
  <button type="button" id="btn_ajouter_achat" class="btn btn-success btn-floated" title="Effectuer Achat"><span style="line-height: 45px" class="fa fa-plus"></span></button>

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
                        $output .= '
                  <option value="' . $row['ID_fournisseur'] . '">' . $row['nom_fournisseur'] . ' ' . $row['telephone_fournisseur'] . '</option>
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
                    <input readonly type="text" id="nom_fournisseur" class="form-control">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>telephone</label>
                    <input readonly type="text" id="telephone_fournisseur"
                      class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Email</label>
                    <input readonly type="email" id="email_fournisseur" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date d'emission</label>
                    <input type="date" name="date_emission" value="<?= date('Y-m-d') ?>" id="date_emission"
                      class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date d'échéance</label>
                    <input type="date" name="date_echeance" value="<?= date('Y-m-d') ?>" id="date_echeance" class="form-control">
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
  <div class="card-body">
    <div class="row row_montant">
      <div class="col-md-12 mb-2 ">
        <span style="font-size: 35px;">Montant :</span> <span class="mtt" style="font-size: 35px;"> 0</span> <span style="font-size: 35px;"> FCFA</span>
      </div>
    </div>
    <hr class="bg-primary y-2">
    <div class="table-responsive bg-light py-3 px-2 border rounded panier_achat_content ">
      <!-- .table -->
      <table class="table table-striped table-hover table_total table_commande">
        <!-- thead -->
        <thead class="bg-light">
          <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 20%;">Article</th>
            <th style="width: 10%;">Catégorie</th>
            <th style="width: 8%;">Mark</th>
            <th style="width: 8%;">PU</th>
            <th style="width: 10%;">Quantité</th>
            <th style="width: 10%;">Total</th>
          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="achat-table">
          <?php
          $output = '';
          if (!empty($_GET['id'])) {
            $achat = Soutra::getPanierAchat($_GET['id'], $_SESSION['id_entrepot']);

            if (!empty($achat)) {
              $row = $achat[0];
              $i = 1;

              $output .= '
            <tr class="row' . $row['ID_article'] . '">
               <td class="col id d_none">' . $row['ID_article'] . '</td>
               <td>' . $i . '</td>
               <td>' . $row['libelle_article'] . '</td>
               <td>' . $row['mark'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td class="label-price col pu" contenteditable="true">' . $row['prix_achat'] . '</td>
              <td class="label-price col qte" contenteditable="true">0</td>
              <td class="col total">0</td>
                </tr>
                ';
            }
            echo $output;
          }
          ?>
        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
  </div>
</div>