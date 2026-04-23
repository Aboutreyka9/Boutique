<?php
 if(!isAdminGestionnaire()){
   return;
 }
if (Soutra::getState('fournisseur') != 1) {
  include('views/not_found.php');
  return;
}

?>
<header class="page-title-bar">
  <h1 class="page-title"> Espace Fournisseurs</h1>
  <p class="text-muted"> Liste des fournisseurs</p>

  <!-- floating action -->
  <button type="button" data-toggle="modal" data-target="#fournisseur-modal" class="btn btn-success btn-floated" title="Ajouter fournisseur" aria-label="Close"><span style="line-height: 45px" class="fa fa-plus"></span></button> <!-- /floating action -->
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
        <th> REF-FR </th>
        <th> NOM</th>
        <th> TELEPHONE </th>
        <th> EMAIL </th>
        <th> DATE ENREGISTRER </th>
        <th style="width: 19%; text-align: center; "> ACTION </th>
      </tr>
    </thead><!-- /thead -->
    <!-- tbody -->
    <tbody class="fournisseur-table">
      <?php
      $output = '';
      $fournisseur = Soutra::getAllFournisseur();
      if (!empty($fournisseur)) {
        $i = 0;
        foreach ($fournisseur as $row) {
          $i++;
          $output .= '
            <tr class="row' . $row['ID_fournisseur'] . '">
               <td>' . $i . '</td>
               <td>
               <a href="' . URL . 'fournisseur_profile&id=' . $row['ID_fournisseur'] . '" title="Detail client"> <i class="fa fa-eye"></i>  '
            . $row['code_fournisseur'] .
            '</a> </td>
               <td>' . $row['nom_fournisseur'] . '</td>
               <td>' . $row['telephone_fournisseur'] . '</td>
               <td>' . $row['email_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
               ';


          $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
            <button data-id="' . $row['ID_fournisseur'] . '" class="btn btn-primary btn-sm btn_update_fournisseur">
            <i class="fa fa-edit"></i> 
    
</button> ';
          if (isAdminGestionnaire()) {
            $output .= '<div class="d-inline">
                <button data-id="' . $row['ID_fournisseur'] . '" class="btn btn-warning btn-sm btn_remove_fournisseur">
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


<?= modalAchatFournisseur() ?>