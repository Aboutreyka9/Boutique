<?php

if(notAccessPage(!isset($_GET['id']))){
  return;
}

if (Soutra::getState('client') != 1) {
 include('views/not_found.php');
 return ;
}
 

$id = $_GET['id'];
$client = Soutra::getInfoClient($id);
$bilan_client = Soutra::getBilanClient($id);
$bilan_client_nbre = Soutra::getBilanClientNbre($id);
$commande_client = Soutra::getBilanClient($id,2);

$liste_versement = Soutra::getListeVersement($id);
// var_dump($liste_versement);
?>
    <!-- .page-section -->
    <div class="page-section">
<div class="header-client d-flex align-items-center mb-4">
  <i class="bi bi-person-circle me-3 mr-3" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Détail Client</h4>
    <small>Historique des achats et interactions</small>
  </div>
</div>
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
                <sub><i class="oi oi-people"></i></sub> <span class="value"><?= @$bilan_client_nbre['nb_vente'] ??0 ?></span>
                </p>
                <h2 class="metric-label"> Nombre d'achat </h2>
            </div>
            </div><!-- /.metric -->
        </div><!-- /metric column -->
        <!-- metric column -->
        <div class="col-12 col-sm-6 col-lg-3">
            <!-- .metric -->
            <div class="card-metric">
            <div class="metric">
                <p class="metric-value h3">
                <sub><i class="oi oi-fork"></i></sub> <span class="value"><?= @$bilan_client['qte'] ??0 ?></span>
                </p>
                <h2 class="metric-label"> Quantité d'achat </h2>
            </div>
            </div><!-- /.metric -->
        </div><!-- /metric column -->
        <!-- metric column -->
        <div class="col-12 col-sm-6 col-lg-3">
            <!-- .metric -->
            <div class="card-metric">
            <div class="metric">
                <p class="metric-value h3">
                <sub><i class="fa fa-tasks"></i></sub> <span class="value"><?= number_format(@$bilan_client['total'] ??0,0,","," ") ?></span>
                </p>
                <h2 class="metric-label"> Montant Total d'achat </h2>
            </div>
            </div><!-- /.metric -->
        </div><!-- /metric column -->
        <!-- metric column -->
        <div class="col-12 col-sm-6 col-lg-3">
            <!-- .metric -->
            <div class="card-metric">
            <div class="metric">
                <p class="metric-value h3">
                <sub><i class="oi oi-timer"></i></sub> <span class="value"><?= number_format(@$commande_client['total'] ??0,0,","," ") ?></span>
                </p>
                <h2 class="metric-label"> Montant Total commandes </h2>
            </div>
            </div><!-- /.metric -->
        </div><!-- /metric column -->
        </div><!-- /metric row -->
        
    </div><!-- /.section-block -->
    <!-- grid row -->
    <div class="row">
        <!-- grid column -->
        <div class="col-xl-8">
        <!-- .card -->
        <section class="card card-body card-fluid">
              <!-- .d-flex -->
          <div class="d-flex align-items-center mb-4">
            <h3 class="card-title mb-0"> Ventes Annuelle</h3><!-- .card-title-control -->
            <div class="card-title-control ml-auto">

              
                <div class="d-flex">
                <select style="width: 10em;" class="form-control select_year" name="" id="select_year_client"> 
                      </select>  
                </div>
              
            </div><!-- /.card-title-control -->
          </div><!-- /.d-flex -->
            
            <div class="chartjs" style="height: 253px">
            <canvas id="canvas_client"></canvas>
            </div>
        </section><!-- /.card -->
        </div><!-- /grid column -->
        
        <!-- grid column -->
        <div class="col-xl-4">
        <!-- .card -->
        <section class="card card-fluid">
            <!-- .card-header -->
            <header class="card-header"> Info client :<span><?= @$client['code_client']?></span> </header><!-- /.card-header -->
            <input type="hidden" id="canvas_client_id" value="<?= @$client['ID_client']?>">
            <!-- .card-body -->
            <div class="card-body">
            <dl class="d-flex justify-content-between">
                <dt class="text-left">
                <span class="mr-2">Nom</span> 
                </dt>
                <dd class="text-right text-primary mb-0">
                <strong><?= @$client['nom_client']?></strong> 
                </dd>
            </dl>
            <dl class="d-flex justify-content-between mb-0">
                <dt class="text-left">
                <span class="mr-2">Prenom</span> 
                </dt>
                <dd class="text-right text-primary mb-0">
                <strong><?= @$client['prenom_client']?></strong>
                </dd>
            </dl>
            </div><!-- /.card-body -->
            <!-- .card-body -->
            <div class="card-body border-top">
            <dl class="d-flex justify-content-between">
                <dt class="text-left">
                <span class="mr-2">Telephone</span>
                </dt>
                <dd class="text-right text-primary mb-0">
                <strong><?= @$client['telephone_client']?></strong>
                </dd>
            </dl>
           
            </div><!-- /.card-body -->
            <!-- .card-body -->
            <div class="card-body border-top">
            <div class="summary">
                <p class="text-left">
                <strong class="mr-2">compte courant</strong>
                </p>
                <p class="text-center">
                <strong class="h3"><?= number_format(@$client['solde_client'],0,","," ")?></strong> <span class="text-muted"> FCFA</span>
                </p>
            </div>
            </div><!-- /.card-body -->
        </section><!-- /.card -->
        </div><!-- /grid column -->
    </div><!-- /grid row -->
    <br> <br>
    <!-- grid row -->
    <div class="row">
        <!-- grid column -->
        <div class="col-xl-7">
        <!-- .card -->
        <section class="card card-fluid">
            <!-- .card-header -->
            <header class="card-header border-0">
            <!-- .d-flex -->
            <div class="d-flex align-items-center">
                <span class="mr-auto">LISTE DES VERSEMENTS</span> 
                <!-- <span class="ml-auto">LISTE DES VERSEMENTS</span>  -->
                <button type="button" title="Effectuez le versement" data-toggle="modal" data-target="#versement-modal" class="btn btn-primary ml-auto"><span>VERSEMENT</span> <i class="fa fa-fw fa-plus"></i></button>
                <!-- .card-header-control -->
            </div><!-- /.d-flex -->
            </header><!-- /.card-header -->
            <!-- .table-responsive bg-light py-3 px-2 border rounded -->
            <div class="table-responsive bg-light py-3 px-2 border rounded">
            <!-- .table -->
            <table class="table table-striped table-hover my-table">
                <!-- thead -->
                <thead>
                <tr>
                    <th># STATU</th>
                    <th> CODE VRS </th>
                    <th class="text-right"> MONTANT </th>
                    <th class="text-center"> CODE EMP </th>
                    <th class="text-right"> DATE </th>
                </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody class="versement-table">
                    <?php
                    if (!empty($liste_versement)) 
                        $i = 0;
                        foreach ($liste_versement as $row) {
                            $i++; ?>
                        
                         <!-- tr -->
                <tr>
                    <td>
                        <?= $i ?> <span class="badge bg-teal">success</span>
                    </td>
                    <td><?= $row['code_versement']?></td>
                    <td class="text-right"><?= number_format($row['montant_versement'],0,","," ")?></td>
                    <td><?= $row['code_employe']?> </td>
                    <td><?= Soutra::date_format($row['created_at'])?></td>
                </tr>
                <!-- /tr -->

                    <?php }
                    
                    ?>
               
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
            </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
        </section><!-- /.card -->
        </div><!-- /grid column -->
        <!-- grid column -->
        <div class="col-xl-5">
        <!-- .card -->
            <section class="card card-fluid">
                <!-- .card-header -->
                <header class="card-header border-0">
                <!-- .d-flex -->
                <div class="d-flex align-items-center">
                    <span class="mr-auto">LISTE DE BON DE COMMANDES</span> 
                    <a href="<?= URL?>commande&id=<?= @$client['ID_client']?>"  title="Effectuez la commande" class="btn btn-primary ml-auto"><span>COMMANDER</span> <i class="fa fa-fw fa-plus"></i></a>
                    <!-- .card-header-control -->
                    
                </div><!-- /.d-flex -->
                </header><!-- /.card-header -->
                <!-- .table-responsive bg-light py-3 px-2 border rounded -->
                <div class="table-responsive bg-light py-3 px-2 border rounded">
                <!-- .table -->
                <table class="table table-hover">
                <!-- thead -->
                <thead>
                <tr>
                    <th> CODE CMD </th>
                    <th class="text-right"> MONTANT </th>
                    <th> DATE </th>
                    <th> ACTION </th>
                </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>
                <?php 
    $output = '';
    $vente = Soutra::getAllListeCommande($_GET['id']);
    if (!empty($vente)) {
        foreach ($vente as $row) {
            $output .= '
            <tr class="row'.$row['code_vente'].'">
               <td> <a href="'.URL.'commande_detail&id='. $row['code_vente'].'" title="Detail commande" class="badge badge-warning ">
               <i class="fa fa-eye"></i> '
                . $row['code_vente'] . 
                '</a> </td>
               <td class="text-right">' . number_format($row['total'],0,","," ") . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
               
           
            $output .= '<td> 
            ';

            $output.= '<div class="d-inline">
                <button data-code_vente="'. $row['code_vente'].'"
                data-montant_vente="'. $row['total'].'"
                data-client="'. $_GET['id'].'"
                 title="Valider commande" class="btn btn-success btn-sm btn_valider_commande">
                <i class="fa fa-check"></i> VALIDER
                </button>
            </div>
            ';
          
    $output.='
          </td>
             </tr>
             ';
        }
    }
    echo $output; ?>
               
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
            </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
            </section><!-- /.card -->
        </div><!-- /grid column -->
     
    </div><!-- /grid row -->
    <br> <br>
    <!-- grid row -->
    <div class="row">
        
         <!-- grid column -->
         <div class="col-lg-12 card">
            <div class="card-header">
            <h6>LISTE DES ACHATS DU CLIENT</h6>
            </div>
            <div class="client_contenue">
                      <!-- #accordion -->
                     <?php
                    $vente_client = Soutra::getAllListeVenteClient($id);
                    $i =0;
                    if (!empty($vente_client)) {
                    foreach ($vente_client as $row) { $i++; ?>
                      

                            <div id="accordion" class="card-expansion">
                              <!-- .card -->
                              <section class="card card-expansion-item">
                                <header style="background-color: #c5c5c5;" class="card-header border-0" id="heading<?= $i ?>">
                                  <button data-istrue="false" data-codevente="<?= $row['code_vente']?>" class="btn btn-reset collapsed open_vente_detail" data-toggle="collapse" data-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>"><span class="collapse-indicator mr-2"><i class="fa fa-fw fa-caret-right"></i></span> <span><?= $row['code_vente']?>#</span>
                                  <span>(<?= number_format($row['total'],0,","," ")?> FCFA) / </span>
                                  <span><?= Soutra::date_format($row['created_at'])?></span>
                                </button>
                                  
                                </header>
                                <div id="collapse<?= $i ?>" class="collapse" aria-labelledby="heading<?= $i ?>" data-parent="#accordion">
                                  <div class="card-body pt-0">
                                  <div class="table-responsive bg-light py-3 px-2 border rounded">
                                        <!-- .table -->
                                        <table class="table table-hover">
                                        <!-- thead -->
                                        <thead>
                                        <tr>
                                            <th> Article </th>
                                            <th> MARK </th>
                                            <th> FAMILLE </th>
                                            <th class="text-right"> PRIX VENTE </th>
                                            <th class="text-right"> QUANTITE </th>
                                            <th class="text-right"> TOTAL </th>
                                        </tr>
                                        </thead><!-- /thead -->
                                        <!-- tbody -->
                                        <tbody id="<?= $row['code_vente'] ??0 ?>">
                                            
                                        </tbody><!-- /tbody -->
                                    </table><!-- /.table -->
                                    </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
                                    
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


    
  <!-- .modal -->
  <form action="" id="frm_ajouter_versement" method="POST" >
  
  <div class="modal fade" data-backdrop="static" id="versement-modal" tabindex="-1" role="dialog" aria-labelledby="versement-modal" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h6 class="modal-title inline-editable">Formulaire <i class=""></i>
          </h6>
        </div><!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
          <!-- .form-row -->
          <div class="form-row menu-modal">
          
            <div class="col-md-12">
              <div class="form-group">
                <label for="montant_versement">Montant</label>
                 <input type="text" name="montant_versement" id="montant_versement" class="form-control">
              </div>
            </div>
            <input type="text" hidden  name="client" id="client" value="<?= $id?>" class="form-control">

            
          </div><!-- /.form-row -->
        </div><!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
        <input type="hidden" name="btn_ajouter_versement" class="form-control">

          <button type="submit" class="btn btn-primary">Enregistrer</button> 
          <button type="button" class="btn btn-light dismiss_modal">Close</button>
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.m -->
</form><!-- /.modal -->

           