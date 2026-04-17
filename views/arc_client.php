 <header class="page-title-bar">

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
      <th> # </th>
      <th> CODE-CL </th>
      <th> NOM </th>
      <th> PRENOMS </th>
      <th> TELEPHONE </th>
      <th> DATE-ENR </th>
      <th style="width: 19%; text-align: center; "> ACTION </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="client-table">
   <?php 
    $output = '';
    $client = Soutra::getAllClient(0);
    if (!empty($client)) {
        $i = 0;
        foreach ($client as $row) {
            $i++;
            $output .= '
            <tr class="row'.$row['ID_client'].'">
               <td>' . $i . '</td>
               <td>' . $row['code_client'] . '</td>
               <td>' . $row['nom_client'] . '</td>
               <td>' . $row['prenom_client'] . '</td>
               <td>' . $row['telephone_client'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
               
           
            $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
            ';
            $output.= '<div class="d-inline">
                <button data-id="'. $row['ID_client'].'" class="btn btn-warning btn-sm btn_remove_client">
                <i class="fa fa-trash"></i> <span class="phone-btn-text">Supprimer</span></button>
            </div>';
          
        $output.='
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
  <form action="" id="btn_ajouter_client" method="POST" >
  
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
                      <label for="prenom_client">Prenoms</label>
                       <input type="text" name="prenom_client" id="prenom_client" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="telephone_client">Telephone</label>
                      <input type="text" name="telephone_client" id="telephone_client" class="form-control">
                      <input type="hidden" name="code_inscrire" id="code_module" class="form-control">
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


            