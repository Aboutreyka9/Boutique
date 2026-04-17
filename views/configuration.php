<?php 
if(notAdmin()){
  return;
}

$info = Soutra::getInfoBoutique();
$image = $info['image'];
 ?>
<div class="page-section mt-5 col-12 col-md-* col-lg-*">
        <h1 class="page-title"> Configuration Boutique</h1>
    <p class="text-muted"> Configurer les informations de la boutique</p>
    <div class="row">
         <!-- grid column -->
         <div class="col-xl-6"> 
        <!-- .card -->
        <section class="card card-body card-fluid">
                <h6>Info boutique</h6>
               <form action="" id="frm_config_info" method="post">
               <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nom">Nom boutique</label>
                       <input type="text" value="<?= @$info['nom'] ?>" required name="nom" id="nom" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="adresse">Adresse boutique</label>
                      <textarea class="form-control" maxlength="150" name="adresse" id="adresse" cols="30" rows="5"><?= @$info['adresse'] ?></textarea>
                    </div>
                  </div>
                  <input type="hidden" name="btn_config_info" value="" id="btn_config_info" class="form-control">

                </div><!-- /.form-row -->
                <button type="submit" class="btn btn-primary">Modifier les informations</button>
               </form>
            </section><!-- /.card -->

            <section id="image" class="card">
                  <!-- .card-body -->
                  <div class="card-body">
                    <h3 class="card-title"> Configuration Logo </h3>
                  
                  <div class="form-row ">
                  <div class="col-md-6 fr_image_visible">
                    <div class="form-group">
                      <label for="logo">Logo-image</label>
                       <input type="file"  id="change_logo" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6 fr_image_hidden d_none">
                    <div class="form-group">
                      <button type="button" id="modifier_logo" class="btn btn-warning w-50"><i class="fa fa-camera"></i>  Modifier logo</button>
                    </div>
                  </div>
                  <div class="col-md-2 "></div>
                  <div class="col-md-4">
                  <img id="logo" style="width: 110px; height: 110px;" src="<?= $image ?>" alt="" srcset="">
                    <!-- <div class="form-group">
                      <label for="logo">Logo-image</label>
                       <input type="file" name="" id="" class="form-control">
                    </div> -->
                  </div>

                </div><!-- /.form-row -->
                </div><!-- /.card-body -->
                </section><!-- /.card -->

            <section id="taxe" class="card">
                  <!-- .card-body -->
                  <div class="card-body">
                    <h3 class="card-title"> Configuration Taxe(%) </h3>
                  <form class="form_taxe" method="post">
                  <div class="form-row ">
                  <div class="col-md-6 ">
                    <div class="form-group">
                      <input type="text"  id="change_taxe" value="<?= $info['taxe'] ?>" name="taxe" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="btn_update_taxe" >
                      <button type="submit" id="modifier_taxe" class="btn btn-info w-50 pull-right">  Modifier taxe</button>
                    </div>
                  </div>
                  
                </div><!-- /.form-row -->
                </form>
                </div><!-- /.card-body -->
                </section><!-- /.card -->
           
        
           </div><!-- /grid column -->

        <!-- /grid column -->

         <!-- grid column -->
        <div class="col-xl-6"> 
        <!-- .card -->
        <section class="card card-body card-fluid">
                <h6>Contacts boutique</h6>
               <form action="" id="frm_config_contact" method="post">
               <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="contact1">Contact 1</label>
                       <input type="text" value="<?= @$info['contact1'] ?>" required name="contact1" id="contact1" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="contact2">Contact 2</label>
                       <input type="text" value="<?= @$info['contact2'] ?>" name="contact2" id="contact2" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->

                  <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="email">email</label>
                       <input type="email" value="<?= @$info['email'] ?>" name="email" id="email" class="form-control">
                    </div>
                  </div>
                  
                  <input type="hidden" name="btn_config_contact" value="" id="btn_config_contact" class="form-control">
                </div><!-- /.form-row -->
                <button type="submit" class="btn btn-primary">Modifier les contacts</button>
               </form>
            </section><!-- /.card -->

            <section id="switcher" class="card">
                  <!-- .card-body -->
                  <div class="card-body">
                    <h3 class="card-title"> Autorisation sur des fonctionnalités </h3>
                  </div><!-- /.card-body -->
                  <!-- .list-group -->
                  <div class="list-group list-group-flush list-group-bordered">
                    <!-- .list-group-item -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Gestion Fournisseur</span> <!-- .switcher-control -->
                      <label class="switcher-control"><input type="checkbox" class="switcher-input" id="switch_fournisseur" value="<?= (@$info['fournisseur'] != 1) ? 1 : 0 ?>" <?= @$info['fournisseur'] == 1 ? "checked" : "" ?> > <span class="switcher-indicator"></span></label> <!-- /.switcher-control -->
                    </div><!-- /.list-group-item -->
                    <!-- .list-group-item -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Gestion Client</span> <!-- .switcher-control -->
                      <label class="switcher-control"><input type="checkbox" class="switcher-input" id="switch_client" value="<?= (@$info['client'] != 1) ? 1 : 0 ?>" <?= @$info['client'] == 1 ? "checked" : ""?> > <span class="switcher-indicator"></span></label> <!-- /.switcher-control -->
                    </div><!-- /.list-group-item -->
                          <!-- .list-group-item -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Gestion Unité</span> <!-- .switcher-control -->
                      <label class="switcher-control"><input type="checkbox" class="switcher-input" id="switch_unite" value="<?= (@$info['unite'] != 1) ? 1 : 0 ?>" <?= @$info['unite'] == 1 ? "checked" : ""?> > <span class="switcher-indicator"></span></label> <!-- /.switcher-control -->
                    </div><!-- /.list-group-item -->
                     <!-- .list-group-item -->
                     <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Chart(line)</span> <!-- .switcher-control -->
                      <label class="switcher-control"><input type="checkbox" class="switcher-input" id="switch_unite" value="<?= (@$info['unite'] != 1) ? 1 : 0 ?>" <?= @$info['unite'] == 1 ? "checked" : ""?> > <span class="switcher-indicator"></span></label> <!-- /.switcher-control -->
                    </div><!-- /.list-group-item -->
                      <!-- .list-group-item -->
                      <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Suppression des données</span> <!-- .switcher-control -->
                      <label class="switcher-control"><input type="checkbox" class="switcher-input" id="switch_delete" value="<?= (@$info['supprimer'] != 1) ? 1 : 0  ?>" <?= @$info['supprimer'] == 1 ? "checked" : ""?> > <span class="switcher-indicator"></span></label> <!-- /.switcher-control -->
                    </div><!-- /.list-group-item -->
                   
                  </div><!-- /.list-group -->
                </section><!-- /.card -->
           
        
           </div><!-- /grid column -->
           
    </div><!-- /grid row -->

    
</div><!-- /section -->