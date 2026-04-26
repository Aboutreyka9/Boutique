 <?php
  if (!isAdminGestionnaire()) {
    pageNotFound();
    return;
  }
  ?>


 <header class="page-title-bar">
   <div class="header-client d-flex align-items-center mb-4">
     <i class="bi bi-person-lines-fill me-3 mr-3" style="font-size:30px;"></i>
     <div>
       <h4 class="mb-0">Clients</h4>
       <small>Suivi et gestion de la clientèle</small>
     </div>
   </div>

   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->

 <div class="card mb-3">
   <div class="card-body">
     <div class="row">
       <div class="col-md-4">
         <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
       </div>
       <div class="col-md-8 d-flex justify-content-end">
         <button type="button" data-toggle="modal" data-target="#client-modal" class="btn btn-primary w-25" title="Ajouter client" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
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
             <th> STATUT </th>
             <th> NOM </th>
             <th> TELEPHONE </th>
             <th> EMAIL </th>
             <th> ENREGISTRER </th>
             <th> ACTION </th>
           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="client-table">
           <?php
            $output = '';
            $client = Soutra::getAllClientEntrepot();
            if (!empty($client)) {
              $i = 0;
              foreach ($client as $row) {
                $i++;

                $output .= '
            <tr class="row' . $row['ID_client'] . '">
               <td>' . $i . '</td>
               <td>' . checkEtatData($row['etat_client']) . '</td>
               <td>' . $row['nom_client'] . '</td>
               <td>' . $row['telephone_client'] . '</td>
               <td>' . $row['email_client'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


                $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                <a  href="' . URL . 'client_profile&id=' . $row['ID_client'] . '" class="btn btn-success btn-link btn-sm " data-toggle="tooltip" title="" data-original-title="Voir details client">
                  <i class="fa fa-eye text-icon-success"></i> </a>
                  
            <button data-id="' . $row['ID_client'] . '" class="btn btn-primary btn-sm btn_update_client">
            <i class="fa fa-edit"></i> </button> ';

                if (isAdminGestionnaire()) {
                  $output .= '<div class="d-inline">
                <button data-id="' . $row['ID_client'] . '" class="btn btn-warning btn-sm btn_remove_client">
                <i class="fa fa-trash"></i> </button>
            </div>';
                }
                $output .= '
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


 <?= modalVenteClient(); ?>