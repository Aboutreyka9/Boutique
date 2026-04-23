<?php

 if (!isAdminGestionnaire()) {
     return;
 }
  if (Soutra::getState('fournisseur') != 1) {
    include('views/not_found.php');
    return ;
   }

if(notAccessPage(!isset($_GET['id']))){
  return;
}
 

$id = $_GET['id'];
$bilan_fournisseur = Soutra::getBilanFournisseur($id);
$bilan_fournisseur_nbre = Soutra::getBilanFournisseurNbre($id);

// var_dump($liste_versement);
?>
    <!-- .page-section -->
    <div class="page-section">
            <h1 class="page-title"> Profil Fournisseur</h1>
    <p class="text-muted"> Détails</p>
    <!-- .section-block -->
    <div class="section-block">
        <!-- metric row -->
        <div class="metric-row">
        <!-- metric column -->
       <div class="col-md-4">
            <div class="card custom-card-detail">
            <div class="card-body">
                <div class="d-flex align-items-center">
                <div class="icon bg-primary mr-2">
                    <i class="bi bi-cart4"></i>
                </div>
                <h6><span class="text-muted text-uppercase">Nombre de commandes</span> </h6>
                </div>
                <h5><span id="value"><?= $bilan_fournisseur_nbre['nb_achat'] ?? 0 ?></span></h5>
            </div>
            </div>
        </div>
        <!-- metric column -->
        <div class="col-md-4">
            <div class="card custom-card-detail">
            <div class="card-body">
                <div class="d-flex align-items-center">
                <div class="icon bg-info mr-2">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h6><span class="text-muted text-uppercase">Quantité des commandes</span> </h6>
                </div>
                <h5><span id="value"><?= $bilan_fournisseur_nbre['qte'] ?? 0 ?></span></h5>
            </div>
            </div>
        </div>
        <!-- metric column -->
    <div class="col-md-4">
            <div class="card custom-card-detail">
            <div class="card-body">
                <div class="d-flex align-items-center">
                <div class="icon bg-success mr-2">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <h6><span class="text-muted text-uppercase">Montant total des commandes</span> </h6>
                </div>
                <h5><span id="value"><?= number_format($bilan_fournisseur['total'] ??0,0,","," ") ?> FCFA</span></h5>
            </div>
            </div>
        </div>
        
        <!-- /metric row -->
        
    </div><!-- /.section-block -->
    <!-- grid row -->
    <div class="row">
        <!-- grid column -->
        <div class="col-xl-12">
        <!-- .card -->
        <section class="card card-body card-fluid">
              <!-- .d-flex -->
          <div class="d-flex align-items-center mb-4">
            <h3 class="card-title mb-0"> Commandes fournisseur annuelle</h3><!-- .card-title-control -->
            <div class="card-title-control ml-auto">

              
                <div class="d-flex">
                <select style="width: 20em;" class="form-control select_year" name="" id="select_year_fournisseur"> 
                      </select>  
                </div>
              
            </div><!-- /.card-title-control -->
          </div><!-- /.d-flex -->
          <input type="hidden" id="canvas_fournisseur_id" value="<?= $_GET['id']?>">

            
            <div class="chartjs" style="height: 253px">
            <canvas id="canvas_fournisseur"></canvas>
            </div>
        </section><!-- /.card -->
        </div><!-- /grid column -->
        
        <!-- grid column -->
         </div><!-- /grid row -->
   
    <!-- grid row -->
    <div class="row">
        
         <!-- grid column -->
         <div class="col-lg-12 card">
            <div class="card-header">
            <h6>LISTE DES COMMANDES DU FOURNISSEUR</h6>
            </div>
            <div class="client_contenue">
                      <!-- #accordion -->
                     <?php
                    $achat_fournisseur = Soutra::getAllListeCommandeFournisseur($id);
                    $i =0;
                    if (!empty($achat_fournisseur)) {
                    foreach ($achat_fournisseur as $row) { $i++; ?>
                      

                            <div id="accordion" class="card-expansion">
                              <!-- .card -->
                              <section class="card card-expansion-item">
                                <header style="background-color: #c5c5c5;" class="card-header border-0" id="heading<?= $i ?>">
                                  <button data-istrue="false" data-codeachat="<?= $row['code_achat']?>" class="btn btn-reset collapsed open_achat_detail" data-toggle="collapse" data-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>"><span class="collapse-indicator mr-2"><i class="fa fa-fw fa-caret-right"></i></span> <span><?= $row['code_achat']?>#</span>
                                  <span>(<?= number_format($row['total'] ??0,0,","," ")?> FCFA) / </span>
                                  <span><?= Soutra::date_format($row['created_at'])?></span>
                                </button>
                                  
                                </header>
                                <div id="collapse<?= $i ?>" class="collapse" aria-labelledby="heading<?= $i ?>" data-parent="#accordion">
                                  <div class="card-body pt-0">
                                  <div class="table-responsive">
                                        <!-- .table -->
                                        <table class="table table-hover">
                                        <!-- thead -->
                                        <thead>
                                        <tr>
                                            <th> Article </th>
                                            <th> MARK </th>
                                            <th> FAMILLE </th>
                                            <th class="text-right"> PRIX ACHAT </th>
                                            <th class="text-right"> QUANTITE </th>
                                            <th class="text-right"> TOTAL </th>
                                        </tr>
                                        </thead><!-- /thead -->
                                        <!-- tbody -->
                                        <tbody id="<?= $row['code_achat'] ?>">
                                            
                                        </tbody><!-- /tbody -->
                                    </table><!-- /.table -->
                                    </div><!-- /.table-responsive -->
                                    
                                  </div>
                                </div>
                              </section><!-- /.card -->
                          
                          </div><!-- /#accordion -->

                     <?php } }
                     ?>
                      </div>
                       </div><!-- /grid column -->
                  
  
    </div><!--/grid row  -->
    </div><!-- /.page-section -->
