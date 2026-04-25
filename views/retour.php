<header class="page-title-bar">
        <h1 class="page-title">  Espace Retour</h1>
    <p class="text-muted"> Gérer les articles retournes </p>
   <!-- floating action -->
   <!-- <button type="button" id="btn_ajouter_vente" class="btn btn-success btn-floated" title="Effectuer Achat"><span style="line-height: 45px" class="fa fa-plus"></span></button> -->
    <!-- /floating action -->
   <form id="btn_detail" action="" method="post">
    <div class="row">
    <div class="col-md-10">
        <div class="form-group">
          <label for="article">Code vente - Telephone client</label>
          <select name="code_vent" class="form-control" id="select_code_vente">
          <option value=""></option>

          <?php 
                $code = "";
                $vente = Soutra::getAllVenteCodeAndeTelephone(1);
                $output = "";
                foreach ($vente as $row) {
                  $output .='
                  <option value="'.$row['code'].'">'.$row['code'] .' - '.$row['client'].'</option>
                  ';
                }
                echo $output;
          ?>
          </select>
        </div>
        <input type="hidden" name="btn_detail">
    </div>
    <div class="col-md-2 mt-4">
        <div class="form-group">
          <button  class="btn btn-primary w-100" type="submit"> <i class="fa fa-eye"></i>&ensp; Verifier</button>
        </div>
    </div>
    </div>
   </form>
    <!-- title and toolbar -->
  </header><!-- /.page-title-bar -->
  <!-- .page-section -->
  <div class="row row_detail ">
    <div class="col-md-6 mb-3 ">
      <div class="card">
          <div class="card-header">
            <h4>Information client</h4>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-6">
                  <img style=" border-radius: 50%; width: 10em; height: 10em; border:solid #c6c6c5 2px;" src="<?= ASSETS ?>images/avatars/apple-touch-icon.png" alt="">
                  </div>
                  <div class="col-md-6">
                    
                      <p><span class="text-uppercase my_item">Nom :</span> <span class="my_item_midle" id="nom"></span> </p>
                      <p><span class="text-uppercase my_item">Prenom :</span> <span class="my_item_midle" id="prenom"></span></p>
                      <p><span class="text-uppercase my_item">Contact :</span> <span class="my_item_midle" id="telephone"></span></p>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="col-md-6 mb-3 ">
      <div class="card">
          <div class="card-header">
            <h4>Info code :<span class="my_item_midle" id="code" ></span></h4>
          </div>
          <div class="card-body">
                <p><span class="text-uppercase my_item">Realisé par :</span> <span class="my_item_midle" id="employe"></span> </p>
                <p><span class="text-uppercase my_item">montant :</span> <span class="my_item_midle" id="montant"></span></p>
                <p><span class="text-uppercase my_item">Date :</span> <span class="my_item_midle" id="date_vente"></span></p>
                <p class="d_none"><button id="" data-url="" class="btn btn-primary w-75 resoudre">Resoudre</button></p>
          </div>
      </div>
    </div>

  </div>
