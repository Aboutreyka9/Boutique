<?php
 if (!isAdminGestionnaire()) {
     return;
 }
?>
<header class="page-title-bar">
  <h1 class="page-title mb-3"> Espace Transfert</h1>
  <!-- <p class="text-muted"> Ajouter un achat</p> -->
  <!-- floating action -->
  <button type="button"  id="btn_ajouter_transfert" class="btn btn-success btn-floated" title="Effectuer Transfert"><span style="line-height: 45px" class="fa fa-plus"></span></button> 

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form method="post">
              <!-- entrepot source -->
              <div class="row my-3">
                <div class="col-md-4">
                  <div style="position: relative;" class="form-group">
                    <label for="transfert_entrepot">Entrepôt source</label>
                    <input type="hidden" name="id_entrepot_source" id="id_entrepot_source">
                    <input type="hidden" name="id_entrepot_destination" id="id_entrepot_destination">
                    <select name="transfert_entrepot" class="form-control entrepot_search" id="transfert_entrepot_source">
                      <option value="--- CHOISIR ---"></option>
                      <?php
                      $entrepot = Soutra::getAllTable('entrepot', 'etat_entrepot');
                      $output = "";
                      foreach ($entrepot as $row) {
                        $output .= '
                  <option data-action="source" value="' . $row['ID_entrepot'] . '">' . $row['libelle_entrepot'] . '</option>
                  ';
                      }
                      echo $output;
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Libellé</label>
                    <input readonly type="text" id="libelle_entrepot_source" class="form-control">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Adresse</label>
                    <input readonly type="text" id="adresse_entrepot_source" class="form-control">
                    <input readonly type="text" id="adresse_entrepot_destination" class="form-control">
                  </div>
                </div>
              </div>
              <!-- entrepot destination -->
              <div class="row my-3">
                <div class="col-md-4">
                  <div style="position: relative;" class="form-group">
                    <label for="transfert_entrepot">Entrepôt destination</label>
                    <select name="transfert_entrepot" class="form-control entrepot_search" id="transfert_entrepot_destination">
                      <option value="--- CHOISIR ---"></option>
                      <?php
                      $entrepot = Soutra::getAllTable('entrepot', 'etat_entrepot');
                      $output = "";
                      foreach ($entrepot as $row) {
                        $output .= '
                  <option data-action="destination" value="' . $row['ID_entrepot'] . '">' . $row['libelle_entrepot'] . '</option>
                  ';
                      }
                      echo $output;
                      ?>
                    </select>
                   
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Libellé</label>
                    <input readonly type="text" id="libelle_entrepot_destination" class="form-control">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Adresse</label>
                    <input readonly type="text" id="adresse_entrepot_destination" class="form-control">
                  </div>
                </div>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>

  <!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->
<div class="card">
  <div class="card-header">
    <form id="btn_ajouter_panier_transfert" action="" method="post">
      <div class="row">
        <div class="col-md-10">
          <div class="form-group">
            <label for="article">Article - Mark - Slug</label>
            <select name="article[]" class="form-control" id="select_article" multiple>
              <?php
              $article = Soutra::getAllArticleFamilleMarkTransfert();
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
          <input type="hidden" name="btn_ajouter_panier_transfert">
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
        <span style="font-size: 35px;">Montant : </span> <span class="mtt" style="font-size: 35px;"> 0</span> <span style="font-size: 35px;"> FCFA</span>
      </div>
    </div>
    <div class="table-responsive panier_transfert_content">
      <!-- .table -->
      <table class="table table-striped table-hover table_total">
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
        <tbody class="transfert-table">
        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive -->
  </div>
</div>
