<?php 
 if(notAdmin()){
   return;
 }
  ?>
<header class="page-title-bar">

          <!-- floating action -->
    <button type="button" data-toggle="modal" data-target="#fournisseur-modal" class="btn btn-success btn-floated" title="Ajouter fournisseur" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
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
      <th> CODE FOURNISSEUR </th>
      <th> NOM & PRENOM</th>
      <th> TELEPHONE </th>
      <th> DATE ENREGISTRER </th>
      <th style="width: 19%; text-align: center; "> ACTION </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="fournisseur-table">
   <?php 
    $output = '';
    $fournisseur = Soutra::getAllFournisseur(0);
    if (!empty($fournisseur)) {
        $i = 0;
        foreach ($fournisseur as $row) {
            $i++;
            $output .= '
            <tr class="row'.$row['ID_fournisseur'].'">
               <td>' . $i . '</td>
               <td>' . $row['code_fournisseur'] . '</td>
               <td>' . $row['nom_fournisseur'] . '</td>
               <td>' . $row['telephone_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';
               
           
            $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">';
            $output.= '<div class="d-inline">
                <button data-id="'. $row['ID_fournisseur'].'" class="btn btn-warning btn-sm btn_remove_fournisseur">
                <i class="fa fa-trash"></i> </button>
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
