<?php

if (isAdminGestionnaire()):

  $tresorerie = Soutra::getTotauxTresorerie();
?>
  <!-- DASHBOARD ADMIN  -->

  <div class="col-md-12 mb-4 mt-2">
    <div class="header-base header-tresorerie">
      <i class="bi bi-cash-coin me-3 mr-3" style="font-size:30px;"></i>
      <div>
        <h4 class="mb-0">Trésorerie</h4>
        <small>Suivi des flux financiers</small>
      </div>
    </div>
    <div class="stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

      <!-- Titre -->
      <div class="title">
        <h1 class="page-title mb-1 mb-md-0">Statistiques</h1>
      </div>

    </div>

  </div>
  <!-- STATS -->
  <div class="row g-3 mb-1">


    <div class="col-md-3">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-danger mr-2">
              <i class="bi bi-arrow-up"></i>
            </div>
            <h6><span class="text-muted text-uppercase">ACHAT REGLE</span></h6>
          </div>
          <h5><span id=""> <?= $tresorerie['total_sortie_achat'] ?? 0 ?> </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-danger mr-2">
              <i class="bi bi-arrow-up"></i>
            </div>
            <h6><span class="text-muted text-uppercase">DÉPENSES QUOTIDIENT</span> </h6>
          </div>
          <h5><span id="montant_depense"> <?= $tresorerie['total_depense'] ?? 0 ?> </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-success mr-2">
              <i class="bi bi-arrow-down"></i>
            </div>
            <h6><span class="text-muted text-uppercase">VENTES REGLE</span> </h6>
          </div>
          <h5><span id=""> <?= $tresorerie['total_entree'] ?? 0 ?> </span> FCFA</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-success mr-2">
              <i class="bi bi-cash-coin"></i>
            </div>
            <h6><span class="text-muted text-uppercase">CAISSE </span> </h6>
          </div>
          <h5><span id="montant_reapprovisionnement"> <?= $tresorerie['solde_tresorerie'] ?? 0 ?> </span> FCFA</h5>
        </div>
      </div>
    </div>

  </div>


  <!-- CARD -->






  </div>



<?php else: ?>
  <!-- AUTRE EMPLOYE -->
  <?php include 'accueil.php'; ?>

<?php endif; ?>