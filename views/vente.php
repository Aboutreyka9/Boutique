<?php
// Dates par défaut
$start = (new DateTime('today'))->format('Y-m-d');
$end   = (new DateTime('today'))->format('Y-m-d');
// Récupérer les achats du mois courant
$totaux = Soutra::getTotauxVenteByDateRange($start, $end); // méthode adaptée que l'on a créée

  
?>
<header class="page-title-bar">

  <div class="header-vente d-flex align-items-center mb-4">
  <i class="bi bi-cart-check me-3 mr-3" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Espace Vente</h4>
    <small>Gestion des ventes et encaissements</small>
  </div>
</div>

<div class="mb-3 stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

  <div class="activity">
    <b id="activityDateRange">Activité du <?= date("d-m-Y") ?> </b>
  </div>
  <div class="input-group w-100 w-md-auto filter-box">

    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
    <input type="text" name="datefilterVente" class="form-control" placeholder="Sélectionner la période">
    <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

  </div>
</div>
<!-- Résumé des ventes -->
<div class="row mt-5 dashboard_admin">


<div class="col-md-6">
      <div class="card custom-card-detail">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon bg-warning mr-2">
              <i class="bi bi-alarm"></i>
            </div>
            <h6><span class="text-muted text-uppercase">Vente en attente</span> (0)</h6>
          </div>
          <h5><span id="vente_attente">0</span></h5>
        </div>
      </div>
    </div>


      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-cart-plus"></i>
              </div>
              <h6><span class="text-muted text-uppercase">VENTES</span> (<span id="nombre_vente"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_vente"> 0 </span></h5>
          </div>
        </div>
      </div>

    <!-- <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-cash-stack"></i>
              </div>
              <h6><span class="text-muted text-uppercase">Facture reglée</span> </h6>
            </div>
            <h5><span class="tester" id="total_montant_regler"><?= number_format($totaux['total_montant']-$reste['montant_total'] ?? 0, 0, ',', ' ') ?>
              </span> FCFA</h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="bi bi-cash-stack"></i>
              </div>
              <h6><span class="text-muted text-uppercase">Reste à payer</span> </h6>
            </div>
            <h5><span class="tester" id="total_montant_reste"><?= number_format($reste['montant_total'] ?? 0, 0, ',', ' ') ?>
              </span> FCFA</h5>
          </div>
        </div>
      </div> -->


</div>

<!-- floating action -->
<a href="<?= URL ?>ajouter_vente" class="btn btn-success btn-floated" title="Ajouter vente">
  <span style="line-height: 45px" class="fa fa-plus"></span>
</a>

<!-- title and toolbar -->
<div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">

  <!-- <div class="form-group">
    <a href="<?= URL ?>view_vente_by_article" id="clearFilterBtn" class="btn btn-info"><i class="fa fa-eye"></i> Voir par article</a>
  </div> -->
</div>
</header>

<!-- <div class="card">
<div class="card-body"> -->
<!-- .page-section -->
<div class="table-responsive bg-light py-3 px-2 border rounded">
<!-- .table -->
<table class="table table-hover my-table">
  <!-- thead -->
  <thead class="bg-light">
    <tr>
      <th style="width: 2%;">#</th>
      <th style="width: 8%;">Ref</th>
      <th style="width: 10%;">Statut</th>
      <th style="width: 10%;">Client</th>
      <th style="width: 5%;">Produit</th>
      <th style="width: 10%;">Total</th>
      <th style="width: 6%;">Paiement</th>
      <th style="width: 12%;">Fait par</th>
      <th style="width: 8%;">Date</th>
      <th style="width: 20%;">Actions</th>
    </tr>
  </thead><!-- /thead -->
  <!-- tbody -->
  <tbody class="vente-table">
    <?php
    // Récupérer les achats du mois courant
    $vente = Soutra::getAllListeBonCommandeClient($start, $end, $_SESSION['id_entrepot']);

    $output = '';
    // $vente = Soutra::getAllListeVenteByDateRange();
    if (!empty($vente)) {
      $i = 0;
      foreach ($vente as $row) {
        $montant_versement_total = Soutra::getSumMontantVersementByCode($row['code_vente']);
        $reste_a_payer = $row['total'] - $montant_versement_total;
        $i++;
        $payment = '<span class="payment-method">' . $row['pay_mode'] . '</span>';
        $output .= '
          <tr class="row' . $row['ID_vente'] . '">
              <td>' . $i . '</td>
              <td>' . $row['code_vente'] . '</td>
              <td>' . checkStatusCommande($row['statut_vente']) . '</td>
              <td>' . $row['client'] . '</td>
              <td>' . $row['article'] . '</td>
              <td>' . number_format($row['total'], 0, ",", " ") . '</td>
              <td>' . $payment . '</td>
              <td>' . $row['employe'] . ' </td>
              <td>' . Soutra::date_format($row['created_at']) . '</td>
              ';
        $output .= '<td class="form-button-action"> 
        <a href="' . URL . 'detail&id=' . $row['code_vente'] . '" data-toggle="tooltip" title="" data-original-title="Voir les détails de la commande" class="btn btn-link btn-primary btn-sm">
          <i class="fa fa-eye text-icon-primary"></i> </a>
          ';

        // btn Valider la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '
            <button type="button" 
            id="btn_validation_vente"
            onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
            data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm" data-original-title="Valider la commande"> <i class="fa fa-save text-icon-success"></i> </button>
            ';
        endif;

        // btn Encaisser la facture
        if ($row['statut_vente'] == STATUT_COMMANDE[1]):
          $output .= '<button type="button"
            data-code="'. $row['code_vente'] .'"
          data-reste_a_payer="'. $reste_a_payer .'" 
          data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm btn_encaisser_vente" data-original-title="Encaisser la facture de la commande"> <i class="fbi bi-cash text-icon-success"></i> </button>';
        endif;

        // btn Modifier la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '<a href="' . URL . 'modifier_vente&id=' . $row['code_vente'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm" data-original-title="Modifier la commande"> <i class="fa fa-edit text-icon-primary"></i> </a>';
        endif;

        // btn Annuler la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[0]):
          $output .= '<button type="button" 
          id="btn_annuler_vente"
          onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
          data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Annuler la commande"> <i class="fa fa-times text-icon-danger"></i> </button>';
        endif;

        // btn Retourner la commande
        if ($row['statut_vente'] == STATUT_COMMANDE[1] || $row['statut_vente'] == STATUT_COMMANDE[2]):
          $output .= '<button type="button"
          id="btn_retourner_vente"
          onclick="updateELement(this,\'' . $row['code_vente'] . '\')"
          data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm" data-original-title="Retourner la commande"> <i class="fa fa-undo text-icon-danger"></i> </button>';
        endif;

        // btn Imprimer la facture
        $output .= '<a href="' . RACINE . 'views/print.php?id=' . $row['code_vente'] . '&statut=' . $row['statut_vente'] . '" target="_blank" data-toggle="tooltip" title="" class="btn btn-link btn-dark btn-sm" data-original-title="Imprimer la facture de la commande"> <i class="fa fa-print text-icon-dark"></i> </a>
          </td>
          </tr>';
      }
    }
    echo $output; ?>


  </tbody><!-- /tbody -->
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<!-- </div>
</div> -->



<!-- .modal -->
<form action="" id="btn_ajouter_achat" method="POST">

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
                $famille = Soutra::getAllTable('famille', 'etat_famille', 1);
                $output = "";
                foreach ($famille as $row) {
                  $output .= '
                        <option value="' . $row['ID_famille'] . '">' . $row['libelle_famille'] . '</option>
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
                $mark = Soutra::getAllTable('mark', 'etat_mark', 1);
                $output = "";
                foreach ($mark as $row) {
                  $output .= '
                      <option value="' . $row['ID_mark'] . '">' . $row['libelle_mark'] . '</option>
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


<!-- .modal -->


<?= modalEncaissement() ?>