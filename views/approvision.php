<?php
if (notAdmin()) {
  return;
}
?>
<header class="page-title-bar">
  <!-- floating action -->
  <button type="button" id="btn_ajouter_achat" class="btn btn-success btn-floated" title="Effectuer Achat"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->

  <?php if (Soutra::getState('fournisseur') == 1) : ?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="fournisseur">Fournisseur</label>
          <select name="fournisseur" class="form-control fournisseur_search" id="fournisseur">
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
        </div>
      </div>

    </div>

  <?php else: ?>
    <input type="hidden" name="fournisseur" value="1" id="fournisseur">
  <?php endif; ?>
  <!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->
<div class="row row_montant">
  <div class="col-md-12 mb-3 col-12 col-md-* col-lg-*">
    <span style="font-size: 35px;">Montant :</span> <span class="mtt" style="font-size: 35px; font-style: italic;">0</span>
  </div>
</div>
<div class="table-responsive panier_achat_content col-12 col-md-* col-lg-*">
  <!-- .table -->
  <table class="table table-striped table-hover table_total">
    <!-- thead -->
    <thead class="thead-dark">
      <tr>
        <th> # </th>
        <th style="width: 30%;"> Article </th>
        <th> MARK </th>
        <th> FAMILLE </th>
        <th style="width: 25%;"> PRIX VENTE </th>
        <th> PRIX ACHAT </th>
        <th> QUANTITE </th>
        <th> TOTAL </th>
        <th style="width: 1%; text-align: center; "> ACTION </th>
      </tr>
    </thead><!-- /thead -->
    <!-- tbody -->
    <tbody class="achat-table">
      <?php
      $output = '';
      if (!empty($_GET['id'])) {
        $achat = Soutra::getPanierAchat($_GET['id']);
        if (!empty($achat)) {
          $i = 0;
          foreach ($achat as $row) {
            $i++;

            $output .= '
            <tr class="row' . $row['ID_article'] . '">
               <td class="col id d_none">' . $row['ID_article'] . '</td>
               <td>' . $i . '</td>
               <td>' . $row['libelle_article'] . '</td>
               <td>' . $row['mark'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td>' . number_format($row['prix_article'], 0, ",", " ") . '</td>
              <td class="col pu" contenteditable="true">0</td>
              <td class="col qte" contenteditable="true">0</td>
              <td class="col total">0</td>
               ';

            $output .= '
               <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
               <div class="d-inline">
                   <button data-id="' . $row['ID_article'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_data_panier">
                   <i class="fa fa-trash"></i> Supprimer</button>
               </div>
             </td>
                </tr>
                ';
          }
        }
        echo $output;
      }
      ?>
    </tbody><!-- /tbody -->
  </table><!-- /.table -->
</div><!-- /.table-responsive -->