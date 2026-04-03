<header class="page-title-bar">
  <!-- floating action -->
  <button type="button" id="btn_ajouter_commande" class="btn btn-success btn-floated" title="Effectuer Achat"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
  <form id="btn_ajouter_panier_achat" action="" method="post">
    <div class="row">
      <div class="col-md-10">
        <div class="form-group">
          <label for="article">Article - Mark-Slug</label>
          <select name="article[]" class="form-control" id="select_article" multiple>
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
        <input type="hidden" name="btn_ajouter_panier_achat">
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label style="color:transparent ;">readonly</label>
          <button class="btn btn-primary w-100" type="submit"> <i class="fa fa-plus"></i>&ensp; Ajouter</button>
        </div>
      </div>
    </div>
  </form>
  <input type="hidden" id="client" value="<?= $_GET['id'] ?>">



  <!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->
<div class="row row_montant d_none">
  <div class="col-md-12 mb-3 ">
    <span style="font-size: 20px;">Montant :</span> <span class="mtt" style="font-size: 20px; font-style: italic;">0</span>
  </div>
</div>
<div class="table-responsive panier_achat_content d_none">
  <!-- .table -->
  <table class="table table-striped table-hover table_total">
    <!-- thead -->
    <thead class="thead-dark">
      <tr>
        <th> # </th>
        <th style="width: 25%; "> Article </th>
        <th> MARK </th>
        <th> FAMILLE </th>
        <th style="width: 35%; "> PRIX .U </th>
        <!-- <th> STOCK</th> -->
        <th style="width: 35px; "> PRIX commande </th>
        <th> QUANTITE </th>
        <th> TOTAL </th>
        <th style="width: 1%; text-align: center; "> ACTION </th>
      </tr>
    </thead><!-- /thead -->
    <!-- tbody -->
    <tbody class="achat-table">
    </tbody><!-- /tbody -->
  </table><!-- /.table -->
</div><!-- /.table-responsive -->