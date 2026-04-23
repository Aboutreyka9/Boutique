<!-- .page-section -->
<?php

  $dateD = (new DateTime('first day of this month'))->format('d-m-Y');
  $dateF = (new DateTime('today'))->format('d-m-Y');

?>
  <!-- DASHBOARD ADMIN  -->

  <header class="page-title-bar container">
    <input type="hidden" id="canvas_page_dashbord" value="123">
    <!-- <p class="lead">
  <span class="font-weight-bold">Hi, Beni.</span> <span class="d-block text-muted">Here’s what’s happening with your business today.</span>
</p> -->
  </header><!-- /.page-title-bar -->




  <!-- CARDS -->
  <div class="container g-3 dashboard_admin">

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

      <div class="col-md-6">
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

      
      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-currency-exchange"></i>
              </div>
              <h6><span class="text-muted text-uppercase">TRESORERIE</span> </h6>
            </div>
            <h5><span id="montant_tresorerie"> 0 </span> </h5>
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



    </div>



  </div><!-- /.section-block -->

  <div class="d-flex justify-content-between align-items-center">
    <h1 class="section-title mb-0"> Ventes Annuelle </h1><!-- .dropdown -->
  </div>
<!-- grid row -->
<div class="row">
  <!-- grid column -->
  <div class="col-xl-12">
    <!-- .card -->
    <section class="card card-body card-fluid">
    <div class="d-flex mb-4">
      <select class="form-control select_year" name="" id="select_year_employe" > 
      </select>  &nbsp; &nbsp; 
  <button class="btn btn-primary">Search</button>
</div>
      <div class="chartjs" style="height: 300px">
        <canvas id="canvas_employe"></canvas>
      </div>
    </section><!-- /.card -->
  </div><!-- /grid column -->
</div><!-- /grid row -->