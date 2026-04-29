 <?php
  // if(!isAdminGestionnaire()){
  //   return;
  // }

  $info = Soutra::getInfoBoutique();
  $taxe = $info['taxe'];
  // var_dump($info);
  ?>

 <header class="page-title-bar" id="page_vente_sexion">
   
 
  <div class="header-vente d-flex align-items-center mb-4">
    <i class="bi bi-cart-check me-3 mr-3" style="font-size:30px;"></i>
    <div>
      <h4 class="mb-0">Espace Vente</h4>
      <small>Gestion des ventes et encaissements</small>
    </div>
  </div>
  
   <!-- <p class="text-muted"> Ajouter une vente</p> -->
   <?php if (Soutra::getState('client') == 1): ?>
     <div class="row">
       <div class="col-md-12">
         <div class="card">
           <div class="card-body">
             <form method="post" id="frm_client_vente_sexion">
               <div class="row my-3">
                 <div class="col-md-4">
                   <div style="position: relative;" class="form-group">
                     <label for="client">Client</label>
                     <select name="client" class="form-control client_search" id="client">
                       <option value="">--- CHOISIR ---</option>
                       <?php
                        $client = Soutra::getAllClient();
                        $output = "";
                        foreach ($client as $row) {
                          $output .= '
                  <option value="' . $row['ID_client'] . '">' . $row['nom_client'] . '  ' . $row['prenom_client'] . '  ' . $row['telephone_client'] . '</option>
                  ';
                        }
                        echo $output;
                        ?>
                     </select>
                     <div id="client-data-modal" class="wrap-mini-btn">
                       <i data-title="Ajouter un nouveau client" class="fas fa-user-plus fa-lg"></i>
                     </div>
                   </div>
                 </div>

                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Nom</label>
                     <input readonly type="text" id="nom_client" class="form-control">
                   </div>
                 </div>

                 <div class="col-md-4">
                   <div class="form-group">
                     <label>telephone</label>
                     <input readonly type="text" id="telephone_client"
                       class="form-control">
                   </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Email</label>
                     <input readonly type="email" id="email_client" class="form-control">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Date d'emission</label>
                     <input type="date" name="date_emission" value="<?= date('Y-m-d') ?>" id="date_emission"
                       class="form-control">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Date d'échéance</label>
                     <input type="date" name="date_echeance" value="<?= date('Y-m-d') ?>" id="date_echeance" class="form-control">
                   </div>
                 </div>
               </div>
             </form>
           </div>
           <div class="col-md-12">
             <div class="form-group">
               <h3>Ce client doit : <strong id="dette_client"></strong></h3>
             </div>
           </div>
         </div>
       </div>
     </div>
   <?php else : ?>
     <input type="hidden" name="client" id="client" value="1">
   <?php endif; ?>



   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->

 <div class="card">
   <div class="card-header">
     <form id="btn_ajouter_panier_vente" action="" method="post">
       <div class="row">
         <div class="col-md-10">
           <div class="form-group">
             <label for="article">Article - Mark-Slug</label>
             <select name="article[]" class="form-control" id="select_article_vente" multiple>
               <?php
                $article = Soutra::getAllArticleFamilleMark();
                $output = "";
                foreach ($article as $row) {
                  $output .= '
                  <option value="' . $row['ID_article'] . '">' . $row['libelle_article'] . ' - ' . $row['mark'] . ' - ' . $row['slug'] . '</option>
                  ';
                }
                echo $output;
                ?>
             </select>
           </div>
           <input type="hidden" name="btn_ajouter_panier_vente">
           <input type="hidden" id="page_vente" value="123">
         </div>
         <div class="col-md-2">
           <div class="form-group">
             <label style="color:transparent ;">readonly</label>
             <button class="btn btn-primary w-100" type="submit"> <i class="fa fa-plus"></i>&ensp; Ajouter</button>
           </div>
         </div>
       </div>
     </form>
   </div>
   <div class="card-body">
     <div class="row row_montant">
       <div class="col-md-12 mb-3 ">
         <span style="font-size: 35px;"> Montant :</span> <span class="mtt" style="font-size: 35px;"> 0</span> <span style="font-size: 35px;"> FCFA</span>
       </div>
     </div>
     <div class="table-responsive bg-light py-3 px-2 border rounded panier_vente">
       <!-- .table -->
       <table class="table table-hover table_total table-nowrap">
         <!-- thead -->
         <thead class="thead-light">
           <tr>
             <th style="width: 3%;">#</th>
             <th style="width: 20%;">Article</th>
             <th style="width: 10%;">Catégorie</th>
             <th style="width: 8%;">Stock</th>
             <th style="width: 8%;">PU</th>
             <th style="width: 10%;">Quantité</th>
             <th style="width: 10%;">Total</th>
             <th style="width: 10%;">Action</th>
           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="vente-data-table">
         </tbody><!-- /tbody -->
       </table><!-- /.table -->
     </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
   </div>
 </div>


 <div class="card">
   <div class="card-body">
     <div class="card payment-card p-4">

       <div class="row g-4">

         <!-- LEFT -->
         <div class="col-md-6">

           <div class="line">
             <span>Total HT:</span>
             <h5> <strong><span class="mtt" id="total_ht">0</span> FCFA</strong></h5>
             <input type="hidden" name="mtt" class="mtt">

           </div>

           <div class="line align-items-center">
             <span>Montant de la remise :</span>

             <div class="input-group remise-input">
               <input type="number" class="form-control" min="0" id="montant_remise" value="0">
               <span class="input-group-text"> FCFA</span>
             </div>
           </div>

           <div class="line">
             <span>Total Après remise :</span>
             <h5> <strong><span id="total_apres_remise">0</span> FCFA</strong></h5>
           </div>

           <div class="line total-ttc">
             <span>Total TTC:</span>
             <input type="hidden" id="taxe" value="<?= $taxe ?>">
             <h3 class="text-primary montant_total_ttc"><span id="total_ttc"></span> FCFA</h3>
             <input type="hidden" id="total_ttc_hidden">
           </div>

         </div>

         <!-- RIGHT -->
         <div class="col-md-6">

           <div class="mb-3">
             <label class="form-label">Mode de paiement :</label>
             <select name="pay_mode" class="form-control pay_mode">
               <!-- <option value=""></option> -->
               <?= payement() ?>

             </select>
           </div>

           <div class="mb-3">
             <label class="form-label">encaisse :</label>
             <div class="input-group">
               <input type="number" class="form-control " id="montant_encaisse" value="0">
               <span class="input-group-text"> FCFA</span>
             </div>
           </div>

           <div class="mb-3">
             <label class="form-label">Reliquat :</label>
             <div class="input-group">
               <input type="number" class="form-control" id="reliquat" value="0">
               <span class="input-group-text"> FCFA</span>
             </div>
           </div>

           <div>
             <label class="form-label">Commentaire :</label>
             <textarea class="form-control" rows="2"></textarea>
           </div>

         </div>
         <div class="col-md-12 text-end mt-3">
           <button id="btn_ajouter_vente" class="btn btn-success w-50"> <i class="bi bi-save"></i> ENREGISTRER </button>
         </div>

       </div>

     </div>
   </div><!-- /.card -->
 </div>





 <?= modalVenteClient(); ?>