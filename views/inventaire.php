<?php
 if (!isAdminGestionnaire()) {
     return;
 }
  ?>

<?php
// Dates par défaut
$start = (new DateTime('first day of this month'))->format('Y-m-d');
$end = (new DateTime('today'))->format('Y-m-d');

$dateD = (new DateTime('first day of this month'))->format('d-m-Y');
$dateF = (new DateTime('today'))->format('d-m-Y');

// Récupérer les achats du mois courant
$depenses_mois = Soutra::getTotauxDepenseByMouth($start, $end); // méthode adaptée que l'on a créée

// Récupérer les achats du mois courant
$achat_mois = Soutra::getTotauxAchatByDateRange($start, $end); // méthode adaptée que l'on a créée

// Récupérer les achats du mois courant
$vente_mois = Soutra::getTotauxVenteByDateRange($start, $end); // méthode adaptée que l'on a créée

// benefice net
$benefice = $vente_mois['total_montant'] - ($depenses_mois['total'] + $achat_mois['total']);
$type = $benefice > 0 ? 'text-success' : 'text-danger';

?>
<header class="page-title-bar">

  <div class="mb-3 stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
    <div class="title">
      <h1 class="page-title">Espace Inventaire</h1>
    </div>
    <div class="activity">
      <b id="activityDateRange">Activité du <?= $dateD . ' au ' . $dateF; ?> </b>
    </div>
    <div class="input-group w-100 w-md-auto filter-box">
      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
      <input type="text" id="filterInventaire" class="form-control" placeholder="Sélectionner la période">
      <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

    </div>
  </div>
  <!-- Résumé des ventes -->

  <!-- STATS -->
  <div class="row g-3 mb-1">

    <div class="col-md-6">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-info mr-2">
              <i class="bi bi-cart-plus"></i>
            </div>
            <h6><span class="text-muted text-uppercase">Achats total</span> </h6>
          </div>
          <h5><span id="total_achat"><?= number_format($achat_mois['total'] ?? 0, 0, ',', ' ') ?>
            </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-success mr-2">
              <i class="bi bi-check2-circle"></i>
            </div>
            <h6><span class="text-muted text-uppercase">Dépense total</span> </h6>
          </div>
          <h5><span id="total_depense"><?= number_format($depenses_mois['total'] ?? 0, 0, ',', ' ') ?>
            </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-success mr-2">
              <i class="bi bi-cash-stack"></i>
            </div>
            <h6><span class="text-muted text-uppercase">Ventes total</span> </h6>
          </div>
          <h5><span class="tester" id="total_vente"><?= number_format($vente_mois['total_montant'] ?? 0, 0, ',', ' ') ?>
            </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-success mr-2">
              <i class="bi bi-cash-stack"></i>
            </div>
            <h6><span class="text-muted text-uppercase">Caisse</span> </h6>
          </div>
          <h5><span class="tester <?= $type ?>" id="total_benefice"><?= number_format($benefice ?? 0, 0, ',', ' ') ?>
            FCFA</span> </h5>
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


<div class="table-responsive">
  <!-- .table -->
  <table class="table table-striped table-hover my-table">
    <!-- thead -->
    <thead class="thead-dark">
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
</div><!-- /.table-responsive -->