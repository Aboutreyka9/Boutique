 <?php 
 if(notAdmin()){
   return;
 }
  ?>
 <header class="page-title-bar">
    <!-- floating action -->
        <a href="<?= URL ?>ajouter_achat"  class="btn btn-success btn-floated" title="Ajouter achat"><span style="line-height: 45px" class="fa fa-plus"></span></a> 
        <!-- /floating action -->
    <!-- title and toolbar -->
  </header><!-- /.page-title-bar -->
  <!-- .page-section -->
<div class="table-responsive">
<!-- .table -->
<table class="table table-striped table-hover my-table">
  <!-- thead -->
  <thead class="bg-light">
    <tr>
      <th> # </th>
      <th style="width: 22%;"> CODE </th>
      <th style="width: 20%;"> NOMBRE ARTICLE </th>
      <th> MONTANT </th>
      <th> DATE </th>
      <th style="width: 20%;"> ACTION </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="achat-table">
   <?php 
    $output = '';
    $achat = Soutra::getAllListeAchat();
    if (!empty($achat)) {
        $i = 0;
        foreach ($achat as $row) {
            $i++;
            $output .= '
            <tr class="row'.$row['ID_achat'].'">
               <td>' . $i . '</td>
               <td>' . $row['code_achat'] . '</td>
               <td>' . $row['article'] . '</td>
               <td>' . number_format($row['total'],0,","," ") . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
               
           
            $output .= '<td> 
            <a href="'.URL.'approvision&id='. $row['code_achat'].'" title="Detail achat" class="btn btn-primary btn-sm">
            <i class="fa fa-eye"></i> Detail </a>
            <div class="d-inline">
                <button data-id="'. $row['ID_achat'].'" title="Supprimer achat" class="btn btn-warning btn-sm btn_remove_achat">
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
  <form action="" id="btn_ajouter_achat" method="POST" >
  
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
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="famille_id">Famille</label>
                      <select name="famille_id" id="famille_id" class="form-control" id="">
                        <?php 
                         $famille = Soutra::getAllTable('famille','etat_famille',1);
                         $output = "";
                         foreach ($famille as $row) {
                          $output .='
                          <option value="'.$row['ID_famille'].'">'.$row['libelle_famille'].'</option>
                          ';
          
                        }
                        echo $output;
                        ?>
                        
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="mark_id">Mark</label>
                    <select name="mark_id" id="mark_id" class="form-control" id="">
                      <?php 
                      $mark = Soutra::getAllTable('mark','etat_mark',1);
                      $output = "";
                      foreach ($mark as $row) {
                        $output .='
                        <option value="'.$row['ID_mark'].'">'.$row['libelle_mark'].'</option>
                        ';
                      }
                      echo $output;
                      ?>
                      
                    </select>
                  </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="libelle_achat">Libelle</label>
                       <input type="text" name="libelle_achat" id="libelle_achat" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="slug">Slug</label>
                       <input type="text" name="slug" id="slug" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="prix_achat">Prix</label>
                       <input type="number" name="prix_achat" min="0" id="prix_achat" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="stock_alert">Stock Alert</label>
                       <input type="number" name="stock_alert" min="0" id="stock_alert" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
              </div><!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
              <input type="hidden" name="btn_ajouter_achat" class="form-control">

                <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
      </form><!-- /.modal -->


            