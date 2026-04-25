<?php 
 if(!isAdminGestionnaire()){
   return;
 }

  ?>
 <header class="page-title-bar">
<div class="header-employe d-flex align-items-center mb-4">
  <i class="bi bi-people me-3 mr-3" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Employés</h4>
    <small>Gestion du personnel</small>
  </div>
</div>
        <!-- floating action -->
  <button type="button" data-toggle="modal" data-target="#employe-modal" class="btn btn-success btn-floated" title="Ajouter Employe" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
  <!-- title and toolbar -->
    </header><!-- /.page-title-bar -->
    <!-- .page-section -->
    <div class="table-responsive bg-light py-3 px-2 border rounded">
<!-- .table -->
<table class="table table-striped table-hover my-table bg-light">
  <!-- thead -->
  <thead class="bg-light">
    <tr>
      <th> # </th>
      <th> CODE-EMP </th>
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
    $emp = Soutra::getAllEmployer($_SESSION['id_employe']);
    if (!empty($emp)) {
        $i = 0;
        foreach ($emp as $row) {
            $i++;
            $output .= '
            <tr class="row'.$row['ID_employe'].'">
               <td class="action-cell">' . $i . '</td>
               <td class="action-cell">
               <a href="'.URL.'profile_employe&id='. $row['ID_employe'].'" title="Detail Employé"> <i class="fa fa-eye fa-lg"></i>  ' 
               . $row['code_employe'] . 
               '</a> </td>
               <td class="action-cell">' . $row['nom_employe'] . '</td>
               <td class="action-cell">' . $row['prenom_employe'] . '</td>
               <td class="action-cell">' . $row['telephone_employe'] . '</td>
               <td class="action-cell">' . $row['role']. '</td>';
               
           
            $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
            <button data-id="'. $row['ID_employe'].'" class="btn btn-primary btn-sm btn_update_employe">
            <i class="fa fa-edit"></i> 
    
</button>
            <div class="d-inline">
                <button data-id="'. $row['ID_employe'].'" class="btn btn-warning btn-sm btn_remove_employe">
                <i class="fa fa-trash"></i> </button>
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
  <form action="" id="btn_ajouter_employe" method="POST" >
  
        <div class="modal fade" data-backdrop="static" id="employe-modal" tabindex="-1" role="dialog" aria-labelledby="employe-modal" aria-hidden="true">
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
                      <label for="nom_employe">Nom</label>
                       <input type="text" name="nom_employe" id="nom_employe" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="prenom_employe">Prenoms</label>
                       <input type="text" name="prenom_employe" id="prenom_employe" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="telephone_employe">Telephone</label>
                      <input type="text" name="telephone_employe" id="telephone_employe" class="form-control">
                      <input type="hidden" name="code_inscrire" id="code_module" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="email_employe">Email</label>
                      <input type="email" name="email_employe" id="email_employe" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="role_employe">Role</label>
                      <select name="role_employe" id="role_employe" class="form-control select2" id="">
                        <?php 
                         $roles = Soutra::getAllTable('role','etat_role',1);
                         $output = "";
                         foreach ($roles as $row) {
                          $output .='
                          <option value="'.$row['ID_role'].'">'.$row['libelle_role'].'</option>
                          ';
          
                        }
                        echo $output;
                        ?>
                        
                      </select>
                    </div>
                  </div>

             
                  <div class="col-md-12">
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

                        <div class="col-md-12">
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

                <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
      </form><!-- /.modal -->


            