<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $code = $_GET['id'] ?? '';
  // TODO: Get command data from database
  $depense = Soutra::getSingleDepenseById($code);
} else {
  // error 404
  http_response_code(404);
  exit();
}
?>
<div class="header-depense d-flex align-items-center mb-4">
  <i class="bi bi-credit-card me-3 mr-3" style="font-size:30px;"></i>
  <div>
    <h4 class="mb-0">Détail Dépense</h4>
    <small>Analyse des charges et sorties d’argent</small>
  </div>
</div>
<!-- HEADER ACTIONS -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <button class="btn btn-dark" onclick="retour()"> <i class="bi bi-arrow-left"></i> Retour </button>

  <div class="d-flex gap-5">
    
    <a href="<?= RACINE ?>views/print.php?id=<?= $code ?>&statut=<?= $depense['statut_depense'] ?>" target="_blank" class="btn btn-dark ml-2" data-toggle="tooltip" title="" data-original-title="Télécharger la facture de la commande"> <i class="bi bi-download"></i> Télécharger</a>
  </div>
</div>

<!-- TITLE -->
<div class="card custom-card-detail mb-3">
  <div class="card-body">

    <p class="text-muted mb-1">Espace / Dépenses / #</p>

    <div class="d-flex justify-content-between align-items-center flex-wrap">

      <!-- LEFT -->
      <div>
        <h3 class="fw-bold mb-1">
          <i class="bi bi-info-circle"></i> Détails
        </h3>

        <div>
          <span id="reference-produit">N° #</span>
          <?= checkStatusDepense($depense['statut_depense']) ?>
        </div>
      </div>

      <!-- RIGHT (MONTANT) -->
      <div class="text-end">
        <h4 class="fw-bold text-success mb-0">
          <?= number_format($depense['montant'] ?? 0, 0, ',', ' ') ?> CFA
        </h4>
      </div>

    </div>

  </div>
</div>

<!-- STATS -->
<div class="row g-3 mb-1">

  

</div>

<!-- INFOS -->
<div class="row g-3">

  <!-- CLIENT -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-user-circle"></i> Fait par</div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Noms</span>
            <p class="fw-semibold"><?= $depense['employe']??'Non spécifié' ?></p>

            <span class="text-muted">Téléphone</span>
            <p class="fw-semibold"><?= $depense['telephone_employe']??'Non spécifié' ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Email</span>
            <p class="fw-semibold"><?= $depense['email_employe']??'Non spécifié' ?></p>

            <span class="text-muted">Identifiant</span>
            <p class="fw-semibold"><?= $depense['code_employe']??'Non spécifié' ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- INFOS -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-cog"></i> Préférences générales <span class="badge badge-info"><?= $depense['libelle_type']??'Non spécifié' ?></span> </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Date d'émission</span>
            <p class="fw-semibold"><?= date('d/m/Y', strtotime($depense['periode']))??'Non spécifié' ?></p>

            <span class="text-muted">Créé le</span>
            <p class="fw-semibold"><?= date('d/m/Y \à H:i', strtotime($depense['date_created']))??'Non spécifié' ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Date Modification</span>
            <p class="fw-semibold"><?= $depense['date_confirm']?', ':'Non spécifié' ?></p>

            <span class="text-muted">Description</span>
            <p class="fw-semibold"><?= $depense['description']??'Non spécifié' ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
