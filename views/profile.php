<?php $id_employe = @$_GET['id']; ?>
<!-- .page-section -->
<div class="page-section">
      <h1 class="page-title"> Profil Employé</h1>
    <p class="text-muted"> Détails</p>
  <input type="hidden" id="canvas_accueil_page">
  <input type="hidden" id="profile_employe" value="<?= $id_employe?>">
                <!-- .section-block -->
                <div class="section-block">
                  <!-- metric row -->
                  <div class="metric-row">
                    <!-- metric column -->
                    <div class="col-md-3">
                      <div class="card custom-card-detail">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="icon bg-info mr-2">
                              <i class="bi bi-cart-plus"></i>
                            </div>
                            <h6><span class="text-muted text-uppercase">Valeur Total Achat</span> </h6>
                          </div>
                          <h5><span id="total_achat"><?= number_format(Soutra::getSumMontantAchatByEmploye(1,$id_employe) ??0,0,","," ") ?>
                            </span> FCFA</h5>
                        </div>
                      </div>
                    </div>
                    <!-- /metric column -->
                    <!-- metric column -->
                    
                    <div class="col-md-3">
                      <div class="card custom-card-detail">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="icon bg-success mr-2">
                              <i class="bi bi-cash-coin"></i>
                            </div>
                            <h6><span class="text-muted text-uppercase">Valeur Total Vente</span> </h6>
                          </div>
                          <h5><span id="value"><?= number_format(Soutra::getSumMontantVenteByEmploye(1,$id_employe) ??0,0,","," ") ?>
                            </span> FCFA</h5>
                        </div>
                      </div>
                    </div>

                    <!-- /metric column -->
                    <!-- metric column -->
                    
                    <div class="col-md-3">
                      <div class="card custom-card-detail">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="icon bg-info mr-2">
                              <i class="bi bi-box-seam"></i>
                            </div>
                            <h6><span class="text-muted text-uppercase">Nombre Article Vendu</span> </h6>
                          </div>
                          <h5><span id="value"><?= Soutra::getCompterVenteArticleByEmploye(1,$id_employe) ??0 ?></span></h5>
                        </div>
                      </div>
                    </div>
                    
                    <!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-md-3">
                      <div class="card custom-card-detail">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="icon bg-success mr-2">
                              <i class="bi bi-people"></i>
                            </div>
                            <h6><span class="text-muted text-uppercase">Nombre Client</span> </h6>
                          </div>
                          <h5><span id="value"><?= Soutra::getCompterClientByEmploye(1,$id_employe) ??0 ?></span></h5>
                        </div>
                      </div>
                    </div>
                    <!-- /metric column -->
                  </div>
                  <!-- /metric row -->
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
                      <select class="form-control select_year" name="" id="select_year_employe"> 
                      </select>  &nbsp; &nbsp; 
                  <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
                      <div class="chartjs" style="height: 300px">
                        <canvas id="canvas_employe"></canvas>
                      </div>
                    </section><!-- /.card -->
                  </div><!-- /grid column -->
                </div><!-- /grid row -->
                <!-- grid row -->
                </div><!-- /.page-section -->