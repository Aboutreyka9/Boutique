 <?php
 if (notAdmin()) {
     return;
 }
  ?>

 <?php
      // Dates par défaut
$start = (new DateTime('first day of this month'))->format('Y-m-d');
$end = (new DateTime('today'))->format('Y-m-d');

$start_last = (new DateTime('first day of last month'))->format('Y-m-d');
$end_last = (new DateTime('last day of last month'))->format('Y-m-d');
// $end_last = (new DateTime('today'))->format('Y-m-d');

$dateD = (new DateTime('first day of this month'))->format('d-m-Y');
$dateF = (new DateTime('today'))->format('d-m-Y');

// Récupérer les achats du mois courant
$totaux = Soutra::getTotauxDepenseByMouth($start, $end); // méthode adaptée que l'on a créée
$totaux_last = Soutra::getTotauxDepenseByMouth($start_last, $end_last); // méthode adaptée que l'on a créée
?>

 <header class="page-title-bar">
     <div class="mb-3" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
         <div class="title">
             <h1 class="page-title">Espace Dépenses</h1>
         </div>
         <div class="activity">
             <b id="activityDateRange">Activité du <?=$dateD.' au '.$dateF; ?> </b>
         </div>
         <div class="input-group" style="max-width: 40%;">
             <span class="input-group-text"><i class="fa fa-calendar"></i></span>
             <input type="text" name="datefilterDepense" class="form-control" placeholder="Sélectionner la période">
             <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

         </div>
     </div>
     <!-- Résumé des ventes -->
     <div class="row mt-5">
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-primary">
                 <div class="card-body">
                     <h6 class="text-muted">Dépense du mois passé</h6>
                     <h3 class="text-primary" id="depense_precedente">
                         <?=  number_format($totaux_last['total']  ?? 0, 0, ',', ' '); ?> FCFA</h3>
                 </div>
             </div>
         </div>
         <div class="col-md-6 col-lg-6">
             <div class="card text-center shadow-sm border-success">
                 <div class="card-body">
                     <h6 class="text-muted">Dépense du mois actuel</h6>
                     <h3 class="text-success">
                         <?= number_format($totaux['total'] ?? 0, 0, ',', ' '); ?> FCFA</h3>
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
             <th class="text-right"> Enregistré  </th>
             <th class="text-right"> Dépense </th>
             <th class="text-right"> Montant </th>
             <th class="text-right"> Description </th>
             <th class="text-right"> Date Dépense </th>
             <th> Effectué par </th>
             <th class="text-right"> ACTION </th>
         </tr>
     </thead><!-- /thead -->
     <!-- tbody -->
     <tbody class="depense-table">
         <?php
   // Dates par défaut
$start = (new DateTime('first day of this month'))->format('Y-m-d');
$end = (new DateTime('last day of this month'))->format('Y-m-d');
// Récupérer les achats du mois courant
$depense = Soutra::getDepensesByMouth($start, $end);

    $output = '';
    // $depense = Soutra::getAllListedepense();
    if (!empty($depense)) {
        $i = 0;
        foreach ($depense as $row) {
            ++$i;
            $output .= '
    <tr class="row'.$row['id_depense'].'">
       <td>'.$i.'</td>
       <td>'.Soutra::date_format($row['date_created']).'</td>
       <td class="text-right">'.$row['libelle_type'].'</td>
       <td class="text-right">'.number_format($row['montant'], 0, ',', ' ').'</td>
       <td title="'.$row['description'].'" >
       ...
       </td>
       <td>'.Soutra::date_format($row['periode']).'</td>
       <td class="text-right">'.$row['employe'].'</td>
       <td class="text-right"> 
            <div class="d-inline ">
                <button data-id="'.$row['id_depense'].'" title="Modifier depense" class="btn btn-primary btn-sm btn_update_depense">
                <i class="fa fa-edit"></i> Modifier</button>
                <button data-id="'.$row['id_depense'].'" title="Supprimer depense" class="btn btn-danger btn-sm btn_remove_depense">
                <i class="fa fa-trash"></i> Supprimer</button>
            </div>
       </td>
     </tr>
     ';
        }
    }
    echo $output; ?>


     </tbody><!-- /tbody -->
 </table><!-- /.table -->
 </div><!-- /.table-responsive -->

 <!-- .modal -->

 <div class="modal fade" data-backdrop="static" id="depense-modal" tabindex="-1" role="dialog"
     aria-labelledby="depense-modal" aria-hidden="true">
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
                 <form action="" id="btn_ajouter_depense" method="POST">

                     <!-- .form-row -->
                     <div class="form-row menu-modal">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="nom">Dépende</label>
                                 <select name="type_id" class="form-control select" id="">
                                    <option value="">--- selection ---</option>
                                    <?php
                                    $data =Soutra::getAllByFromTable("type_depense","libelle_type");
                                    foreach ($data as $value) {
                                        ?>
                                        <option value="<?= $value['id_type'] ?>"><?= $value['libelle_type'] ?></option>
                                    <?php } ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="montant">Montant</label>
                                 <input type="text" name="montant" id="montant" placeholder="Ex:10 000"
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="periode">date</label>
                                 <input type="date" name="periode" value="<?=date('Y-m-d')?>" id="periode" 
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="Description">Description</label>
                                 <textarea name="description" class="form-control" id="Description" rows="3"></textarea>
                             </div>
                         </div>

                     </div><!-- /.form-row -->
                        <!-- .modal-footer -->
             <div class="modal-footer">
                 <input type="hidden" name="btn_ajouter_depense" class="form-control">

                 <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button"
                     class="btn btn-light dismiss_modal">Close</button>
             </div><!-- /.modal-footer -->
                 </form><!-- /.modal -->

             </div><!-- /.modal-body -->
          
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.m -->