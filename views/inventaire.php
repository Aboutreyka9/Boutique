<?php
if (!isAdminGestionnaire()) {
  return;
}
?>
<?php
// Dates par défaut
$states = Soutra::getTotalInventaire();
?>
<header class="page-title-bar">

 <div class="header-inventaire d-flex align-items-center mb-4">
  <i class="bi bi-box-seam me-3 mr-2" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Espace Inventaire</h4>
    <small>Gestion du stock et suivi des mouvements</small>
  </div>
<!-- form here -->
  <div class="ml-auto" >
    <!-- search1 field select for annee-->
    <select class="form-control" id="annee_inventaire_search" name="annee_inventaire_search">
  <?php
  $annees = Soutra::getFormNowToFirstYearAchatForFiltersByEntrepot();
  $annee_actuelle = date('Y');
  foreach ($annees as $annee): ?>
      <option value="<?= $annee ?>" <?= ($annee == $annee_actuelle) ? 'selected' : '' ?>>
          <?= $annee ?>
      </option>
  <?php endforeach; ?>

</select>
  </div>
  <div class="ml-auto" >
    <!-- search2 field select for article-->
   <select class="form-control select2" id="article_inventaire_search" name="article_inventaire_search">
  <option value="">Tous les articles</option>

  <?php 
  $articles = Soutra::getArticlesFiltersByEntrepot();
  foreach ($articles as $row): ?>
    <option value="<?= htmlspecialchars($row['id_article']) ?>">
      <?= htmlspecialchars($row['article'].' - '.$row['prix_vente']) ?>
    </option>
  <?php endforeach; ?>

</select>
  </div>
  <div class="ml-auto" >
    <!-- search2 field select for inventaire date-->
    <select class="form-control" id="inventaire_id_mouvement_search" name="id_mouvement">
      <option value="">Toutes les dates</option>
      
    </select>
  </div>
  <div class="ml-auto" >
    <!-- btn search -->
    <button type="submit" class="btn btn-primary btn_inventaire_search_filters">
      <i class="bi bi-search"></i>
    </button>
  </div>
</div>
  <!-- Résumé des ventes -->
<!-- states -->
  <div class="row g-3 mb-1">

  <!-- QTE INITIALE -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-primary mr-2">
            <i class="bi bi-box-seam"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Qté initiale</span></h6>
        </div>
        <h5 clas="qte_approvisionnement" ><?= number_format($states['qte_approvisionnement'] ?? 0, 0, ',', ' ') ?></h5>
      </div>
    </div>
  </div>

  <!-- COUT ACHAT -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-warning mr-2">
            <i class="bi bi-bag"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Coût d’achat</span></h6>
        </div>
        <h5 class="cout_achat"><?= number_format($states['cout_achat'] ?? 0, 0, ',', ' ') ?> FCFA</h5>
      </div>
    </div>
  </div>

  <!-- QTE VENDUE -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-info mr-2">
            <i class="bi bi-cart-check"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Qté vendue</span></h6>
        </div>
        <h5 class="qte_vendue"><?= number_format($states['qte_vendue'] ?? 0, 0, ',', ' ') ?></h5>
      </div>
    </div>
  </div>

  <!-- MONTANT VENTES -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cash-coin"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Chiffre d’affaires</span></h6>
        </div>
        <h5 class="montant_vendu"><?= number_format($states['montant_vendu'] ?? 0, 0, ',', ' ') ?> FCFA</h5>
      </div>
    </div>
  </div>

  <!-- BENEFICE -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-dark mr-2">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Bénéfice</span></h6>
        </div>
        <h5 class="benefice"><?= number_format($states['benefice'] ?? 0, 0, ',', ' ') ?> FCFA</h5>
      </div>
    </div>
  </div>

  <!-- QTE RESTANTE -->
  <div class="col-md-4">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-danger mr-2">
            <i class="bi bi-box"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Stock restant</span></h6>
        </div>
        <h5 class="qte_restante" ><?= number_format($states['qte_restante'] ?? 0, 0, ',', ' ') ?></h5>
      </div>
    </div>
  </div>

  <!-- MONTANT RESTANT -->
  <div class="col-md-12">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-danger mr-2">
            <i class="bi bi-currency-dollar"></i>
          </div>
          <h6><span class="text-muted text-uppercase">Valeur du stock</span></h6>
        </div>
        <h5 class="montant_quantite_restant"><?= number_format($states['montant_quantite_restant'] ?? 0, 0, ',', ' ') ?> FCFA</h5>
      </div>
    </div>
  </div>

</div>
  <!-- floating action -->
  <a href="<?= URL ?>ajouter_achat" class="btn btn-success btn-floated" title="Ajouter vente">
    <span style="line-height: 45px" class="fa fa-plus"></span>
  </a>

  <!-- title and toolbar -->
  <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">

  </div>
</header>


<div class="table-responsive bg-light py-3 px-2 border rounded">
  <!-- .table -->
  <table class="table table-striped table-hover my-table">
    <!-- thead -->
    <thead class="bg-light">
      <tr>
        <th> # </th>
        <th class="text-right"> Article </th>
        <th class="text-right">Qte initial </th>
        <th class="text-right">Cout d'achat </th>
        <!-- <th class="text-right"> Depenses (FCFA)</th> -->
        <th class="text-right">Qte vendue </th>
        <th class="text-right"> Ventes (FCFA)</th>
        <th class="text-right">Befices </th>
        <th class="text-right"> Qte Reste</th>
        <th class="text-right"> Montant (FCFA) </th>
      </tr>
    </thead><!-- /thead -->
    <!-- tbody -->
    <tbody class="inventaire-table">

      <?php
      $i = 0;
      $stock = Soutra::getAllByElement('vue_bilan_articles', 'entrepot_id', $_SESSION['id_entrepot']);
      //   $comptabilite = [];
      if (!empty($stock)) {
        foreach ($stock as $key => $value) {
          $i++;
      ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $value['libelle_article'] ?></td>
            <td><?= $value['qte_approvisionnement'] ?></td>
            <td><?= number_format($value['cout_achat'], 0, ",", " ") ?> FCFA</td>
            <td><?= $value['qte_vendue']  ?> </td>
            <td><?= number_format($value['montant_vendu'], 0, ",", " ") ?></td>
            <td><?= number_format($value['benefice'], 0, ",", " ") ?></td>
            <td><?= $value['qte_restante']  ?> </td>
            <td><?= number_format($value['montant_quantite_restant'], 0, ",", " ")  ?> </td>

          </tr>
      <?php
        }
      }
      ?>
    </tbody><!-- /tbody -->
  </table><!-- /.table -->
</div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->