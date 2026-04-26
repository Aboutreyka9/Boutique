 <?php
  if (!isAdminGestionnaire()) {
    pageNotFound();
    return;
  }
  ?>


 <header class="page-title-bar">
   <div class="header-base header-categories">
     <i class="bi bi-folder me-3 mr-3" style="font-size:30px;"></i>
     <div>
       <h4 class="mb-0">Catégories</h4>
       <small>Organisation des produits</small>
     </div>
   </div>
   <!-- floating action -->
   <button type="button" data-toggle="modal" data-target="#categorie-modal" class="btn btn-success btn-floated" title="Ajouter categorie" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->

 <div class="card mb-3">
   <div class="card-body">
     <div class="row">
       <div class="col-md-4">
         <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
       </div>
       <div class="col-md-8 d-flex justify-content-end">
         <button type="button" data-toggle="modal" data-target="#categorie-modal" class="btn btn-primary w-25" title="Ajouter categorie" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
       </div>
     </div>
   </div>
 </div>

 <div class="card">
   <div class="card-body">

     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover my-table bg-light">
         <!-- thead -->
         <thead class="bg-light">
           <tr>
             <th> # </th>
             <th> LIBELLE </th>
             <th> ETAT </th>
             <th> DATE </th>
             <th width="10%"> ACTION </th>
           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="categorie-table">
           <?php
            $output = '';
            $cat = Soutra::getAllCategorie();
            if (!empty($cat)) {
              $i = 0;
              foreach ($cat as $row) {
                $i++;
                $etat = $row['etat_categorie'] == 1 ? "Disponible" : "Non disponible";
                $output .= '
            <tr class="row' . $row['ID_categorie'] . '">
               <td>' . $i . '</td>
               <td>' . $row['libelle_categorie'] . '</td>
               <td>' . $etat . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


                $output .= '<td style="display: flex; gap: 30px;"> 
            <button data-id="' . $row['ID_categorie'] . '" class="btn btn-primary btn-link btn-sm btn_update_categorie" data-toggle="tooltip" title="" data-original-title="modifier categorie">
            <i class="fa fa-edit text-icon-primary"></i> 
    
          </button>
                <button data-id="' . $row['ID_categorie'] . '" class="btn btn-warning btn-link btn-sm btn_remove_categorie" data-toggle="tooltip" title="" data-original-title="Supprimer categorie">
                <i class="fa fa-trash text-icon-warning"></i> </button>
          </td>
             </tr>
             ';
              }
            }
            echo $output; ?>


         </tbody><!-- /tbody -->
       </table><!-- /.table -->
     </div><!-- /.table-responsive -->
   </div>
 </div>


 <!-- .modal -->
 <form action="" id="btn_ajouter_categorie" method="POST">

   <div class="modal fade" data-backdrop="static" id="categorie-modal" tabindex="-1" role="dialog" aria-labelledby="categorie-modal" aria-hidden="true">
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
                 <label for="libelle_categorie">Libelle</label>
                 <input type="text" name="libelle_categorie" id="libelle_categorie" class="form-control">
               </div>
             </div>
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_ajouter_categorie" class="form-control">

           <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 </form><!-- /.modal -->