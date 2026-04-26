<?php 
 if (!isAdminGestionnaire()) {
     return;
 }
  ?>
<header class="page-title-bar">
  <div class="header-base header-unites">
  <i class="bi bi-rulers me-3 mr-3" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Unités</h4>
    <small>Gestion des unités de mesure</small>
  </div>
</div>

<!-- floating action -->
<button type="button" data-toggle="modal" data-target="#unite-modal" class="btn btn-success btn-floated" title="Ajouter unite" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
<!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->
<div class="table-responsive bg-light py-3 px-2 border rounded">
<!-- .table -->
<table class="table table-striped table-hover my-table">
<!-- thead -->
<thead class="bg-light">
<tr>
<th> # </th>
<th> LIBELLE LONG </th>
<th> LIBELLE COURT </th>
<th> DESCRIPTION </th>
<th style="width: 19%; text-align: center; "> ACTION </th>
</tr>
</thead><!-- /thead -->
<!-- tbody -->
<tbody class="unite-table">
<?php 
$output = '';
$unite = Soutra::getAllunite();
if (!empty($unite)) {
$i = 0;
foreach ($unite as $row) {
  $i++;
  $output .= '
  <tr class="row'.$row['ID_unite'].'">
     <td>' . $i . '</td>
     <td>' . $row['libelle_unite'] . '</td>
     <td>' . $row['slug_unite'] . '</td>
     <td>' . $row['description_unite'] . '</td>
     ';
     
 
  $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
  <button data-id="'. $row['ID_unite'].'" class="btn btn-primary btn-sm btn_update_unite">
  <i class="fa fa-edit"></i> 
    
</button> ';
  if (strtolower($_SESSION['role']) == ADMIN ) {
  $output.= '<div class="d-inline">
      <button data-id="'. $row['ID_unite'].'" class="btn btn-warning btn-sm btn_remove_unite">
      <i class="fa fa-trash"></i> </button>
  </div>';
}
$output.='
</td>
   </tr>
   ';
}
}
echo $output; ?>


</tbody><!-- /tbody -->
</table><!-- /.table -->
</div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->



<!-- .modal -->
<form action="" id="btn_ajouter_unite" method="POST" >

<div class="modal fade" data-backdrop="static" id="unite-modal" tabindex="-1" role="dialog" aria-labelledby="unite-modal" aria-hidden="true">
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
            <label for="libelle_unite">Libelle long</label>
             <input type="text" name="libelle_unite" id="libelle_unite" class="form-control">
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label for="slug_unite">Libelle court</label>
             <input type="text" name="slug_unite" id="slug_unite" class="form-control">
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label for="description_unite">Description</label>
            <textarea name="description_unite"  id="description_unite" rows="5" class="form-control"></textarea>
          </div>
        </div>
        
      </div><!-- /.form-row -->
    </div><!-- /.modal-body -->
    <!-- .modal-footer -->
    <div class="modal-footer">
    <input type="hidden" name="btn_ajouter_unite" class="form-control">

      <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
    </div><!-- /.modal-footer -->
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.m -->
</form><!-- /.modal -->


  