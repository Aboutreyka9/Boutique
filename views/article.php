 <?php
 if (!isAdminGestionnaire()) {
     return;
 }
  ?>
 <header class="page-title-bar">
   <h1 class="page-title"> Espace Produits</h1>
   <p class="text-muted"> Liste des produits</p>

   <!-- title and toolbar -->
 </header><!-- /.page-title-bar -->

 <div class="card">
   <div class="card-body">
     <div class="row">
       <div class="col-md-4">
         <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="bi bi-arrow-repeat"></i> &nbsp; Mettre à jour</button>
       </div>
       <div class="col-md-8 d-flex justify-content-end">
         <button type="button" data-toggle="modal" data-target="#article-modal" class="btn btn-primary w-25" title="Ajouter article" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
       </div>
     </div>
   </div>
 </div>

 <!-- .page-section -->
 <div class="card">
   <div class="card-body">
     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover my-table">
         <!-- thead -->
         <thead class="thead-dark">
           <tr>
             <th style="width: 2%;">#</th>
             <th style="width: 20%;">Produit</th>
             <th style="width: 15%;">Catégorie</th>
             <th style="width: 8%;">Mark</th>
             <th style="width: 8%;">Unité</th>
             <th style="width: 8%;">Actions</th>
           </tr>
         </thead><!-- /thead -->
         <!-- tbody -->
         <tbody class="article-table">
           <?php
            $output = '';
            $article = Soutra::getAllarticle();
            if (!empty($article)) {
              $i = 0;
              foreach ($article as $row) {
                $i++;
                //$etat = $row['etat_article'] == 1 ? "Disponible" : "Non disponible";
                $output .= '
            <tr class="row' . $row['ID_article'] . '">
               <td>' . $i . '</td>
               <td>' . $row['libelle_article'] . '</td>
               <td>' . $row['famille'] . '</td>
               <td>' . $row['mark'] . '</td>
               <td>' . $row['unite'] . '</td>
               ';


                $output .= '<td style="display: flex; flex-direction: row; align-items: center; gap: 10px;"> 
            <button data-id="' . $row['ID_article'] . '" title="Modifier article" class="btn btn-primary btn-sm btn_update_article">
            <i class="fa fa-edit"></i> </button>

            <button data-id="' . $row['ID_article'] . '" title="Atribuer article" class="btn btn-success btn-sm btn_attribuer_article"  data-action="article">
            <i class="fa fa-link"></i></button>
            
            <button data-id="' . $row['ID_article'] . '" title="Supprimer article" class="btn btn-warning btn-sm btn_remove_articlek">
            <i class="fa fa-trash"></i></button>
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
 <form action="" id="btn_ajouter_article" method="POST">

   <div class="modal fade" data-backdrop="static" id="article-modal" tabindex="-1" role="dialog" aria-labelledby="article-modal" aria-hidden="true">
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
           <!-- .form-row -->
           <div class="form-row menu-modal">
             <div class="col-md-6">
               <div class="form-group">
                 <label for="libelle_article">Nom produit <span class="text-danger">*</span> </label>
                 <input type="text" name="libelle_article" id="libelle_article" class="form-control">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label for="slug">Slug</label>
                 <input type="text" name="slug" id="slug" class="form-control" placeholder="Ex:P-005">
               </div>
             </div>
             
             <div class="col-md-4">
               <div class="form-group">
                 <label for="famille_id">Catégorie <span class="text-danger">*</span> </label>
                 <select name="famille_id" id="famille_id" class="form-control">
                   <?php
                    $famille = Soutra::getAllTable('famille', 'etat_famille', 1);
                    $output = "";
                    if (!empty($famille)) {
                      foreach ($famille as $row) {
                        $output .= '
                          <option value="' . $row['ID_famille'] . '">' . $row['libelle_famille'] . '</option>
                          ';
                      }
                    }
                    echo $output;
                    ?>

                 </select>
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label for="mark_id">Marque </label>
                 <select name="mark_id" id="mark_id" class="form-control">
                   <?php
                    $mark = Soutra::getAllTable('mark', 'etat_mark', 1);
                    $output = "";
                    if (!empty($mark)) {
                      foreach ($mark as $row) {
                        $output .= '
                        <option value="' . $row['ID_mark'] . '">' . $row['libelle_mark'] . '</option>
                        ';
                      }
                    }
                    echo $output;
                    ?>

                 </select>
               </div>
             </div>
             <?php
              // if(Soutra::getState('unite') == 1): // a revoir çà ploque la page
              ?>
             <div class="col-md-4">
               <div class="form-group">
                 <label for="unite">Uinité </label>
                 <select name="unite" id="unite" class="form-control">
                   <?php
                    $unite = Soutra::getAllTable('unite', 'etat_unite', 1);
                    $output = "";
                    if (!empty($unite)) {
                      foreach ($unite as $row) {
                        $output .= '
                        <option value="' . $row['ID_unite'] . '">' . $row['slug_unite'] . '</option>
                        ';
                      }
                    }
                    echo $output;
                    ?>

                 </select>
               </div>
             </div>
             <?php
              // endif;
              ?>
             
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
           <input type="hidden" name="btn_ajouter_article" class="form-control">

           <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 </form><!-- /.modal -->


 <!-- .modal attribuer-->

 <?= modalAttribution() ?>

 <!-- /.modal -->