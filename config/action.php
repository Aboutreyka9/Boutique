<?php
function modalVenteClient()
{
  return '
    
  <!-- .modal -->
  <form action="" id="btn_ajouter_client" method="POST" >
  
        <div class="modal fade" data-backdrop="static" id="client-modal" tabindex="-1" role="dialog" aria-labelledby="client-modal" aria-hidden="true">
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
                      <label for="nom_client">Nom</label>
                       <input type="text" name="nom_client" id="nom_client" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="telephone_client">Telephone</label>
                      <input type="text" name="telephone_client" id="telephone_client" class="form-control">
                      <input type="hidden" name="code_inscrire" id="code_module" class="form-control">
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="form-group">
                      <label for="email_client">Email</label>
                      <input type="email" name="email_client" id="email_client" class="form-control">
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="form-group">
                      <label for="adresse_client">Adresse</label>
                      <textarea rows="3" name="adresse_client" class="form-control"></textarea>
                    </div>
                  </div>
                  
                </div><!-- /.form-row -->
              </div><!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
              <input type="hidden" name="btn_ajouter_client" class="form-control">

                <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
      </form><!-- /.modal -->


            ';
}


function modalAchatFournisseur()
{
  return '
  
  <!-- .modal -->
  <form action="" id="btn_ajouter_fournisseur" method="POST" >
  
        <div class="modal fade" data-backdrop="static" id="fournisseur-modal" tabindex="-1" role="dialog" aria-labelledby="fournisseur-modal" aria-hidden="true">
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
                      <label for="nom_fournisseur">Nom</label>
                       <input type="text" name="nom_fournisseur" id="nom_fournisseur" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="telephone_fournisseur">Telephone</label>
                      <input type="text" name="telephone_fournisseur" id="telephone_fournisseur" class="form-control">
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="form-group">
                      <label for="email_fournisseur">Email</label>
                      <input type="email" name="email_fournisseur" id="email_fournisseur" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="adresse_fournisseur">Adresse</label>
                      <textarea rows="3" name="adresse_fournisseur" class="form-control"></textarea>
                    </div>
                  </div>
                  
                </div><!-- /.form-row -->
              </div><!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
              <input type="hidden" name="btn_ajouter_fournisseur" class="form-control">

                <button type="submit" class="btn btn-primary">Enregistrer</button> <button type="button" class="btn btn-light dismiss_modal">Close</button>
              </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.m -->
      </form><!-- /.modal -->

  ';
}




function modalAttribution()
{
  return '
     <!-- .modal attribuer-->
   <div class="modal fade" data-backdrop="static" id="attribuer-modal" tabindex="-1" role="dialog" aria-labelledby="attribuer-modal" aria-hidden="true">
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
           <div class="form-row menu-modal-attribuer">
           </div><!-- /.form-row -->
         </div><!-- /.modal-body -->
         <!-- .modal-footer -->
         <div class="modal-footer">
         </div><!-- /.modal-footer -->
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.m -->
 <!-- /.modal -->
    ';
}

function modalEncaissement()
{
  return '
  <div class="modal fade" data-backdrop="static" id="encaisser-modal" tabindex="-1" role="dialog" aria-labelledby="encaisser-modal" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h6 class="modal-title inline-editable">Formulaire <i class=""></i>
          </h6>
        </div> <!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
            <!-- .form-row -->
            <div class="form-row menu-modal-encaissement">
            </div><!-- /.form-row -->
          </div><!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
          </div><!-- /.modal-footer -->
      <!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.m -->
  </div>
  ';
}

function pageNotFound()
{
  echo '
        <section class="empty-state">
    <!-- .empty-state-container -->
    <div class="empty-state-container">
        <div class="state-figure">
        <img class="img-fluid" src="' . ASSETS . 'images/illustration/img-2.png" alt="" style="max-width: 320px">
        </div>
        <h3 class="state-header"> Page Not found! </h3>
        <p class="state-description lead text-muted">Desolé cette page ou l\'URL n\'existe pas, Veuillez cliquer sur le bouton retour. </p>
        <div class="state-action">
        <button type="button" id="historique" class="btn btn-lg btn-light"><i class="fa fa-angle-right"></i> Retour</button>
        </div>
    </div><!-- /.empty-state-container -->
</section><!-- /.empty-state -->
  ';
}

function payement($p = "")
{
  $output = '';
  if (empty($p)) {
    for ($i = 0; $i < count(MODE_PAIEMENT); $i++) {
      $output .= '<option value ="' . MODE_PAIEMENT[$i] . '" >' . ucwords(MODE_PAIEMENT[$i]) . '</option>';
    }
  }
  return $output;
}
