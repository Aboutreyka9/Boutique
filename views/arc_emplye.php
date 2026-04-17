<?php 
 if(notAdmin()){
   return;
 }
  ?>
 <header class="page-title-bar">

        <!-- floating action -->
  <button type="button" data-toggle="modal" data-target="#employe-modal" class="btn btn-success btn-floated" title="Ajouter Employe" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
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
      <th> CODE-EMP </th>
      <th> NOM </th>
      <th> PRENOMS </th>
      <th> TELEPHONE </th>
      <th> ROLE </th>
      <th style="width: 19%; text-align: center; "> ACTION </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="emp-table">
   <?php 
    $output = '';
    $emp = Soutra::getAllEmployer($_SESSION['id_employe'],0);
    if (!empty($emp)) {
        $i = 0;
        foreach ($emp as $row) {
            $i++;
            $output .= '
            <tr class="row'.$row['ID_employe'].'">
               <td>' . $i . '</td>
               <td>' . $row['code_employe'] . '</td>
               <td>' . $row['nom_employe'] . '</td>
               <td>' . $row['prenom_employe'] . '</td>
               <td>' . $row['telephone_employe'] . '</td>
               <td>' . $row['role']. '</td>';
               
           
            $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
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

