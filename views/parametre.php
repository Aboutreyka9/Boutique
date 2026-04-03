<?php 
$employe = Soutra::getAllByItemsa('employe','ID_employe',$_SESSION['id_employe']);
 ?>
<div class="page-section mt-5 col-12 col-md-* col-lg-*">
        <h1 class="page-title"> Profil Utilisateur</h1>
    <p class="text-muted"> Profil</p>
    <div class="row">
        <!-- grid column -->
        <div class="col-xl-6 col-12 col-md-* col-lg-*">
        <!-- .card -->
                <ul class="list-group my_item_child">
                    <li class="list-group-item"><span class="my_item">Nom :</span><?= $employe['nom_employe'] ?></li>
                    <li class="list-group-item"><span class="my_item">Prenom :</span><?= $employe['prenom_employe'] ?></li>
                    <li class="list-group-item"><span class="my_item">Telephone :</span><?= $employe['telephone_employe'] ?></li>
                    <li class="list-group-item"><span class="my_item">Fonction :</span><?= Soutra::libelle('role','libelle_role','ID_role',$employe['role_id']) ?></li>
                </ul>
        </div><!-- /grid column -->

         <!-- grid column -->
         <div class="col-xl-6"> 
        <!-- .card -->
            <section class="card card-body card-fluid">
                <h6>Authentification</h6>
               <form action="" id="btn_update_login_employe" method="post">
               <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="password">Ancien mot de passe</label>
                       <input type="text" name="password" id="password" class="form-control">
                    </div>
                  </div>
                </div><!-- /.form-row -->
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="new_password">Nouveau mot de password</label>
                       <input type="text" name="new_password" id="new_password" class="form-control">
                    </div>
                  </div>
                  <input type="hidden" name="btn_update_login_employe" value="" id="btn_update_login_employe" class="form-control">

                </div><!-- /.form-row -->
                <button type="submit" class="btn btn-primary">Changer mot de passe</button>
               </form>
            </section><!-- /.card -->
        </div><!-- /grid column -->


    </div><!-- /grid row -->
</div><!-- /section -->