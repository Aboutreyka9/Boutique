<?php 
// session_destroy();
// var_dump($_SESSION);

if (strtolower($_SESSION['role']) == ADMIN):

  $today = date("Y-m-d");

  // Dates par défaut
  $start = (new DateTime('first day of this month'))->format('Y-m-d');
  $end = (new DateTime('today'))->format('Y-m-d');

  $dateD = (new DateTime('first day of this month'))->format('d-m-Y');
  $dateF = (new DateTime('today'))->format('d-m-Y');
  $entrepot = $_SESSION['entrepot'] ?? null;
  $reapprovisionnements = Soutra::getTotalReapprovisionnementDashboard($start, $end, $entrepot);
  $ventes = Soutra::getTotalVenteDashboard($start, $end, $entrepot);

  // $getTotauxViewStockProduit = Soutra::getTotauxViewStockProduit();
  // var_dump($getTotauxViewStockProduit);

  // var_dump($ventes);
?>
  <!-- DASHBOARD ADMIN  -->

  <header class="page-title-bar container">
    <input type="hidden" id="canvas_page_dashbord" value="123">
    <!-- <p class="lead">
  <span class="font-weight-bold">Hi, Beni.</span> <span class="d-block text-muted">Here’s what’s happening with your business today.</span>
</p> -->
  </header><!-- /.page-title-bar -->




  <!-- CARDS -->
  <div class="row g-3 dashboard_admin">

<div class="col-md-12 mb-4 mt-2">

  <div class="stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

    <!-- Titre -->
    <div class="title">
      <h1 class="page-title mb-1 mb-md-0">Statistiques</h1>
    </div>

    <!-- Activité -->
    <div class="activity text-md-center">
      <b id="activityDateRange">
        Activité du <?= $dateD . ' au ' . $dateF; ?>
      </b>
    </div>

    <!-- Filtre -->
    <div class="input-group w-100 w-md-auto filter-box">
      <span class="input-group-text">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" id="filterDashboardAdmin" class="form-control" placeholder="Sélectionner la période">
      <button id="filterBtn" class="btn btn-primary">
        <i class="fa fa-filter"></i>
      </button>
    </div>

  </div>

</div>
    <!-- STATS -->
    <div class="row g-3 mb-1">


      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="bi bi-credit-card"></i>
              </div>
              <h6><span class="text-muted text-uppercase">DETTE FOURNISSEURS</span> (<span id="nombre_dette_fournisseur"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_dette_fournisseur"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="bi bi-wallet"></i>
              </div>
              <h6><span class="text-muted text-uppercase">DETTE CLIENTS</span> (<span id="nombre_dette_client"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_dette_client"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

            <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="bi bi-cash-coin"></i>
              </div>
              <h6><span class="text-muted text-uppercase">DÉPENSES</span> (<span id="nombre_depense"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_depense"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>




      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <h6><span class="text-muted text-uppercase">RÉAPPRO </span> (<span id="nombre_reapprovisionnement"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_reapprovisionnement"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-cart-plus"></i>
              </div>
              <h6><span class="text-muted text-uppercase">VENTES</span> (<span id="nombre_vente"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_vente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-currency-exchange"></i>
              </div>
              <h6><span class="text-muted text-uppercase">BÉNÉFICES</span> (<span id="nombre_benefice"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_benefice"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                  <i class="bi bi-alarm"></i>
              </div>
              <h6><span class="text-muted text-uppercase">ACHAT EN ATTENTE</span> </h6>
            </div>
            <h5><span id="achat_attente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                <i class="bi bi-alarm"></i>
              </div>
              <h6><span class="text-muted text-uppercase">VENTE EN ATTENTE</span> </h6>
            </div>
            <h5><span id="vente_attente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                  <i class="bi bi-bell"></i>
              </div>
              <h6><span class="text-muted text-uppercase">STOCK DISPO</span> (<span id="nombre_stock_dispo"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_stock_dispo"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                <i class="bi bi-envelope-exclamation-fill"></i>
              </div>
              <h6><span class="text-muted text-uppercase">STOCK ALERT</span></h6>
            </div>
            <h5><span id="nombre_stock_alert"> 0 </span> </h5>
          </div>
        </div>
      </div>


    </div>


    <!-- CARD -->






  </div>

  <!-- .page-section -->
  <div class="page-section container ">


    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-xl-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex justify-content-between  align-items-center mb-4 col-12 col-md-* col-lg-*">
              <h3 class="card-title mb-0"> Montant des ventes de la Semaine</h3><!-- .card-title-control -->
              <button class="btn btn-sm btn-info toggle-btn " type="button" data-toggle="collapse" data-target="#week_chart" aria-expanded="true">+</button>
            </div><!-- /.d-flex -->
            <div id="week_chart" class="collapse show col-12 col-md-* col-lg-*">
              <div class="chartjs" style="height: 291px">
                <canvas id="week_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /grid row -->

    <hr>

    <!-- section-deck -->
    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-xl-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title mb-0"> Montant des ventes par mois</h3><!-- .card-title-control -->
              <div class="card-title-control ml-auto">


                <div class="d-flex">
                  <select style="width: 15em;" class="form-control select_year" name="" id="select_year_dashboard">

                  </select> &nbsp; &nbsp;
                  <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                  <button class="btn btn-sm btn-info toggle-btn ml-2" type="button" data-toggle="collapse" data-target="#month_chart" aria-expanded="true">+</button>

                </div>

              </div><!-- /.card-title-control -->
            </div><!-- /.d-flex -->
            <div id="month_chart" class="collapse show">
              <div class="chartjs" style="height: 291px">
                <canvas id="month_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /row -->
    <hr>
    <!-- section-deck -->
    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-xl-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title mb-0"> Montant des achats par mois</h3><!-- .card-title-control -->
              <div class="card-title-control ml-auto">
                <div class="d-flex">
                  <select style="width: 15em;" class="form-control select_year" name="" id="select_year_dashboard_achat">

                  </select> &nbsp; &nbsp;
                  <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                  <button class="btn btn-sm btn-info toggle-btn ml-2" type="button" data-toggle="collapse" data-target="#month_achat_chart" aria-expanded="true">+</button>
                </div>

              </div><!-- /.card-title-control -->
            </div><!-- /.d-flex -->
            <div id="month_achat_chart" class="collapse show">
              <div class="chartjs" style="height: 291px">
                <canvas id="month_achat_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /row -->
    <!-- section-deck -->
  </div><!-- /.page-section -->

  <!-- CARDS -->
  <div class="row g-3">
    <div class="col-md-12">
      <h4>APERCU GENERAL</h4>
    </div>
    <!-- CARD -->



    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-info"><i class="bi bi-cart-dash-fill"></i></div>
        <h6>PRODUITS </h6>
        <h5><?= Soutra::getCompterArticleEntrepot($_SESSION['id_entrepot']); ?> </h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-purple"><i class="bi bi-person-plus-fill"></i></div>
        <h6>CLIENTS</h6>
        <h5> <span> <?= Soutra::getCompter('client', 'ID_client', 'etat_client', 1); ?></span></h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-danger"><i class="bi bi-person-plus-fill"></i></div>
        <h6>FOURNISSEURS</h6>
        <h5> <span> <?= Soutra::getCompter('fournisseur', 'ID_fournisseur', 'etat_fournisseur', 1); ?></span></h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-warning"><i class="bi bi-person"></i></div>
        <h6>EMPLOYERS</h6>
        <h5><span><?= Soutra::getCompter('employe', 'ID_employe', 'etat_employe', 1); ?></span></h5>
      </div>
    </div>

  </div>



  <script>
    // Script réutilisable pour tous les boutons toggle
    document.querySelectorAll('.toggle-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        setTimeout(() => {
          if (this.getAttribute('aria-expanded') === 'true') {
            this.textContent = '−';
          } else {
            this.textContent = '+';
          }
        }, 200); // petit délai pour que bootstrap mette à jour aria-expanded
      });
    });
  </script>

<?php else: ?>
  <!-- AUTRE EMPLOYE -->
  <?php include 'accueil.php'; ?>

<?php endif; ?>