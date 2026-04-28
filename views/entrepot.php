<?php
if (!isAdminGestionnaire()) {
  pageNotFound();
  return;
}
?>
<header class="page-title-bar">
  <div class="header-entrepot d-flex align-items-center mb-4">
    <i class="bi bi-shop me-3 mr-3" style="font-size:30px;"></i>
    <div>
      <h4 class="mb-0">Entrepôts</h4>
      <small>Organisation et gestion des stocks</small>
    </div>
  </div>

</header><!-- /.page-title-bar -->

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
      </div>
      <div class="col-md-8 d-flex justify-content-end">

        <a href="<?= URL ?>transfert" class="btn btn-success w-25" title="Transfert produits" aria-label="Close"> <i class="bi bi-arrow-right-circle"></i> &nbsp; Transfert Produits</a>
        &nbsp;
        <button type="button" data-toggle="modal" data-target="#entrepot-modal" class="btn btn-primary w-25" title="Créer entrepot" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
      </div>
    </div>
  </div>
</div>
<!-- .page-section -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive bg-light py-3 px-2 border rounded">
      <!-- .table -->
      <table class="table table-hover my-table">
        <!-- thead -->
        <thead class="thead-light">
          <tr>
            <th style="width: 2%;">#</th>
            <th style="width: 20%;">Libelle</th>
            <th style="width: 17%;">Ville</th>
            <th style="width: 15%;">Adresse</th>
            <th style="width: 20%;">Responsable</th>
            <th style="width: 10%;">Statut</th>
            <th style="width: 10%;">Créer le</th>
            <th style="width: 8%;">Actions</th>
          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="entrepot-table">
          <?php
          $output = '';
          $entrepot = Soutra::getAllEntrepot();
          if (!empty($entrepot)) {
            $i = 0;

            foreach ($entrepot as $row) {
              $i++;
              $btn = '<button title="Désactiver entrepot" data-statut="' . $row['etat_entrepot'] . '" data-code="' . $row['ID_entrepot'] . '"  class="btn btn-danger btn-sm btnChangeStatutEntrepot">
                <i class="bi bi-x-circle"></i> </button>';
              $etat = '<span class="badge badge-success">Actif</span>';

              if ($row['etat_entrepot'] !== 1) {
                $etat = '<span class="badge badge-danger">Inactif</span>';
                $btn = '<button title="activer entrepot" data-statut="' . $row['etat_entrepot'] . '" data-code="' . $row['ID_entrepot'] . '" class="btn btn-success btn-sm  btnChangeStatutEntrepot">
                <i class="bi bi-check-circle"></i> </button>';
              }

              $output .= '
            <tr class="row' . $row['ID_entrepot'] . '" ' . ($row['ID_entrepot'] == $_SESSION['id_entrepot'] ? 'style="background-color: #d4edda;"' : '') . '>
               <td>' . $i . '</td>
               <td>' . $row['libelle_entrepot'] . '</td>
               <td>' . $row['ville_entrepot'] . '</td>
               <td>' . $row['adresse_entrepot'] . '</td>
               <td>' . $row['responsable'] . '</td>
               <td>' . checkEtatData($row['etat_entrepot']) . '</td>
               <td>' . Soutra::date_format($row['created_at_entrepot']) . '</td>
               ';


              $output .= '
              
              <td style="display: flex; flex-direction: row; align-items: center;"> 
              
              <a href="' . URL . 'detail_entrepot&id=' . $row['ID_entrepot'] . '"  title="Voir details entrepot" class="btn btn-info btn-sm mr-2">
            <i class="fa fa-eye"></i></a>

            <button data-id="' . $row['ID_entrepot'] . '" title="Atribuer article" class="btn btn-success btn-sm btn_attribuer_article mr-2" data-action="entrepot">
            <i class="fa fa-link"></i></button>

            <button data-id="' . $row['ID_entrepot'] . '" title="Atribuer employé" class="btn btn-success btn-sm btn_attribuer_employe mr-2" data-action="attribuer_employe_a_entrepot">
            <i class="fa fa-users"></i></button>

            <button title="Modifier entrepot" data-id="' . $row['ID_entrepot'] . '" class="btn btn-primary mr-2 btn-sm btn_update_entrepot">
            <i class="fa fa-edit"></i>  </button>
                ' . $btn . '
          </td>
            </tr>
            ';
            }
          }
          echo $output; ?>


        </tbody><!-- /tbody -->
      </table><!-- /.table -->
    </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
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