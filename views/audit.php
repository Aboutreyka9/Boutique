<?php
 if (notAdmin()) {
     return;
 }
  ?>


 <div class="table-responsive">
<!-- .table -->
<table class="table table-striped table-hover my-table">
  <!-- thead -->
  <thead class="thead-dark">
    <tr>
      <th> # </th>
      <th class="text-right"> Article </th>
      <th class="text-right"> Depenses (FCFA)</th>
      <th class="text-right"> Ventes (FCFA)</th>
      <th class="text-right">Qte Reste </th>
      <th class="text-right"> Mtt Reste (FCFA)</th>
      <th class="text-right"> Gain (FCFA) </th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="inventaire-table">


  <?php
  $i = 0;
  $comptabilite = Soutra::getComptabiliteBilant();
      foreach ($comptabilite as $key => $value) {
    $i++;
    ?>
          <tr>
              <td><?= $i ?></td>
              <td class="text-right"><?= $value['article'] ?></td>
              <td class="text-right"><?= number_format($value['depenses'],0,","," ") ?></td>
              <td class="text-right"><?= number_format($value['ventes'],0,","," ") ?></td>
              <td class="text-right"><?= $value['qte_reste']?> </td>
              <td class="text-right"><?=  number_format($value['mt_reste'],0,","," ")  ?> </td>
              <td class="text-right"><?= number_format( $value['gain'],0,","," ") ?> </td>

          </tr>
    <?php
}
?>
  </tbody><!-- /tbody -->
</table><!-- /.table -->
</div><!-- /.table-responsive -->
 
 