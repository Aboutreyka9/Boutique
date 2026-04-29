<?php
if (!isAdminGestionnaire()) {
  return;
}
?>
<header class="page-title-bar">
<div class="header-section header-audit">
  <i class="bi bi-clipboard-data"></i>
  <div>
    <h4>Audit</h4>
    <small>Suivi et contrôle des opérations</small>
  </div>
</div>
</header><!-- /.page-title-bar -->

<div class="card">
  <div class="card-body">
    <div class="row d-flex justify-content-space-between">

    <div class="col-md-9 d-flex">
        <button class="btn btn-dark" onclick="retour()"> <i class="bi bi-arrow-left"></i> Retour </button>
        <div class="ml-2">
          <h4>Liste des articles de l'entrepot</h4>
        </div>
      </div>

      <div class="col-md-3  ml-auto">
        <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
      </div>

      
    </div>

  </div>
</div>


</div>

<!-- fin section state -->
<!-- .page-section -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive bg-light py-3 px-2 border rounded">
      <table class="table table-hover my-table">
        <span style="font-size: 25px; font-weight: bold;" class=" d-flex mb-3">
          
        </span>
      <!-- .table -->
        <!-- thead -->
        <thead class="thead-light">
          <tr>
            <th style="width: 2%;">#</th>
            <th style="width: 20%;">Libelle</th>
            <th style="width: 17%;">Famille</th>
            <th style="width: 15%;">Prix Achat</th>
            <th style="width: 20%;">Prix Vente</th>
            <th style="width: 20%;"> Stock Alert</th>
            <th style="width: 10%;">Garantie</th>
            <th style="width: 10%;">Statut</th>
            <th style="width: 8%;">Actions</th>
          </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody class="entrepot-article-table">
          <?php
          $output = '';
          $id = $_SESSION['id_entrepot'] ?? '';
          $entrepot = Soutra::getAllArticleFamilleMarkDetailEntepot($id);
          // var_dump($entrepot);
          if (!empty($entrepot)) {
            $i = 0;

            foreach ($entrepot as $row) {
              $i++;
              $detail = '<button title="detail article" data-id_article="' . $row['ID_entrepot_article'] . '"  class="btn btn-info btn-sm btn_detail_entrepot_article mr-2">
                <i class="bi bi-eye"></i> </button>';
              $btn = '<button title="Désactiver l\'article" data-code="' . $row['ID_entrepot_article'] . '"  class="btn btn-danger btn-sm btnChangeStatutEntrepotArticle" data-statut="' . $row['etat_entrepot_article'] . '" data-id_entrepot="' . $id . '">
                <i class="bi bi-x-circle"></i> </button>';
              $etat = '<span class="badge badge-success">Disponible</span>';
              
             $edit = '<button title="Modifier entrepot" data-id="' . $row['ID_entrepot_article'] . '" class="btn btn-primary btn-sm mr-2 btn_update_entrepot_article">
            <i class="fa fa-edit"></i>  </button>';

              if ($row['etat_entrepot_article'] !== 1) {
                $etat = '<span class="badge badge-danger">Non disponible</span>';
                $btn = '<button title="activer entrepot" data-statut="' . $row['etat_entrepot_article'] . '" data-id_entrepot="' . $id . '" data-code="' . $row['ID_entrepot_article'] . '" class="btn btn-success btn-sm  btnChangeStatutEntrepotArticle">
                <i class="bi bi-check-circle"></i> </button>';

              $edit = '<button title="Non disponible"  class="btn btn-secondary btn-sm mr-2 ">
            ...  </button>';
              }

              $output .= '
            <tr class="row' . $row['ID_entrepot_article'] . '" >
              <td>' . $i . '</td>
              <td>' . $row['libelle_article'] . '</td>
              <td>' . $row['famille'] . '</td>
              <td>' . $row['prix_achat'] . '</td>
              <td>' . $row['prix_vente'] . '</td>
              <td><span class="badge badge-warning">'.$row['stock_alert'].'</span> </td>
              <td><span class="badge badge-info">'.$row['garantie_article'].' mois</span> </td>
              <td>' . $etat . '</td>
              <td class="d-flex justify-content-center" > ' . $edit . ' ' . $detail . ' ' . $btn . ' </td>
              ';


              $output .= '
              
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

<!-- modal -->
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

<?= modalEditEntrepotArticle() ?>
<?= modalAttribution() ?>
<?= modalDetailEntrepotArticle() ?>
<!-- btn detail -->
