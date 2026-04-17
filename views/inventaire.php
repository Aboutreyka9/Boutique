<?php
 if (notAdmin()) {
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
     <div class="mb-3 stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2" >
         <div class="title">
             <h1 class="page-title">Espace Dépenses</h1>
         </div>
         <div class="activity">
             <b id="activityDateRange">Activité du <?=$dateD.' au '.$dateF; ?> </b>
         </div>
         <div class="input-group w-100 w-md-auto filter-box">
             <span class="input-group-text"><i class="fa fa-calendar"></i></span>
             <input type="text" id="filterInventaire" class="form-control" placeholder="Sélectionner la période">
             <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

         </div>
     </div>
     <!-- Résumé des ventes -->
     <div class="row mt-5">
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-primary">
                 <div class="card-body">
                     <h6 class="text-muted">Achats total</h6>
                     <h3 class="text-primary" id="total_achat">
                         <?=  number_format($achat_mois['total']  ?? 0, 0, ',', ' '); ?> FCFA</h3>
                 </div>
             </div>
         </div>
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-success">
                 <div class="card-body">
                     <h6 class="text-muted">Dépense total</h6>
                     <h3 class="text-primary" id="total_depense">
                         <?= number_format($depenses_mois['total'] ?? 0, 0, ',', ' '); ?> FCFA
                     </h3>
                 </div>
             </div>
         </div>
     </div>
     
      <!-- Résumé des ventes -->
     <div class="row mt-2">
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-primary">
                 <div class="card-body">
                     <h6 class="text-muted">Ventes total</h6>
                     <h3 class="text-primary" id="total_vente">
                         <?=  number_format($vente_mois['total_montant']  ?? 0, 0, ',', ' '); ?> FCFA</h3>
                 </div>
             </div>
         </div>
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-success">
                 <div class="card-body">
                     <h6 class="text-muted">Montant en Caisse </h6>
                     <h3 class="<?= $type ?>" id="total_caisse">
                         <?= number_format($benefice ?? 0, 0, ',', ' '); ?> FCFA
                     </h3>
                 </div>
             </div>
         </div>
     </div>

     <!-- floating action -->
     <button type="button" data-toggle="modal" data-target="#depense-modal" class="btn btn-success btn-floated" title="Ajouter depense" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->


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
      <th class="text-right"> Depenses (FCFA)</th>
      <th class="text-right"> Ventes (FCFA)</th>
      <th class="text-right">Qte Reste </th>
      <th class="text-right"> Mtt Reste (FCFA)</th>
      <th class="text-right"> Gain (FCFA) </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="inventaire-table">


  <?php
  $i = 0;
  $comptabilite = Soutra::getComptabiliteBilant();
      foreach ($comptabilite as $key => $value) {
    $i++;
    ?>
          <tr>
              <td><?= $i ?></td>
              <td class="text-right"><?= $value['article'] ?></td>
              <td class="text-right"><?= number_format($value['depenses'],0,","," ") ?></td>
              <td class="text-right"><?= number_format($value['ventes'],0,","," ") ?></td>
              <td class="text-right"><?= $value['qte_reste']?> </td>
              <td class="text-right"><?=  number_format($value['mt_reste'],0,","," ")  ?> </td>
              <td class="text-right"><?= number_format($value['gain'],0,","," ") ?> </td>

          </tr>
    <?php
}
?>
  </tbody><!-- /tbody -->
</table><!-- /.table -->
</div><!-- /.table-responsive -->
 
 