<<<<<<< HEAD
<<<<<<< HEAD
 <?php
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(404);
    // header('Location: index.php');
    exit;
  }
  $code = $_GET['id'];
  // recupper data achat
  $approvision = Soutra::getElementSingle('achat', 'code_achat', $code);
  $detail_achat = Soutra::getSingleDataBonCommandeFournisseur($code);

  var_dump($detail_achat);
  // exit;


  ?>


 <!-- HEADER ACTIONS -->
 <div class="d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-dark" onclick="retour()"> <i class="bi bi-arrow-left"></i> Retour </button>
=======
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a
<?php 
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $code = $_GET['id'] ?? '';
  // TODO: Get command data from database
  $achat = Soutra::getSingleAchatByCode($code);
  $montant_versement_total = Soutra::getSumMontantVersementByAchat(1, $code);
  $versements = Soutra::getAllTableByClauses('versement', 'transaction_code', $code, 'etat_versement', 1);
}else{
  // error 404
  http_response_code(404);
  exit();
}
?>
<<<<<<< HEAD
>>>>>>> 0fce42155269788884b0b2cd7765a26d167db4a0
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a

<!-- HEADER ACTIONS -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <button class="btn btn-dark" onclick="retour()" > <i class="bi bi-arrow-left"></i> Retour </button>

<<<<<<< HEAD
<<<<<<< HEAD
 <!-- TITLE -->
 <div class="card custom-card-detail mb-3 ">
   <div class="card-body">
     <p class="text-muted mb-1">Administration / Approvisionnement / <?= $approvision['code_achat'] ?>
     </p>
     <h3 class="fw-bold"> <span> <i class="bi bi-info-circle"></i> Details</span>
       <span class="ms-2" id="reference-produit">N° <?= $approvision['code_achat'] ?>
       </span>
       <?= checkStatusCommande($approvision['statut_achat']) ?>
     </h3>
   </div>
 </div>
=======
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a
  <div class="d-flex gap-5">
    <button class="btn btn-success ml-2" title="" 
    id="btn_encaisser_achat"
    data-toggle="modal" data-target="#encaisser-modal"
    data-code="<?= $code ?>"
    data-original-title="Encaisser la facture de la commande"> <i class="bi bi-cash-coin"></i> Encaisser</button>
    <a href="<?= RACINE ?>views/print_achat.php?id=<?= $code ?>&statut=<?= $achat['statut_achat'] ?>" target="_blank" class="btn btn-dark ml-2" data-toggle="tooltip" title="" data-original-title="Télécharger la facture de la commande"> <i class="bi bi-download"></i> Télécharger</a>
  </div>
</div>
<<<<<<< HEAD
>>>>>>> 0fce42155269788884b0b2cd7765a26d167db4a0
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a

<!-- TITLE -->
<div class="card custom-card-detail mb-3">
  <div class="card-body">
    <p class="text-muted mb-1">Administration / Achats / <?= $code ?></p>
    <h3 class="fw-bold"> <span> <i class="bi bi-info-circle"></i> Details</span>
      <span class="ms-2" id="reference-produit">N° <?= $code ?></span>
      <?= checkStatusCommande($achat['statut_achat']) ?>
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
          <h6><span class="text-muted">Référence</span></h6>
        </div>
        <h5><?= $achat['reference'] ?></h5>
      </div>
    </div>
  </div>


<<<<<<< HEAD
<<<<<<< HEAD
   <div class="col-md-3">
     <div class="card custom-card-detail">
       <div class="card-body">
         <div class="d-flex align-items-center">
           <div class="icon bg-success mr-2">
             <i class="bi bi-cart4"></i>
           </div>
           <h6><span class="text-muted">TOTAL TTC</span></h6>
         </div>
         <h5> <?= $detail_achat['total'] ?>
           FCFA</h5>
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
           <h6><span class="text-muted">Facture reglé</span></h6>
         </div>
         <h5><?= $detail_achat['total'] ?> CFA</h5>
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
           <h6><span class="text-muted">Reste</span></h6>
         </div>
         <h5>0 CFA</h5>
       </div>
     </div>
   </div>
=======
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a
  <div class="col-md-3">
    <div class="card custom-card-detail">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="icon bg-success mr-2">
            <i class="bi bi-cart4"></i>
          </div>
          <h6><span class="text-muted">TOTAL TTC</span></h6>
        </div>
        <h5><?= number_format($achat['total_ttc'], 0, ',', ' ') ?> CFA</h5>
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
        <h5><?= number_format($montant_versement_total??0, 0, ',', ' ') ?> CFA</h5>
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
          <h6><span class="text-muted">Reliquat rendu</span></h6>
        </div>
        <h5><?= number_format(($achat['total_ttc']-$montant_versement_total), 0, ',', ' ') ?> CFA</h5>
      </div>
    </div>
  </div>
<<<<<<< HEAD
>>>>>>> 0fce42155269788884b0b2cd7765a26d167db4a0
=======
>>>>>>> dc9613e9fd2a9d5ea68564b749116db91c1ec44a

</div>

<!-- INFOS -->
<div class="row g-3">

  <!-- CLIENT -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-user-circle"></i> Fournisseur</div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Nom</span>
            <p class="fw-semibold"><?= $achat['nom_fournisseur'] ?></p>

            <span class="text-muted">Téléphone</span>
            <p class="fw-semibold"><?= $achat['telephone_fournisseur'] ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Email</span>
            <p class="fw-semibold"><?= $achat['email_fournisseur'] ?></p>

            <span class="text-muted">Mode de paiement</span>
            <p class="fw-semibold"><?= $achat['mode_paiement'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- INFOS -->
  <div class="col-md-6">
    <div class="card custom-card-detail">
      <div class="card-header"> <i class="fa fa-cog"></i> Préférences générales <span class="badge badge-info"><?= $achat['entrepot']??'' ?></span> </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <span class="text-muted">Date d'émission</span>
            <p class="fw-semibold"><?= date('d/m/Y', strtotime($achat['date_emission'])) ?></p>

            <span class="text-muted">Créé le</span>
            <p class="fw-semibold"><?= date('d/m/Y \à H:i', strtotime($achat['date_emission'])) ?></p>
          </div>

          <div class="col-6">
            <span class="text-muted">Date d'échéance</span>
            <p class="fw-semibold"><?= date('d/m/Y', strtotime($achat['date_emission'])) ?></p>

            <span class="text-muted">Fait par</span>
            <p class="fw-semibold"><?= $achat['fait_par'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

 <!-- INFOS -->
 <div class="row g-3">

   <!-- CLIENT -->
   <div class="col-md-6">
     <div class="card custom-card-detail">
       <div class="card-header"> <i class="fa fa-user-circle"></i> Fournisseur</div>
       <div class="card-body">
         <div class="row">
           <div class="col-6">
             <span class="text-muted">Nom</span>
             <p class="fw-semibold">Lillian Paul</p>

             <span class="text-muted">Téléphone</span>
             <p class="fw-semibold">+1 (877) 522-1782</p>
           </div>

           <div class="col-6">
             <span class="text-muted">Email</span>
             <p class="fw-semibold">tujoroh@mailinator.com</p>

             <span class="text-muted">Mode de paiement</span>
             <p class="fw-semibold">Espèces</p>
           </div>
         </div>
       </div>
     </div>
   </div>

   <!-- INFOS -->
   <div class="col-md-6">
     <div class="card custom-card-detail">
       <div class="card-header"> <i class="fa fa-cog"></i> Préférences générales</div>
       <div class="card-body">
         <div class="row">
           <div class="col-6">
             <span class="text-muted">Date d'émission</span>
             <p class="fw-semibold">31/03/2026</p>

             <span class="text-muted">Créé le</span>
             <p class="fw-semibold">01 avr. 2026 à 23:48</p>
           </div>

           <div class="col-6">
             <span class="text-muted">Date d'échéance</span>
             <p class="fw-semibold">31/03/2026</p>

             <span class="text-muted">Fait par</span>
             <p class="fw-semibold">treyka treyka01</p>
           </div>
         </div>
       </div>
     </div>
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
             <th>REFERENCE</th>
             <th>DATE </th>
             <th>MONTANT </th>
             <th style="width: 20%;text-align: center;"> STATUT </th>

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
            }else{
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

 <!-- Detail des produits commandés -->
 <div class="card">
   <div class="card-header">
     <h5 class="text-success"> <i class="fa fa-list"></i> Detail des produits commandés </h5>
   </div>
   <div class="card-body">
     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover">
         <!-- thead -->
         <thead class="thead-dark">
           <tr>
             <th> # </th>
             <th> Article</th>
             <th> MARK </th>
             <th> FAMILLE </th>
             <th class="text-right"> PRIX ACHAT </th>
             <th class="text-right"> QUANTITE </th>
             <th class="text-right"> TOTAL </th>
             <th style="width: 20%;text-align: center;"> ACTION </th>

           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->

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
 <form action="" id="btn_modifier_achat" method="POST">

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
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_ajouter_achat" class="form-control">

           <button type="submit" class="btn btn-primary">Enregistrer</button>
           <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 </form><!-- /.modal -->

       
  <!-- .modal -->
  
        <div class="modal fade" data-backdrop="static" id="encaisser-modal" tabindex="-1" role="dialog" aria-labelledby="encaisser-modal" aria-hidden="true">
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
              <form action="" id="form_encaisser_achat" method="POST">
              <div class="modal-body">
                <!-- .form-row -->
                <div class="form-row menu-modal">
                  <input type="hidden" name="code_achat" id="code_achat">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="montant_versement">Montant versement</label>
                      <input type="text" name="montant_versement" id="montant_versement" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
              </div><!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
              <input type="hidden" name="btn_encaisser_achat" class="form-control">

                <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal" >Close</button>
              </div><!-- /.modal-footer -->
            </form><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
