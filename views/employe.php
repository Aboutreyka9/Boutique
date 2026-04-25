 <?php
  if (!isAdminGestionnaire()) {
    pageNotFound();
    return;
  }
  ?>


 <header class="page-title-bar">
   <h1 class="page-title"> Espace Employés</h1>

   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->

 <div class="card mb-3">
   <div class="card-body">
     <div class="row">
       <div class="col-md-4">
         <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
       </div>
       <div class="col-md-8 d-flex justify-content-end">
         <button type="button" data-toggle="modal" data-target="#employe-modal" class="btn btn-primary w-25" title="Ajouter employé" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
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
         <thead class="thead-dark">
           <tr>
             <th> # </th>
             <th> STATUT </th>
             <th> NOM </th>
             <th> PRENOMS </th>
             <th> TELEPHONE </th>
             <th> ROLE </th>
             <th> ACTION </th>
           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="emp-table">
           <?php
            $output = '';
            $emp = Soutra::getAllEmployer($_SESSION['id_entrepot']);
            if (!empty($emp)) {
              $i = 0;
              foreach ($emp as $row) {
                $i++;
                $output .= '
                  <tr class="row' . $row['ID_employe'] . '">
                    <td class="action-cell">' . $i . '</td>
                    <td>' . checkEtatData($row['etat_employe']) . '</td>
                    <td class="action-cell">' . $row['nom_employe'] . '</td>
                    <td class="action-cell">' . $row['prenom_employe'] . '</td>
                    <td class="action-cell">' . $row['telephone_employe'] . '</td>
                    <td class="action-cell">' . $row['role'] . '</td>';


                $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
                  <a  href="' . URL . 'profile_employe&id=' . $row['ID_employe'] . '" class="btn btn-success btn-link btn-sm " data-toggle="tooltip" title="" data-original-title="Voir details client">
                  <i class="fa fa-eye text-icon-success"></i> </a>

                   <button data-id="' . $row['ID_employe'] . '" class="btn btn-primary btn-link btn-sm btn_update_employe" data-toggle="tooltip" title="" data-original-title="Modifier info client client">
                  <i class="fa fa-edit text-icon-primary"></i> </button>
                
                      <button data-id="' . $row['ID_employe'] . '" class="btn btn-warning btn-link btn-sm btn_remove_employe" data-toggle="tooltip" title="" data-original-title="Changer statut client">
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
 <form action="" id="btn_ajouter_employe" method="POST">

   <div class="modal fade" data-backdrop="static" id="employe-modal" tabindex="-1" role="dialog" aria-labelledby="employe-modal" aria-hidden="true">
     <!-- .modal-dialog -->
     <div class="modal-dialog modal-lg" role="document">
       <!-- .modal-content -->
       <div class="modal-content ">
         <!-- .modal-header -->
         <div class="modal-header">
           <h6 class="modal-title inline-editable">Formulaire <i class=""></i>
           </h6>
         </div><!-- /.modal-header -->
         <!-- .modal-body -->
         <div class="modal-body">
           <!-- .form-row -->
           <div class="form-row menu-modal">
             <div class="col-md-6">
               <div class="form-group">
                 <label for="nom_employe">Nom</label>
                 <input type="text" name="nom_employe" id="nom_employe" class="form-control">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label for="prenom_employe">Prenoms</label>
                 <input type="text" name="prenom_employe" id="prenom_employe" class="form-control">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label for="telephone_employe">Telephone</label>
                 <input type="text" name="telephone_employe" id="telephone_employe" class="form-control">
                 <input type="hidden" name="code_inscrire" id="code_module" class="form-control">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label for="email_employe">Email</label>
                 <input type="email" name="email_employe" id="email_employe" class="form-control">
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label for="role_employe">Role</label>
                 <select name="role_employe" id="role_employe" class="form-control select2" id="">
                   <?php
                    $roles = Soutra::getAllTable('role', 'etat_role', 1);
                    $output = "";
                    foreach ($roles as $row) {
                      $output .= '
                          <option value="' . $row['ID_role'] . '">' . $row['libelle_role'] . '</option>
                          ';
                    }
                    echo $output;
                    ?>

                 </select>
               </div>
             </div>


             <div class="col-md-4">
               <div class="form-group">
                 <label for="entrepot_id">entrepot</label>
                 <select name="id_entrepot" id="id_entrepot" class="form-control entrepot_search select2">
                   <option value="default"> --- Choisir un entrepot ---</option>';
                   <?php
                    $entrepot = Soutra::getAllTable('entrepot', 'etat_entrepot', STATUT[1]);
                    var_dump($entrepot);
                    foreach ($entrepot as $row) {
                      echo ' <option value="' . $row['ID_entrepot'] . '">' . $row['libelle_entrepot'] . '</option>';
                    }
                    echo '</select>';
                    ?>
               </div>
             </div>

             <div class="col-md-4">
               <div class="form-group">
                 <label for="responsable">Responsable</label>
                 <select name="responsable" id="responsable" class="form-control">
                   <option value="0">Non</option>
                   <option value="1">Oui</option>
                 </select>
               </div>
             </div>
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_ajouter_employe" class="form-control">

           <button type="submit" class="btn btn-primary w-25"> <i class="fa fa-save"></i> &nbsp; &nbsp; Enregistrer</button>
           <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 </form><!-- /.modal -->