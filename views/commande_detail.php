<header class="page-title-bar">
  <!-- title and toolbar -->
</header><!-- /.page-title-bar -->
<!-- .page-section -->

<div class="table-responsive">
  <!-- .table -->
  <table class="table table-striped table-hover">
    <!-- thead -->
    <thead class="thead-dark">
      <tr>
        <th> # </th>
        <th> Article </th>
        <th> MARK </th>
        <th> FAMILLE </th>
        <th> PRIX VENTE </th>
        <th> QUANTITE </th>
        <th> TOTAL </th>
        <?php
        //$emp = Soutra::getEmployeVente($_GET['id']);

        //if($_SESSION["role"] == ADMIN || $emp['employe'] == $_SESSION["id_employe"]): 
        ?>
        <th style="width: 20%;text-align: center;"> ACTION </th>
        <?php // endif;
        ?>
      </tr>
    </thead><!-- /thead -->
    <!-- tbody -->
    <tbody class="achat-table">
      <?php
      $detail = Soutra::getDetailVente($_GET['id'], $_SESSION['id_entrepot']);

      $i = 0;
      $output = "";
      foreach ($detail as $row) {
        $i++;

        $output .= '
        <tr class="row' . $row['ID_sortie'] . '">
           <td class="col id d_none">' . $row['ID_sortie'] . '</td>
           <td>' . $i . '</td>
           <td>' . $row['article'] . '</td>
           <td>' . $row['mark'] . '</td>
          <td>' . $row['famille'] . '</td>
          <td class="pu">' . number_format($row['prix_vente'], 0, ",", " ") . '</td>
          <td class="qte">' . $row['qte'] . '</td>
          <td class="total">' . number_format($row['prix_vente'] * $row['qte'], 0, ",", " ") . '</td>
           ';
        $garantie = $row['garantie'];
        $dvente = Soutra::date_format($row['date_vente'], false);
        // $testt = Soutra::dateDiff($dvente, $garantie);
        //if ($_SESSION["role"] == ADMIN || $emp['employe'] == $_SESSION["id_employe"]) {
        if (Soutra::dateDiff($dvente, $garantie)) {

          $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_sortie'] . '" class="btn btn-primary btn-sm btn_update_vente">
            <i class="fa fa-edit"></i> 
    <span class="phone-btn-text">Modifier</span>
</button>
           <div class="d-inline">
               <button data-id="' . $row['ID_sortie'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_vente_detail">
               <i class="fa fa-trash"></i> <span class="phone-btn-text">Supprimer</span></button>
           </div>';
        } else {

          $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <span class="text-danger">Desolé date limite depassée! </span>
           </div>';
        }

        $output .= '   
         </td>
            </tr>
            ';
        //}
      }
      echo $output;
      ?>


    </tbody><!-- /tbody -->
  </table><!-- /.table -->
</div><!-- /.table-responsive -->



<!-- .modal -->
<form action="" id="btn_modifier_vente" method="POST">

  <div class="modal fade" data-backdrop="static" id="vente-modal" tabindex="-1" role="dialog" aria-labelledby="achat-modal" aria-hidden="true">
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
          </div><!-- /.form-row -->
        </div><!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <input type="hidden" name="btn_ajouter_vente" class="form-control">

          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <button type="button" class="btn btn-light dismiss_modal">Close</button>
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.m -->
</form><!-- /.modal -->