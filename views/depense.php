 <?php
    if (notAdmin()) {
        return;
    }
    ?>

 <?php
    // Dates par défaut
    $start = (new DateTime('first day of this month'))->format('Y-m-d');
    $end = (new DateTime('today'))->format('Y-m-d');

    $start_last = (new DateTime('first day of last month'))->format('Y-m-d');
    $end_last = (new DateTime('last day of last month'))->format('Y-m-d');
    // $end_last = (new DateTime('today'))->format('Y-m-d');

    $dateD = (new DateTime('first day of this month'))->format('d-m-Y');
    $dateF = (new DateTime('today'))->format('d-m-Y');

    // Récupérer les achats du mois courant
    // $totaux = Soutra::getTotauxDepenseByMouth($start, $end); // méthode adaptée que l'on a créée
    $depense_annule = Soutra::getTotalDepenseAny($start, $end, STATUT_DEPENSE[2]); // méthode adaptée que l'on a créée
    $depense_en_attente = Soutra::getTotalDepenseAny($start, $end, STATUT_DEPENSE[0]); // méthode adaptée que l'on a créée
    $depense_approuve = Soutra::getTotalDepenseAny($start, $end, STATUT_DEPENSE[1]); // méthode adaptée que l'on a créée
    ?>

 <header class="page-title-bar">
     <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
         <div class="title">
             <h1 class="page-title">Espace Dépenses</h1>
         </div>
         <div class="activity">
             <b id="activityDateRange">Activité du <?= $dateD . ' au ' . $dateF; ?> </b>
         </div>
         <div class="input-group" style="max-width: 40%;">
             <span class="input-group-text"><i class="fa fa-calendar"></i></span>
             <input type="text" name="datefilterDepense" class="form-control" id="datefilterDepense" placeholder="Sélectionner la période">
             <button id="filterBtn" class="btn btn-primary ml-2"><i class="fa fa-filter"></i></button>

         </div>
     </div>

 </header>

 <!-- STATS -->
 <div class="row g-3 mb-1">

     <div class="col-md-4">
         <div class="card custom-card-detail">
             <div class="card-body">
                 <div class="d-flex align-items-center">
                     <div class="icon bg-dark mr-2">
                         <i class="bi bi-x-octagon"></i>
                     </div>
                     <h6><span class="text-muted text-uppercase">Dépenses annulée </span>(<span id="nombre_depense_annule"> <?= $depense_annule['nombre_depense'] ?>
                         </span>)</h6>
                 </div>
                 <h5><span id="monant_depense_annule"><?= number_format($depense_annule['montant_depense'], 0, ',', ' ') ?>
                     </span> FCFA</h5>
             </div>
         </div>
     </div>

     <div class="col-md-4">
         <div class="card custom-card-detail">
             <div class="card-body">
                 <div class="d-flex align-items-center">
                     <div class="icon bg-warning mr-2">
                         <i class="bi bi-alarm"></i>
                     </div>
                     <h6><span class="text-muted text-uppercase">Dépenses en attentes</span> (<span id="nombre_depense_en_attente"> <?= $depense_en_attente['nombre_depense'] ?>
                         </span>)</h6>
                 </div>
                 <h5><span id="montant_depense_en_attente"><?= number_format($depense_en_attente['montant_depense'], 0, ',', ' ') ?>
                     </span> FCFA</h5>
             </div>
         </div>
     </div>

     <div class="col-md-4">
         <div class="card custom-card-detail">
             <div class="card-body">
                 <div class="d-flex align-items-center">
                     <div class="icon bg-success mr-2">
                         <i class="bi bi-check2-circle"></i>
                     </div>
                     <h6><span class="text-muted text-uppercase">Dépenses approuvées</span> (<span id="nombre_depense_approuve"> <?= $depense_approuve['nombre_depense'] ?>
                         </span>)</h6>
                 </div>
                 <h5><span class="tester" id="montant_depense_approuve"><?= number_format($depense_approuve['montant_depense'], 0, ',', ' ') ?>
                     </span> FCFA</h5>
             </div>
         </div>
     </div>

 </div>

 <div class="card">
     <div class="card-body">
         <div class="row">
             <div class="col-md-4">
                 <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
             </div>
             <div class="col-md-8 d-flex justify-content-end">
                 <button type="button" data-toggle="modal" data-target="#depense-modal" class="btn btn-primary w-25" title="Ajouter dépense" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
             </div>
         </div>
     </div>
 </div>
 <div class="card">
     <div class="card-body">

         <div class="table-responsive">
             <!-- .table -->
             <table class="table table-hover my-table">
                 <!-- thead -->
                 <thead class="thead-light">
                     <tr>
                         <th style="width: 2%;">#</th>
                         <th style="width: 15%;">Dépense</th>
                         <th style="width: 10%;">Periode</th>
                         <th style="width: 10%;">Statut</th>
                         <th style="width: 10%;">Montant</th>
                         <th style="width: 10%;">Créer par</th>
                         <th style="width: 10%;">Créer le</th>
                         <th style="width: 15%;">Actions</th>
                     </tr>
                 </thead><!-- /thead -->
                 <!-- tbody -->
                 <tbody class="depense-table">
                     <?php
                        // Dates par défaut
                        $start = (new DateTime('first day of this month'))->format('Y-m-d');
                        $end = (new DateTime('last day of this month'))->format('Y-m-d');
                        // Récupérer les achats du mois courant
                        $depense = Soutra::getAllListeDepenses($start, $end);
                        $output = '';
                        // $depense = Soutra::getAllListedepense();
                        if (!empty($depense)) {
                            $i = 0;
                            foreach ($depense as $row) {
                                ++$i;
                                $output .= '
                                <tr class="row' . $row['ID_depense'] . '">
                                <td>' . $i . '</td>
                                <td>' . $row['libelle_type'] . '</td>
                                <td>' . Soutra::date_format($row['periode']) . '</td>
                                <td>' . checkStatusDepense($row['statut_depense']) . '</td>
                                <td>' . number_format($row['montant'], 0, ',', ' ') . '</td>
                                <td>' . $row['employe'] . '</td>
                                <td>' . Soutra::date_format($row['date_created']) . '</td>
                                <td class="form-button-action"> ';

                                // btn Valider la deSTATUT_DEPENSE
                                $output .= '
                                        <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm btn_confirmer_depense " data-original-title="Voir details depense"> <i class="fa fa-eye text-icon-primary"></i> </button>
                                        ';

                                // btn Valider la deSTATUT_DEPENSE
                                if ($row['statut_depense'] == STATUT_DEPENSE[0]):
                                    $output .= '
                                        <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm btn_confirmer_depense " data-original-title="Approuver la depense"> <i class="fa fa-check text-icon-success"></i> </button>
                                        ';
                                endif;

                                // btn Valider la commande
                                if ($row['statut_depense'] == STATUT_DEPENSE[0]):
                                    $output .= '
                                        <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-sm btn_update_depense " data-original-title="Modifier depense"> <i class="fa fa-edit text-icon-info"></i> </button>
                                        ';
                                endif;

                                // btn Valider la deSTATUT_DEPENSE
                                if ($row['statut_depense'] == STATUT_DEPENSE[0]):
                                    $output .= '
                                        <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm btn_remove_depense " data-original-title="Annulé la depense"> <i class="fa fa-times text-icon-danger"></i> </button>
                                        ';
                                endif;

                                $output . '
                                </td>
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

 <div class="modal fade" data-backdrop="static" id="depense-modal" tabindex="-1" role="dialog"
     aria-labelledby="depense-modal" aria-hidden="true">
     <!-- .modal-dialog -->
     <div class="modal-dialog modal-lg" role="document">
         <!-- .modal-content -->
         <div class="modal-content">
             <!-- .modal-header -->
             <div class="modal-header">
                 <h6 class="modal-title inline-editable">Formulaire <i class=""></i>
                 </h6>
             </div><!-- /.modal-header -->
             <!-- .modal-body -->
             <div class="modal-body">
                 <form action="" id="btn_ajouter_depense" method="POST">

                     <!-- .form-row -->
                     <div class="form-row menu-modal">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="nom">Dépende</label>
                                 <select name="type_id" class="form-control search_depense">
                                     <option value="">--- selection ---</option>
                                     <?php
                                        $data = Soutra::getAllByFromTable("type_depense", "libelle_type");
                                        foreach ($data as $value) {
                                        ?>
                                         <option value="<?= $value['ID_type'] ?>"><?= $value['libelle_type'] ?></option>
                                     <?php } ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="nom">Entreppot</label>
                                 <select name="entrepot_id" class="form-control select" id="">
                                     <option value="">--- selection ---</option>
                                     <?php
                                        $data = Soutra::getAllTable("entrepot", "etat_entrepot", 1);
                                        foreach ($data as $value) {
                                        ?>
                                         <option value="<?= $value['ID_entrepot'] ?>"><?= $value['libelle_entrepot'] ?></option>
                                     <?php } ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="montant">Montant</label>
                                 <input type="text" name="montant" id="montant" placeholder="Ex:10 000"
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="periode">date</label>
                                 <input type="date" name="periode" value="<?= date('Y-m-d') ?>" id="periode"
                                     class="form-control">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="Description">Description</label>
                                 <textarea name="description" class="form-control" id="Description" rows="3"></textarea>
                             </div>
                         </div>

                     </div><!-- /.form-row -->
                     <!-- .modal-footer -->
                     <div class="modal-footer">
                         <input type="hidden" name="btn_ajouter_depense" class="form-control">

                         <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button"
                             class="btn btn-light dismiss_modal">Close</button>
                     </div><!-- /.modal-footer -->
                 </form><!-- /.modal -->

             </div><!-- /.modal-body -->

         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.m -->