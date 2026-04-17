 <?php
  if (notAdmin()) {
    return;
  }
  ?>

 <?php
  // Dates par défaut
  $start = (new DateTime('first day of this month'))->format('Y-m-d');
  $end =  (new DateTime('today'))->format('Y-m-d');

  $dateD = (new DateTime('first day of this month'))->format('d-m-Y');
  $dateF =  (new DateTime('today'))->format('d-m-Y');

  // Récupérer les achats du mois courant
  $totaux = Soutra::getTotauxAchatByDateRange($start, $end); // méthode adaptée que l'on a créée
  $totalAttente = Soutra::getTotauxAchatEnAttente(); // méthode adaptée que l'on a créée
  ?>

 <header class="page-title-bar">
   <div class="mb-3 stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
     <div class="title">
       <h1 class="page-title">Espace Achats</h1>
     </div>
     <div class="activity">
       <b id="activityDateRange">Activité du <?= $dateD . ' au ' . $dateF ?> </b>
     </div>
     <div class="input-group w-100 w-md-auto filter-box" >
       <span class="input-group-text"><i class="fa fa-calendar"></i></span>
       <input type="text" name="datefilterAchat" class="form-control" placeholder="Sélectionner la période">
       <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

     </div>
   </div>
   <!-- Résumé des ventes -->

   <!-- STATS -->
   <div class="row g-3 mb-1">

     <div class="col-md-4">
       <div class="card custom-card-detail">
         <div class="card-body">
           <div class="d-flex align-items-center">
             <div class="icon bg-warning mr-2">
               <i class="bi bi-alarm"></i>
             </div>
             <h6><span class="text-muted text-uppercase">Achat en attente</span> (<?= $totalAttente['article'] ?? 0 ?>)</h6>
           </div>
           <h5><span id=""><?= number_format($totalAttente['total'] ?? 0, 0, ',', ' ') ?>
             </span> FCFA</h5>
         </div>
       </div>
     </div>

     <div class="col-md-4">
       <div class="card custom-card-detail">
         <div class="card-body">
           <div class="d-flex align-items-center">
             <div class="icon bg-success mr-2">
               <i class="bi bi-check2-circle"></i>
             </div>
             <h6><span class="text-muted text-uppercase">Quantité Achat</span> </h6>
           </div>
           <h5><span id="nb_achats"><?= $totaux['article'] ?? 0 ?>
             </span></h5>
         </div>
       </div>
     </div>

     <div class="col-md-4">
       <div class="card custom-card-detail">
         <div class="card-body">
           <div class="d-flex align-items-center">
             <div class="icon bg-success mr-2">
               <i class="bi bi-cash-stack"></i>
             </div>
             <h6><span class="text-muted text-uppercase">Montant Achat</span> </h6>
           </div>
           <h5><span class="tester" id="total_montant"><?= number_format($totaux['total'] ?? 0, 0, ',', ' ') ?>
             </span> FCFA</h5>
         </div>
       </div>
     </div>

   </div>

   <!-- floating action -->
   <a href="<?= URL ?>ajouter_achat" class="btn btn-success btn-floated" title="Ajouter vente">
     <span style="line-height: 45px" class="fa fa-plus"></span>
   </a>

   <!-- title and toolbar -->
   <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">

   </div>
 </header>

 <!-- .page-section -->
 <div class="table-responsive bg-light py-3 px-2 border rounded">
   <!-- .table -->
   <table class="table table-hover my-table">
     <!-- thead -->
     <thead class="bg-light">
       <tr>
         <th style="width: 2%;">#</th>
         <th style="width: 8%;">Ref</th>
         <th style="width: 10%;">Statut</th>
         <th style="width: 10%;">Fournisseur</th>
         <th style="width: 5%;">Produit</th>
         <th style="width: 10%;">Total</th>
         <!-- <th style="width: 6%;">Paiement</th> -->
         <th style="width: 12%;">Fait par</th>
         <th style="width: 8%;">Date</th>
         <th style="width: 20%;">Actions</th>
       </tr>
     </thead><!-- /thead -->
     <!-- tbody -->
     <tbody class="achat-table">
       <?php
        // Récupérer les achats du mois courant
        $achat = Soutra::getAllListeBonCommandeFournisseur($start, $end);

        $output = '';
        if (!empty($achat)) {
          $i = 0;
          foreach ($achat as $row) {
            $i++;
            $output .= '
            <tr class="row' . $row['ID_achat'] . '">
               <td>' . $i . '</td>
               <td>' . $row['code_achat'] . '</td>
               <td>' . checkStatusCommande($row['statut_achat']) . '</td>
               <td>' . $row['fournisseur'] . '</td>
               <td>' . $row['article'] . '</td>
               <td>' . number_format($row['total'], 0, ",", " ") . '</td>
               <td>' . $row['employe'] . ' </td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
              
               <td class="form-button-action"> 
          <a href="' . URL . 'detail_achat&id=' . $row['code_achat'] . '" data-toggle="tooltip" title="" data-original-title="Voir les détails de la commande" class="btn btn-link btn-primary btn-sm">
            <i class="fa fa-eye text-icon-primary"></i> </a> ';

            // btn validation la commande
            if ($row['statut_achat'] == STATUT_COMMANDE[0]):
              $output .= '
        <button type="button" data-toggle="tooltip" 
        id="btn_validation_achat"
            onclick="updateELement(this,\'' . $row['code_achat'] . '\')"
            title="Valider la commande" 
            class="btn btn-link btn-success btn-sm">
            <i class="fa fa-save text-icon-success"></i>
        </button> ';
            endif;

            // encaisser
            if ($row['statut_achat'] == STATUT_COMMANDE[1]):
              $output .= '

        <button type="button" 
        id="btn_encaisser_achat"
            data-toggle="modal" data-target="#encaisser-modal"
            data-code="' . $row['code_achat'] . '"
            data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm" data-original-title="Encaisser la facture de la commande"> <i class="fbi bi-cash text-icon-success"></i>
        </button> ';
            endif;
            // btn Modifier la commande
            if ($row['statut_achat'] == STATUT_COMMANDE[0]):
              $output .= '<a href="' . URL . 'modifier_achat&id=' . $row['code_achat'] . '"  data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm" data-original-title="Modifier la commande"> <i class="fa fa-edit text-icon-primary"></i> </a>';
            endif;

            // btn Annuler la commande
            if ($row['statut_achat'] == STATUT_COMMANDE[0]):
              $output .= '<button type="button"
            id="btn_annuler_achat"
            onclick="updateELement(this,\'' . $row['code_achat'] . '\')" 
            data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Annuler la commande"> <i class="fa fa-times text-icon-danger"></i> </button>';
            endif;

            // btn Retourner la commande
            if ($row['statut_achat'] == STATUT_COMMANDE[1] || $row['statut_achat'] == STATUT_COMMANDE[2]):
              $output .= '<button type="button" 
            id="btn_retourner_achat"
            onclick="updateELement(this,\'' . $row['code_achat'] . '\')" 
            data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Retourner la commande"> <i class="fa fa-undo text-icon-danger"></i> </button>';
            endif;

            // btn Imprimer la facture
            $output .= '<a href="' . RACINE . 'views/print_achat.php?id=' . $row['code_achat'] . '&statut=' . $row['statut_achat'] . '" target="_blank" data-toggle="tooltip" title="" class="btn btn-link btn-dark btn-sm" data-original-title="Imprimer la facture de la commande"> <i class="fa fa-print text-icon-dark"></i> </a>';

            $output .= '
            </td>
            </tr>';
          }
        }
        echo $output; ?>


     </tbody><!-- /tbody -->
   </table><!-- /.table -->
 </div><!-- /.table-responsive -->






 <!-- Modal fournisseur -->
 <div class="modal fade" id="fournisseurModal" tabindex="-1" aria-labelledby="fournisseurModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="fournisseurModalLabel">Infos Fournisseur</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
       </div>
       <div class="modal-body" id="fournisseurContent">
         <p class="text-center">Chargement...</p>
       </div>
     </div>
   </div>
 </div>
 <!-- End Modal fournisseur -->

 <!-- .modal -->

 <div class="modal fade" data-backdrop="static" id="encaisser-modal" tabindex="-1" role="dialog" aria-labelledby="encaisser-modal" aria-hidden="true">
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
       <form action="" id="form_encaisser_achat" method="POST">
         <div class="modal-body">
           <!-- .form-row -->
           <div class="form-row menu-modal">
             <input type="hidden" name="code_achat" id="code_achat">
             <div class="col-md-12">
               <div class="form-group">
                 <label for="montant_versement">Montant versement</label>
                 <input type="text" name="montant_versement" id="montant_versement" class="form-control">
               </div>
             </div>
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_encaisser_achat" class="form-control">

           <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </form><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->