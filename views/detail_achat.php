 <!-- HEADER ACTIONS -->
 <div class="d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-dark" onclick="retour()" > <i class="bi bi-arrow-left"></i> Retour </button>

   <div class="d-flex gap-5">
     <button class="btn btn-success ml-2" data-toggle="tooltip" title="" data-original-title="Encaisser la facture de la commande"> <i class="bi bi-cash-coin"></i> Encaisser</button>
     <button class="btn btn-info ml-2" data-toggle="tooltip" title="" data-original-title="Voir la facture de la commande"> <i class="bi bi-eye"></i> Facture</button>
     <button class="btn btn-dark ml-2" data-toggle="tooltip" title="" data-original-title="Télécharger la facture de la commande"> <i class="bi bi-download"></i> Télécharger</button>
   </div>
 </div>

 <!-- TITLE -->
 <div class="card custom-card-detail mb-3 ">
   <div class="card-body">
     <p class="text-muted mb-1">Administration / Approvisionnement / REF-2026-0005</p>
     <h3 class="fw-bold"> <span> <i class="bi bi-info-circle"></i> Details</span>
       <span class="ms-2" id="reference-produit">N° REF-2026-0005</span>
       <?= checkStatusCommande("en attente") ?>
     </h3>
   </div>
 </div>

 <!-- STATS -->
 <div class="row g-3 mb-1">

   <div class="col-md-3">
     <div class="card custom-card-detail">
       <div class="card-body">
         <div class="d-flex align-items-center">
           <div class="icon bg-success mr-2">
             <i class="bi bi-cart4"></i>
           </div>
           <h6><span class="text-muted">Référence</span></h6>
         </div>
         <h5>REF-2026-0005</h5>
       </div>
     </div>
   </div>


   <div class="col-md-3">
     <div class="card custom-card-detail">
       <div class="card-body">
         <div class="d-flex align-items-center">
           <div class="icon bg-success mr-2">
             <i class="bi bi-cart4"></i>
           </div>
           <h6><span class="text-muted">TOTAL TTC</span></h6>
         </div>
         <h5>712 548.360 CFA</h5>
       </div>
     </div>
   </div>

   <div class="col-md-3">
     <div class="card custom-card-detail">
       <div class="card-body">
         <div class="d-flex align-items-center">
           <div class="icon bg-success mr-2">
             <i class="bi bi-cart4"></i>
           </div>
           <h6><span class="text-muted">Montant encaissé</span></h6>
         </div>
         <h5>712 548.360 CFA</h5>
       </div>
     </div>
   </div>

   <div class="col-md-3">
     <div class="card custom-card-detail">
       <div class="card-body">
         <div class="d-flex align-items-center">
           <div class="icon bg-success mr-2">
             <i class="bi bi-cart4"></i>
           </div>
           <h6><span class="text-muted">Reliquat rendu</span></h6>
         </div>
         <h5>712 548.360 CFA</h5>
       </div>
     </div>
   </div>

 </div>

 <!-- INFOS -->
 <div class="row g-3">

   <!-- CLIENT -->
   <div class="col-md-6">
     <div class="card custom-card-detail">
       <div class="card-header"> <i class="fa fa-user-circle"></i> Fournisseur</div>
       <div class="card-body">
         <div class="row">
           <div class="col-6">
             <span class="text-muted">Nom</span>
             <p class="fw-semibold">Lillian Paul</p>

             <span class="text-muted">Téléphone</span>
             <p class="fw-semibold">+1 (877) 522-1782</p>
           </div>

           <div class="col-6">
             <span class="text-muted">Email</span>
             <p class="fw-semibold">tujoroh@mailinator.com</p>

             <span class="text-muted">Mode de paiement</span>
             <p class="fw-semibold">Espèces</p>
           </div>
         </div>
       </div>
     </div>
   </div>

   <!-- INFOS -->
   <div class="col-md-6">
     <div class="card custom-card-detail">
       <div class="card-header"> <i class="fa fa-cog"></i> Préférences générales</div>
       <div class="card-body">
         <div class="row">
           <div class="col-6">
             <span class="text-muted">Date d'émission</span>
             <p class="fw-semibold">31/03/2026</p>

             <span class="text-muted">Créé le</span>
             <p class="fw-semibold">01 avr. 2026 à 23:48</p>
           </div>

           <div class="col-6">
             <span class="text-muted">Date d'échéance</span>
             <p class="fw-semibold">31/03/2026</p>

             <span class="text-muted">Fait par</span>
             <p class="fw-semibold">treyka treyka01</p>
           </div>
         </div>
       </div>
     </div>
   </div>

 </div>

 <!-- Detail des produits commandés -->
 <div class="card">
   <div class="card-header">
     <h5 class="text-success"> <i class="fa fa-list"></i> Detail des produits commandés </h5>
   </div>
   <div class="card-body">
     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover">
         <!-- thead -->
         <thead class="thead-dark">
           <tr>
             <th> # </th>
             <th> Article</th>
             <th> MARK </th>
             <th> FAMILLE </th>
             <th class="text-right"> PRIX ACHAT </th>
             <th class="text-right"> QUANTITE </th>
             <th class="text-right"> TOTAL </th>
             <th style="width: 20%;text-align: center;"> ACTION </th>

           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="achat-table">
           <?php
            $detail = Soutra::getDetailAchat($_GET['id']);

            $i = 0;
            $output = "";
            foreach ($detail as $row) {
              $i++;

              $output .= '
        <tr class="row' . $row['ID_entree'] . '">
           <td class="col id d_none">' . $row['ID_entree'] . '</td>
           <td>' . $i . '</td>
           <td>' . $row['article'] . '</td>
           <td>' . $row['mark'] . '</td>
          <td>' . $row['famille'] . '</td>
          <td class="text-right pu">' . number_format($row['prix_achat'], 0, ",", " ") . '</td>
          <td class="text-right qte">' . $row['qte'] . '</td>
          <td class="text-right total">' . number_format($row['prix_achat'] * $row['qte'], 0, ",", " ") . '</td>
           ';

              $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_entree'] . '" class="btn btn-primary btn-sm btn_update_achat">
            <i class="fa fa-edit"></i> modiier </button>
           <div class="d-inline">
               <button data-id="' . $row['ID_entree'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_achat_detail">
               <i class="fa fa-trash"></i> Supprimer</button>
           </div>';

              $output .= '   
         </td>
            </tr>
            ';
            }
            echo $output;
            ?>


         </tbody><!-- /tbody -->
       </table><!-- /.table -->
     </div><!-- /.table-responsive -->
   </div>
 </div>

 <!-- Reglement facture -->
 <div class="card">
   <div class="card-header">
     <h5 class="text-info"> <i class="fa fa-credit-card"></i> Reglement facture </h5>
   </div>
   <div class="card-body">
     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover">
         <!-- thead -->
         <thead class="thead-dark">
           <tr>
             <th> # </th>
             <th> Article</th>
             <th> MARK </th>
             <th> FAMILLE </th>
             <th class="text-right"> PRIX ACHAT </th>
             <th class="text-right"> QUANTITE </th>
             <th class="text-right"> TOTAL </th>
             <th style="width: 20%;text-align: center;"> ACTION </th>

           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="achat-table">
           <?php
            $detail = Soutra::getDetailAchat($_GET['id']);

            $i = 0;
            $output = "";
            foreach ($detail as $row) {
              $i++;

              $output .= '
        <tr class="row' . $row['ID_entree'] . '">
           <td class="col id d_none">' . $row['ID_entree'] . '</td>
           <td>' . $i . '</td>
           <td>' . $row['article'] . '</td>
           <td>' . $row['mark'] . '</td>
          <td>' . $row['famille'] . '</td>
          <td class="text-right pu">' . number_format($row['prix_achat'], 0, ",", " ") . '</td>
          <td class="text-right qte">' . $row['qte'] . '</td>
          <td class="text-right total">' . number_format($row['prix_achat'] * $row['qte'], 0, ",", " ") . '</td>
           ';

              $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_entree'] . '" class="btn btn-primary btn-sm btn_update_achat">
            <i class="fa fa-edit"></i> modiier </button>
           <div class="d-inline">
               <button data-id="' . $row['ID_entree'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_achat_detail">
               <i class="fa fa-trash"></i> Supprimer</button>
           </div>';

              $output .= '   
         </td>
            </tr>
            ';
            }
            echo $output;
            ?>


         </tbody><!-- /tbody -->
       </table><!-- /.table -->
     </div><!-- /.table-responsive -->
   </div>
 </div>



 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->






 <!-- .modal -->
 <form action="" id="btn_modifier_achat" method="POST">

   <div class="modal fade" data-backdrop="static" id="achat-modal" tabindex="-1" role="dialog" aria-labelledby="achat-modal" aria-hidden="true">
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
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_ajouter_achat" class="form-control">

           <button type="submit" class="btn btn-primary">Enregistrer</button>
           <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 </form><!-- /.modal -->