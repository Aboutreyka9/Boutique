<?php
 if (!isAdminGestionnaire()) {
     return;
 }

 if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'] ?? '';
  // TODO: Get command data from database
  $entrepot = Soutra::getSingleEntrepotByCode($id);
  $montant_versement_total = Soutra::getSumMontantVersementByCode($id);
  $versements = Soutra::getVersementsByCode($id);
} else {
  // error 404
  http_response_code(404);
  exit();
}
?>
<header class="page-title-bar">
  <h1 class="page-title"> Détail entrepot</h1>

</header><!-- /.page-title-bar -->

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
      </div>

      <div class="col-md-8 d-flex justify-content-end">
        <button class="btn btn-dark" onclick="retour()"> <i class="bi bi-arrow-left"></i> Retour </button>
        <div class="ml-2">
          <h4><?= $entrepot['libelle_entrepot'] ?></h4>
        </div>
        
      </div>
    </div>
    
  </div>
</div>



<!-- section state -->
 

<!-- STATS -->
<h5>STATISTIQUES</h5>
    <div class="row g-3 mb-1 dashboard_admin">

      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <h6><span class="text-muted text-uppercase">RÉAPPRO </span> (<span id="nombre_reapprovisionnement"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_reapprovisionnement"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-cart-plus"></i>
              </div>
              <h6><span class="text-muted text-uppercase">VENTES</span> (<span id="nombre_vente"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_vente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-success mr-2">
                <i class="bi bi-currency-exchange"></i>
              </div>
              <h6><span class="text-muted text-uppercase">TRESORERIE</span> </h6>
            </div>
            <h5><span id="montant_tresorerie"> 0 </span> </h5>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                  <i class="bi bi-alarm"></i>
              </div>
              <h6><span class="text-muted text-uppercase">ACHAT EN ATTENTE</span> </h6>
            </div>
            <h5><span id="achat_attente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                <i class="bi bi-alarm"></i>
              </div>
              <h6><span class="text-muted text-uppercase">VENTE EN ATTENTE</span> </h6>
            </div>
            <h5><span id="vente_attente"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                  <i class="bi bi-bell"></i>
              </div>
              <h6><span class="text-muted text-uppercase">STOCK DISPO</span> (<span id="nombre_stock_dispo"> 0 </span>)</h6>
            </div>
            <h5><span id="montant_stock_dispo"> 0 </span> FCFA</h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                <i class="bi bi-envelope-exclamation-fill"></i>
              </div>
              <h6><span class="text-muted text-uppercase">STOCK ALERT</span></h6>
            </div>
            <h5><span id="nombre_stock_alert"> 0 </span> </h5>
          </div>
        </div>
      </div>


    </div>

 <!-- fin section state -->
<!-- .page-section -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-hover my-table">
        <span style="font-size: 18px; font-weight: bold;" class="justify-content-center d-flex mb-3">
          Liste des articles de l'entrepot
        </span>
        <!-- thead -->
        <thead class="thead-light">
          <tr>
            <th style="width: 2%;">#</th>
            <th style="width: 20%;">Nom</th>
            <th style="width: 17%;">Famille</th>
            <th style="width: 15%;">Marque</th>
            <th style="width: 20%;">Unité</th>
            <th style="width: 10%;">Statut</th>
            <th style="width: 10%;">Créer le</th>
            <th style="width: 8%;">Actions</th>
          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="entrepot-table">
          <?php
          $output = '';
          $entrepot = Soutra::getAllArticleFamilleMark($id);
          if (!empty($entrepot)) {
            $i = 0;

            foreach ($entrepot as $row) {
              $i++;
              $btn = '<button title="Désactiver entrepot" data-code="' . $row['ID_article'] . '"  class="btn btn-danger btn-sm btnChangeStatutEntrepot">
                <i class="bi bi-x-circle"></i> </button>';
              $etat = '<span class="badge badge-success">Actif</span>';

              if ($row['etat_article'] !== 1) {
                $etat = '<span class="badge badge-danger">Inactif</span>';
                $btn = '<button title="activer entrepot" data-statut="' . $row['etat_article'] . '" data-code="' . $row['ID_article'] . '" class="btn btn-success btn-sm  btnChangeStatutEntrepot">
                <i class="bi bi-check-circle"></i> </button>';
              }

              $output .= '
            <tr class="row' . $row['ID_article'] . '" >
              <td>' . $i . '</td>
              <td>' . $row['libelle_article'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td>' . $row['mark'] . '</td>
              <td>' . $row['unite'] . '</td>
              <td>' . $etat . '</td>
              <td>' . $row['created_at'] . '</td>
              <td>' . $btn . '</td>
              ';


              $output .= '
              
            </tr>
            ';
            }
          }
          echo $output; ?>


        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive -->
  </div>
</div>



<!-- .modal -->


<div class="modal fade" data-backdrop="static" id="entrepot-modal" tabindex="-1" role="dialog" aria-labelledby="entrepot-modal" aria-hidden="true">
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
          <form action="" id="btn_ajouter_entrepot" method="POST">
            <input type="hidden" name="btn_ajouter_entrepot">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="libelle_entrepot">Nom</label>
                  <input type="text" name="libelle_entrepot" id="libelle_entrepot" class="form-control">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="responsable_entrepot">Responsable</label>
                  <select name="responsable_entrepot" id="responsable_entrepot" class="form-control">
                    <option value="">Sélectionner un responsable</option>
                    <?php
                    $entrepot = Soutra::getEmployeForResponsableEntrepot();
                    $output = "";
                    foreach ($entrepot as $row) {
                      $output .= '
                          <option value="' . $row['ID_employe'] . '">' . $row['nom_employe'] . ' ' . $row['prenom_employe'] . ' ' . $row['telephone_employe'] . '</option>
                          ';
                    }
                    echo $output;
                    ?>

                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="ville_entrepot">Ville</label>
                  <input type="text" name="ville_entrepot" id="ville_entrepot" class="form-control">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="adresse_entrepot">Adresse</label>
                  <textarea rows="3" name="adresse_entrepot" id="adresse_entrepot" class="form-control"></textarea>
                </div>
              </div>
              <div class="col-md-12 modal_footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-light dismiss_modal">Fermer</button>
              </div>
            </div><!-- /.row -->
          </form><!-- /.modal -->

        </div><!-- /.form-row -->

      </div><!-- /.modal-body -->
      <!-- .modal-footer -->
      <div class="modal-footer">
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.m -->

<?= modalAttribution() ?>
<!-- btn detail -->
<!-- <a href="' . URL . 'detail_entrepot&id=' . $row['ID_entrepot'] . '"  title="Voir details entrepot" class="btn btn-info btn-sm mr-2">
            <i class="fa fa-eye"></i></a> -->