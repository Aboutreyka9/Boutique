<!-- .page-section -->
<div class="page-section">
  <input type="hidden" id="canvas_accueil_page">
  <input type="hidden" id="profile_employe" value="<?= @$_SESSION['id_employe']; ?>">

                <!-- .section-block -->
                <div class="section-block">
                  <!-- metric row -->
                  <div class="metric-row">
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <p class="metric-value h3">
                            <sub><i class="oi oi-dollar"></i></sub> <span class="value"><?= number_format(Soutra::getSumMontantAchatByEmploye(1, $_SESSION['id_employe']) ?? 0, 0, ',', ' '); ?></span>
                          </p>
                          <h2 class="metric-label"> Valeur Total Achat</h2>
                        </div>
                      </div><!-- /.metric -->
                    </div><!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <p class="metric-value h3">
                            <sub><i class="oi oi-dollar"></i></sub> <span class="value"><?= number_format(Soutra::getSumMontantVenteByEmploye(1, $_SESSION['id_employe']) ?? 0, 0, ',', ' '); ?></span>
                          </p>
                          <h2 class="metric-label"> Valeur Total Vente </h2>
                        </div>
                      </div><!-- /.metric -->
                    </div><!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <p class="metric-value h3">
                            <sub><i class="fa fa-tasks"></i></sub> <span class="value"><?= Soutra::getCompterVenteArticleByEmploye(1, $_SESSION['id_employe']) ?? 0; ?></span>
                          </p>
                          <h2 class="metric-label"> Nombre Article Vendu </h2>
                        </div>
                      </div><!-- /.metric -->
                    </div><!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <p class="metric-value h3">
                            <sub><i class="oi oi-people"></i></sub> <span class="value"><?= Soutra::getCompterClientByEmploye(1, $_SESSION['id_employe']) ?? 0; ?></span>
                          </p>
                          <h2 class="metric-label"> Nombre Client </h2>
                        </div>
                      </div><!-- /.metric -->
                    </div><!-- /metric column -->
                  </div><!-- /metric row -->
                  <div class="d-flex justify-content-between align-items-center">
                    <h1 class="section-title mb-0"> Ventes Annuelle </h1><!-- .dropdown -->
                  </div>
                </div><!-- /.section-block -->
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
                <!-- grid row -->
                </div><!-- /.page-section -->