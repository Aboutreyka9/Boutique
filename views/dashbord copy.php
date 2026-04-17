<?php if (strtolower($_SESSION['role']) == ADMIN):

  $today = date("Y-m-d");

  // Dates par défaut
  $start = (new DateTime('first day of this month'))->format('Y-m-d');
  $end = (new DateTime('today'))->format('Y-m-d');

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
  <div class="row g-3">
    <div class="col-md-12">
      <h4>APERCU GENERAL DU JOUR</h4>
    </div>
    <!-- CARD -->
    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-success">
          <<i class="bi bi-cart4"></i>
        </div>
        <h6>VENTES (86)</h6>
        <h5>712 548.360 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-orange"><i class="bi bi-cart-plus"></i></div>
        <h6>REAPPROVISIONNEMENT (54)</h6>
        <h5>170 553 655 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-info"><i class="bi bi-cart-dash-fill"></i></div>
        <h6>PRODUITS (<?= Soutra::getCompter('article', 'ID_article', 'etat_article', 1); ?></span>)</h6>
        <h5>542 </h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-purple"><i class="bi bi-person-plus-fill"></i></div>
        <h6>CLIENTS</h6>
        <h5><?= Soutra::getCompter('client', 'ID_client', 'etat_client', 1); ?></span></h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-danger"><i class="bi bi-person-plus-fill"></i></div>
        <h6>FOURNISSEURS</h6>
        <h5><?= Soutra::getCompter('fournisseur', 'ID_fournisseur', 'etat_fournisseur', 1); ?></span></h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-4">
      <div class="card stat-card">
        <div class="icon bg-warning"><i class="bi bi-person"></i></div>
        <h6>EMPLOYERS</h6>
        <h5><span><?= Soutra::getCompter('employe', 'ID_employe', 'etat_employe', 1); ?></span></h5>
      </div>
    </div>

  </div>


  <hr class="bg-info">


  <!-- CARDS -->
  <div class="row g-3">

    <div class="col-md-12 mb-4 mt-2">
      <div class="mb-3" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
        <div class="title">
          <h1 class="page-title">Statistiques</h1>
        </div>
        <div class="activity">
          <b id="activityDateRange">Activité du <?= $dateD . ' au ' . $dateF; ?> </b>
        </div>
        <div class="input-group" style="max-width: 40%;">
          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          <input type="text" id="filterInventaire" class="form-control" placeholder="Sélectionner la période">
          <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

        </div>
      </div>
    </div>

    <!-- CARD -->
    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-success"><i class="bi bi-wallet2"></i></div>
        <h6>ENCAISSÉ</h6>
        <h5>7.360 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-info"><i class="bi bi-credit-card"></i></div>
        <h6>RÈGLEMENTS</h6>
        <h5>2.860 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-purple"><i class="bi bi-cart"></i></div>
        <h6>VENTES</h6>
        <h5><span><?= number_format(Soutra::getSumMontantVenteToDay($today, 1) ?? 0, 0, ',', ' '); ?></span> CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-danger"><i class="bi bi-cash"></i></div>
        <h6>DÉPENSES</h6>
        <h5>0 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-warning"><i class="bi bi-arrow-repeat"></i></div>
        <h6>RÉAPPRO</h6>
        <h5> <span class="value"><?= Soutra::getCompterAchat(1); ?></span> CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-orange"><i class="bi bi-tag"></i></div>
        <h6>REMISES</h6>
        <h5>0 CFA</h5>
      </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-primary"><i class="bi bi-currency-exchange"></i></div>
        <h6>BÉNÉFICES</h6>
        <h5>14.780 CFA</h5>
      </div>
    </div>

  </div>

  <!-- .page-section -->
  <div class="page-section container ">
    <hr>

    <div class="row mt-5">
      <!-- grid column -->
      <!-- .col -->
      <div class="col-lg-4">
        <!-- .card -->
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-header -->
          <div class="d-flex justify-content-between col-12 col-md-* col-lg-*">
            <header class="card-header pb-3"> Niveau du Stock </header><!-- /.card-header -->
            <button class="btn btn-sm btn-info toggle-btn" type="button" data-toggle="collapse" data-target="#stock_level1" aria-expanded="true">+</button>
          </div>
          <div class="collapse show col-12 col-md-* col-lg-*" id="stock_level1">
            <?php

            $stock = Soutra::getStockLimit();
            foreach ($stock as $key => $value) { ?>

              <div class="card-body border-top">
                <dl class="d-flex justify-content-between">
                  <dt class="text-left">
                    <span class="mr-2"><?= $value['article']; ?></span>
                    <?php if ($value['niveau'] == 'bien') : ?>
                      <small class="text-success"><i class="fa fa-caret-up"></i> <?= number_format($value['moyenne'], 1); ?>%</small>
                    <?php else: ?>
                      <small class="text-danger"> <i class="fa fa-caret-down"></i> <?= number_format($value['moyenne'], 1); ?>%</small>
                    <?php endif; ?>
                  </dt>
                  <dd class="text-right mb-1">
                    <strong><?= $value['qte_reste']; ?></strong> /<small class="text-muted"><?= $value['stock_alert']; ?></small>
                  </dd>
                </dl>
              </div><!-- /.card-body -->

            <?php }
            ?>
          </div>
        </section><!-- /.card -->
      </div><!-- /.col -->

      <!-- .col -->
      <div class="col-lg-4">
        <!-- .card -->
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-header -->
          <div class="d-flex justify-content-between col-12 col-md-* col-lg-*">
            <header class="card-header pb-3"> Les articles les plus vendus </header><!-- /.card-header -->
            <button class="btn btn-sm btn-info toggle-btn" type="button" data-toggle="collapse" data-target="#stock_level2" aria-expanded="true">+</button>
          </div>
          <div class="collapse show col-12 col-md-* col-lg-*" id="stock_level2">

            <?php

            $stock = Soutra::getBestVente();
            foreach ($stock as $key => $value) { ?>

              <div class="card-body border-top">
                <dl class="d-flex justify-content-between">
                  <dt class="text-left">
                    <span class="mr-2"><?= $value['article']; ?></span>

                  </dt>

                </dl>
              </div><!-- /.card-body -->

            <?php }
            ?>
          </div>
        </section><!-- /.card -->
      </div><!-- /.col -->

      <!-- .col -->
      <div class="col-lg-4">
        <!-- .card -->
        <section class="card card-fluid">
          <div class="d-flex justify-content-between col-12 col-md-* col-lg-*">
            <header class="card-header pb-3"> Montant de chaque article vendu</header><!-- /.card-header -->
            <button class="btn btn-sm btn-info toggle-btn" type="button" data-toggle="collapse" data-target="#article_vente" aria-expanded="true">+</button>
          </div>
          <!-- .card-body -->
          <div class="collapse show col-12 col-md-* col-lg-*" id="article_vente">
            <div class="card-body">
              <canvas id="canvas_article_vente" class="chartjs" style="height: 150px"></canvas>
            </div><!-- /.card-body -->
          </div><!-- /.collapse show -->

        </section><!-- /.card -->
      </div><!-- /grid column -->
      <!-- .col -->

    </div><!-- /grid row -->

    <hr>

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