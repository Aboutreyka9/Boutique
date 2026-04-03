<?php 
 if(notAdmin()){
   return;
 }
  ?>
 <header class="page-title-bar">
       <h1 class="page-title"> Espace Famille</h1>
    <p class="text-muted"> Liste des Familles</p>
    <!-- floating action -->
        <button type="button" data-toggle="modal" data-target="#famille-modal" class="btn btn-success btn-floated" title="Ajouter famille" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
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
      <th> LIBELLE </th>
      <th> CATEGORIE </th>
      <th> ETAT </th>
      <th> DATE  </th>
      <th style="width: 19%; text-align: center; "> ACTION </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="famille-table">
   <?php 
    $output = '';
    $famille = Soutra::getAllFamille();
    if (!empty($famille)) {
        $i = 0;
        foreach ($famille as $row) {
            $i++;
            $etat = $row['etat_famille'] == 1 ? "Disponible" : "Non disponible";
            $output .= '
            <tr class="row'.$row['ID_famille'].'">
               <td>' . $i . '</td>
               <td>' . $row['libelle_famille'] . '</td>
               <td>' . $row['categorie'] . '</td>
               <td>' . $etat . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
               
           
            $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
            <button data-id="'. $row['ID_famille'].'" class="btn btn-primary btn-sm btn_update_famille">
            <i class="fa fa-edit"></i> modiier </button>
            <div class="d-inline">
                <button data-id="'. $row['ID_famille'].'" class="btn btn-warning btn-sm btn_remove_famille">
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
  <form action="" id="btn_ajouter_famille" method="POST" >
  
        <div class="modal fade" data-backdrop="static" id="famille-modal" tabindex="-1" role="dialog" aria-labelledby="famille-modal" aria-hidden="true">
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
                      <label for="categorie_id">Categorie</label>
                      <select name="categorie_id" id="categorie_id" class="form-control" id="">
                        <?php 
                         $categorie = Soutra::getAllTable('categorie','etat_categorie',1);
                         $output = "";
                         foreach ($categorie as $row) {
                          $output .='
                          <option value="'.$row['ID_categorie'].'">'.$row['libelle_categorie'].'</option>
                          ';
                        }
                        echo $output;
                        ?>
                        
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="libelle_famille">Libelle</label>
                       <input type="text" name="libelle_famille" id="libelle_famille" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
              </div><!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
              <input type="hidden" name="btn_ajouter_famille" class="form-control">

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
      </form><!-- /.modal -->


            