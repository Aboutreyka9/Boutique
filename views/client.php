 <?php
  if (Soutra::getState('client') != 1) {
    include('views/not_found.php');
    return;
  }
  ?>

 <header class="page-title-bar">
   <h1 class="page-title"> Espace Clients</h1>
   <p class="text-muted"> Liste des clients</p>
   <!-- floating action -->
   <button type="button" data-toggle="modal" data-target="#client-modal" class="btn btn-success btn-floated" title="Ajouter Client" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->
 <!-- .page-section -->
 <div class="table-responsive">
   <!-- .table -->
   <table class="table table-striped table-hover my-table">
     <!-- thead -->
     <thead class="thead-dark">
       <tr>
         <th style="width: 2%;">#</th>
         <th style="width: 10%;">STATUT</th>
         <th style="width: 10%;">REF-CL</th>
         <th style="width: 25%;">NOM</th>
         <th style="width: 10%;">TELEPHONE</th>
         <th style="width: 20%;">EMAIL</th>
         <th style="width: 10%;">DATE-ENR</th>
         <th style="width: 8%;">ACTIONS</th>
       </tr>
     </thead><!-- /thead -->
     <!-- tbody -->
     <tbody class="client-table">
       <?php
        $output = '';
        $client = Soutra::getAllClient();
        if (!empty($client)) {
          $i = 0;
          foreach ($client as $row) {
            $i++;

            $output .= '
            <tr class="row' . $row['ID_client'] . '">
               <td>' . $i . '</td>
               <td>' . checkEtatData($row['etat_client']) . '</td>
               <td>' . $row['code_client'] . '</td>
               <td>' . $row['nom_client'] . '</td>
               <td>' . $row['telephone_client'] . '</td>
               <td>' . $row['email_client'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


            $output .= '<td class="form-button-action"> 
            <a href="' . URL . 'client_profile&id=' . $row['ID_client'] . '" data-toggle="tooltip" title="" data-original-title="Voir detatils client" class="btn link btn-success btn-sm">
            <i class="fa fa-eye"></i> </a> 

            <button data-toggle="tooltip" title="" data-original-title="Modifier info client" data-id="' . $row['ID_client'] . '" class="btn link btn-primary btn-sm btn_update_client">
            <i class="fa fa-edit"></i> </button> 
          </td>
             </tr>
             ';
          }
        }
        echo $output; ?>


     </tbody><!-- /tbody -->
   </table><!-- /.table -->
 </div><!-- /.table-responsive -->



 <?= modalVenteClient(); ?>

 <div class="modal fade" data-backdrop="static" id="client-modal" tabindex="-1" role="dialog" aria-labelledby="client-modal" aria-hidden="true">
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
               <label for="nom_client">Nom</label>
               <input type="text" name="nom_client" id="nom_client" class="form-control">
             </div>
           </div>
           <div class="col-md-12">
             <div class="form-group">
               <label for="telephone_client">Telephone</label>
               <input type="text" name="telephone_client" id="telephone_client" class="form-control">
               <input type="hidden" name="code_inscrire" id="code_module" class="form-control">
             </div>
           </div>
           <div class="col-md-12">
             <div class="form-group">
               <label for="email_client">Email</label>
               <input type="email" name="email_client" id="email_client" class="form-control">
             </div>
           </div>
           <div class="col-md-12">
             <div class="form-group">
               <label for="adresse_client">Adresse</label>
               <textarea rows="3" name="adresse_client" class="form-control"></textarea>
             </div>
           </div>

         </div><!-- /.form-row -->
       </div><!-- /.modal-body -->
       <!-- .modal-footer -->
       <div class="modal-footer">
         <input type="hidden" name="btn_ajouter_client" class="form-control">

         <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
       </div><!-- /.modal-footer -->
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.m -->
 </form><!-- /.modal -->