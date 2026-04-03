<?php 
 if(notAdmin()){
   return;
 }
  ?>
  <!-- .page-section -->

<div class="table-responsive">
      <h1 class="page-title">  Espace historique</h1>
    <p class="text-muted"> Historique Achats </p>
<!-- .table -->
<table class="table table-striped table-hover my-table">
  <!-- thead -->
  <thead class="thead-dark">
    <tr>
      <th> # </th>
      <th class="text-right"> Article </th>
      <th class="text-right"> Prix.U (FCFA)</th>
      <th class="text-right"> Quantité </th>
      <th class="text-right"> Total (FCFA)</th>
      <th class="text-right">Date Achat</th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="hist-table">


  <?php
$i = 0;

  $article = Soutra::getHistoriqueEntree();
foreach ($article as $key => $value) {
    $i++;
    ?>
        <tr>
            <td><?= $i ?></td>
            <td class="text-right"><?= $value['article'] ?></td>
            <td class="text-right"><?= number_format($value['prix_achat'],0,","," ") ?></td>
            <td class="text-right"><?= $value['qte'] ?></td>
            <td class="text-right"><?= number_format($value['qte']*$value['prix_achat'],0,","," ") ?></td>
            <td class="text-right"><?= Soutra::date_format($value['d_achat'])?> </td>

        </tr>
    <?php
}
?>
  </tbody><!-- /tbody -->
</table><!-- /.table -->
</div><!-- /.table-responsive -->
