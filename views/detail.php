<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $code = $_GET['id'] ?? '';
  // TODO: Get command data from database
  $vente = Soutra::getSingleVenteByCode($code);
  $montant_versement_total = Soutra::getSumMontantVersementByVente(1, $code);
  $versements = Soutra::getAllTableByClauses('versement', 'transaction_code', $code, 'etat_versement', 1);
} else {
  // error 404
  http_response_code(404);
  exit();
}
?>

<!-- HEADER ACTIONS -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <button class="btn btn-dark" onclick="retour()"> <i class="bi bi-arrow-left"></i> Retour </button>

  <div class="d-flex gap-5">
    <button class="btn btn-success ml-2 btn_encaisser_vente" title="" data-code="<?= $code ?>"
      data-original-title="Encaisser la facture de la commande"> <i class="bi bi-cash-coin"></i> Encaisser</button>

    <a href="<?= RACINE ?>views/print.php?id=<?= $code ?>&statut=<?= $vente['statut_vente'] ?>" target="_blank" class="btn btn-dark ml-2" data-toggle="tooltip" title="" data-original-title="Télécharger la facture de la commande"> <i class="bi bi-download"></i> Télécharger</a>
  </div>
</div>

<!-- TITLE -->
<div class="card custom-card-detail mb-3">
  <div class="card-body">
    <p class="text-muted mb-1">Espace / Ventes / <?= $code ?></p>
    <h3 class="fw-bold"> <span> <i class="bi bi-info-circle"></i> Details</span>
      <span class="ms-2" id="reference-produit">N° <?= $code ?></span>
      <?= checkStatusCommande($vente['statut_vente']) ?>
    </h3>
  </div>
</div>

<!-- STATS -->
<div class="row g-3 mb-1">

  <div class="col-md-3">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cart4"></i>
          </div>
          <h6><span class="text-muted">Retour</span></h6>
        </div>
        <h6>05 Produit(s)</h6>
      </div>
    </div>
  </div>


  <div class="col-md-3">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cart4"></i>
          </div>
          <h6><span class="text-muted">Montant TTC</span></h6>
        </div>
        <h5><?= number_format($vente['total_ttc'], 0, ',', ' ') ?> CFA</h5>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cart4"></i>
          </div>
          <h6><span class="text-muted">Montant encaissé</span></h6>
        </div>
        <h5><?= number_format($montant_versement_total ?? 0, 0, ',', ' ') ?> CFA</h5>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cart4"></i>
          </div>
          <h6><span class="text-muted">Reste à payer</span></h6>
        </div>
        <h5><?= number_format(($vente['total_ttc'] - $montant_versement_total), 0, ',', ' ') ?> CFA</h5>
      </div>
    </div>
  </div>

</div>

<!-- INFOS -->
<div class="row g-3">

  <!-- CLIENT -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-user-circle"></i> Client</div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Nom</span>
            <p class="fw-semibold"><?= $vente['nom_client'] ?></p>

            <span class="text-muted">Téléphone</span>
            <p class="fw-semibold"><?= $vente['telephone_client'] ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Email</span>
            <p class="fw-semibold"><?= $vente['email_client'] ?></p>

            <span class="text-muted">Mode de paiement</span>
            <p class="fw-semibold"><?= $vente['mode_paiement'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- INFOS -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-cog"></i> Préférences générales <span class="badge badge-info"><?= $vente['entrepot'] ?></span> </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Date d'émission</span>
            <p class="fw-semibold"><?= date('d/m/Y', strtotime($vente['date_emission'])) ?></p>

            <span class="text-muted">Créé le</span>
            <p class="fw-semibold"><?= date('d/m/Y \à H:i', strtotime($vente['date_emission'])) ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Date d'échéance</span>
            <p class="fw-semibold"><?= date('d/m/Y', strtotime($vente['date_emission'])) ?></p>

            <span class="text-muted">Fait par</span>
            <p class="fw-semibold"><?= $vente['fait_par'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Detail des produits commandés -->
<div class="card">
  <div class="card-header">
    <h5 class="text-success"> <i class="fa fa-list"></i> Detail des produits commandés </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-hover">
        <!-- thead -->
        <thead class="thead-light">
          <tr>
            <th> # </th>
            <th> Article </th>
            <th> Marque </th>
            <th> S/categorie </th>
            <th> Prix vente </th>
            <th> Quatité </th>
            <th> Total </th>
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
          <td class="text-right pu">' . number_format($row['prix_vente'] ?? 0, 0, ",", " ") . '</td>
          <td class="text-right qte">' . $row['qte'] . '</td>
          <td class="text-right total">' . number_format($row['prix_vente'] ?? 0 * $row['qte'] ?? 0, 0, ",", " ") . '</td>
           ';
            $garantie = $row['garantie'];
            $dvente = Soutra::date_format($row['date_vente'], false);
            // $testt = Soutra::dateDiff($dvente, $garantie);
            //if ($_SESSION["role"] == ADMIN || $emp['employe'] == $_SESSION["id_employe"]) {
            if (Soutra::dateDiff($dvente, $garantie)) {

              $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <button data-id="' . $row['ID_sortie'] . '" class="btn btn-primary btn-sm btn_update_vente">
            <i class="fa fa-edit"></i> modiier </button>
           <div class="d-inline">
               <button data-id="' . $row['ID_sortie'] . '" title="Supprimer" class="btn btn-warning btn-sm btn_remove_vente_detail">
               <i class="fa fa-trash"></i> Supprimer</button>
           </div>';
            } else {

              $output .= '
           <td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
           <span class=" badge badgge-danger bg-danger ">Date limite depassée! </span>
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
  </div>
</div>


<!-- Reglement facture(liste des versements de l'achat) -->
<div class="card">
  <div class="card-header">
    <h5 class="text-info"> <i class="fa fa-credit-card"></i> Reglement facture </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-striped table-hover">
        <!-- thead -->
        <thead class="thead-dark">
          <tr>
            <th> # </th>
            <th>Statut</th>
            <th>Montant </th>
            <th>Mode de paiement </th>
            <th>Commentaire </th>
            <th>Fait par </th>
            <th>Fait le </th>
            <th>Actions </th>

          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="achat-table">
          <?php

          $i = 0;
          $output = "";
          if (!empty($versements)) {
            foreach ($versements as $row) {
              $i++;

              $output .= '
        <tr class="row' . $row['ID_versement'] . '">
           <td class="col id d_none">' . $row['ID_versement'] . '</td>
           <td>' . $i . '</td>
           <td>' . $row['code_versement'] . '</td>
           <td>' . $row['created_at'] . '</td>
           <td>' . number_format($row['montant_versement'], 0, ",", " ") . ' FCFA</td>
           <td>' . checkEtat($row['etat_versement']) . '</td>
           ';

              $output .= '
            </tr>
            ';
            }
          } else {
            $output .= '
            <tr>
              <td colspan="6" class="text-center">Aucun versement trouvé</td>
            </tr>
            ';
          }
          echo $output;
          ?>


        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive -->
  </div>
</div>







<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->




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


<!-- .modal -->

<?= modalEncaissement() ?>