<header class="app-header app-header-dark bg-primary">
  <!-- Loader Overlay -->
  <div id="globalLoader" class="overlay hidden">
    <div class="spinner"></div>
  </div>
  <!-- .top-bar -->
  <div class="top-bar">
    <!-- .top-bar-brand -->
    <div class="top-bar-brand">
      <a href="<?= RACINE; ?>">
        GESTOCK
        <!-- <img src="<?= ASSETS; ?>images/brand-inverse.png" alt="" style="height: 32px;width: auto;"> -->
      </a>
    </div><!-- /.top-bar-brand -->
    <!-- .top-bar-list -->

    <div class="top-bar-list">
      <!-- .top-bar-item -->
      <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
        <!-- toggle menu -->
        <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="toggle menu"><span
            class="hamburger-box"><span class="hamburger-inner"></span></span></button> <!-- /toggle menu -->
      </div><!-- /.top-bar-item -->
      <!-- .top-bar-item -->

      <?php if (strtolower($_SESSION['role']) == ADMIN): ?>

        <div class="top-bar-item top-bar-item-full">
          <!-- .top-bar-search -->
          <div class="top-bar-search">
            <div class="input-group input-group-search">
              <div class="input-group-prepend">
                <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>
              </div><input type="text" class="form-control" aria-label="Search" placeholder="Search">
            </div>
          </div><!-- /.top-bar-search -->
        </div><!-- /.top-bar-item -->

      <?php endif; ?>

      <!-- .top-bar-item -->

      <div class="top-bar-item top-bar-item-right px-0 d-sm-flex">
        <!-- .nav -->
        <?php if (strtolower($_SESSION['role']) == ADMIN || strtolower($_SESSION['role']) == GESTIONNAIRE): ?>

          <ul class="header-nav nav">
            <li class="nav-item dropdown header-nav-dropdown has-notified">
              <a href="<?= URL; ?>ajouter_vente" class="nav-link">
                <i class="bi bi-cart4 heart-beat"></i>
              </a>
            </li>

            <li class="nav-item dropdown header-nav-dropdown has-notified">
              <a data-id="<?= pages(); ?>" class="nav-link sauvegard"><i class="fa fa-download"></i></a>
              <!-- .dropdown-menu -->
            </li><!-- /.nav-item -->
            <?php
            $limit = Soutra::getStockLimitAlert();

            if (count($limit) > 0): ?>

              <!-- .nav-item -->
              <li class="nav-item dropdown header-nav-dropdown has-notified">
                <a class="nav-link" href="#!" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true"
                  aria-expanded="false"><span style="color: #eb2f2fff;" class="oi oi-envelope-open  pulse">
                    <?= count($limit); ?></span></a>
                <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
                <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                  <h6 class="dropdown-header stop-propagation">
                    <span>Messages Alert</span>
                  </h6><!-- .dropdown-scroll -->
                  <div class="dropdown-scroll perfect-scrollbar">



                    <?php foreach ($limit as $key => $value) { ?>

                      <!-- .dropdown-item -->
                      <a href="<?= URL; ?>approvision&id=<?= $value['article_id']; ?>" class="dropdown-item">
                        <div class="tile tile-circle bg-warning"> A </div>
                        <div class="dropdown-item-body">
                          <p class="subject"> <?= $value['libelle_article']; ?> </p>
                        </div>
                      </a> <!-- /.dropdown-item -->

                    <?php } ?>
                  </div><!-- /.dropdown-scroll -->
                </div><!-- /.dropdown-menu -->
              </li><!-- /.nav-item -->
            <?php endif; ?>
            <!-- .nav-item -->
            <li class="nav-item dropdown header-nav-dropdown">
              <a class="nav-link" href="#!" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                  class="oi oi-grid-three-up "></span></a>
              <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
              <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                <!-- .dropdown-sheets -->
                <div class="dropdown-sheets">
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=employes" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-indigo"><i class="oi oi-people"></i></span> <span
                        class="tile-peek">Employés</span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=fournisseurs" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-dark"><i class="oi oi-people"></i></span> <span
                        class="tile-peek">Forunisseurs</span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=clients" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-teal"><i class="oi oi-people"></i></span> <span
                        class="tile-peek">Clients</span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=ventes" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-pink"><i class="fa fa-tasks"></i></span> <span
                        class="tile-peek">Ventes</span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=achats" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-yellow"><i class="fa fa-tasks"></i></span> <span
                        class="tile-peek">Achats</span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=bilan" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-cyan"><i class="oi oi-document"></i></span> <span class="tile-peek">Bilan
                      </span></a>
                  </div><!-- /.dropdown-sheet-item -->
                  <!-- .dropdown-sheet-item -->
                  <div class="dropdown-sheet-item">
                    <a href="<?= RACINE; ?>views/data_pdf.php?pg=articles" target="_blank" class="tile-wrapper"><span
                        class="tile tile-lg bg-success"><i class="oi oi-document"></i></span> <span
                        class="tile-peek">Articles </span></a>
                  </div><!-- /.dropdown-sheet-item -->
                </div><!-- .dropdown-sheets -->
              </div><!-- .dropdown-menu -->
            </li><!-- /.nav-item -->


            <?php
            // var_dump($_SESSION);
            if (isAdmin()):
              $entrepots = Soutra::getAllTable('entrepot', "etat_entrepot");
              $styles = [
                ["color" => "bg-primary", "icon" => "fa fa-warehouse"],
                ["color" => "bg-success", "icon" => "fa fa-box"],
                ["color" => "bg-warning", "icon" => "fa fa-building"],
                ["color" => "bg-danger", "icon" => "fa fa-archive"],
              ];
            ?>
              <!-- .nav-item -->
              <li class="nav-item dropdown header-nav-dropdown">
                <a class="nav-link" href="#!" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                    class="bi bi-bank fa-lg"></span></a>
                <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
                <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                  <!-- .dropdown-sheets -->
                  <div class="dropdown-sheets">
                    <?php foreach ($entrepots as $index => $row):
                      $style = $styles[$index % count($styles)];
                      $isActive = ($row['ID_entrepot'] == ($_SESSION['id_entrepot'] ?? null));
                    ?>

                      <div class="dropdown-sheet-item">
                        <a href="#"
                          class="tile-wrapper entrepot-item position-relative"
                          data-id="<?= $row['ID_entrepot']; ?>">

                          <span class="tile tile-lg <?= $style['color']; ?>">
                            <i class="<?= $style['icon']; ?>"></i>
                          </span>

                          <!-- ✅ BADGE ACTIF -->
                          <?php if ($isActive): ?>
                            <span class="badge-active"></span>
                          <?php endif; ?>

                          <span class="tile-peek">
                            <?= $row['libelle_entrepot']; ?><br>
                            <small><?= $row['ville_entrepot']; ?></small>
                          </span>

                        </a>
                      </div>

                    <?php endforeach; ?>
                  </div>
                  <!-- Voir plus button a  droite de la zone des entrepots -->
                  <a href="<?= URL ?>entrepot" class="dropdown-sheets-link text-right btn btn-sm btn-primary my-2 mx-2 d-block justify-content-end">Voir plus</a>
                  <!-- .dropdown-sheets -->
                </div><!-- .dropdown-menu -->
              </li><!-- /.nav-item -->
            <?php endif; ?>

          </ul><!-- /.nav -->
        <?php endif; ?>

        <?php
        if (strtolower($_SESSION['role']) != ADMIN):
          $limit = Soutra::getStockLimitAlert();
          if (count($limit) > 0): ?>

            <ul class="header-nav nav">
              <!-- .nav-item -->
              <li class="nav-item dropdown header-nav-dropdown has-notified">
                <a class="nav-link " href="#!" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                    style="color: orange;" class="oi oi-envelope-open  pulse"> <?= count($limit); ?></span></a>
                <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
                <div class="dropdown-menu dropdown-menu-rich dropdown-menu-left">
                  <h6 class="dropdown-header stop-propagation">
                    <span>Messages Alert</span>
                  </h6><!-- .dropdown-scroll -->
                  <div class="dropdown-scroll perfect-scrollbar">



                    <?php foreach ($limit as $key => $value) { ?>

                      <!-- .dropdown-item -->
                      <a href="<?= URL; ?>approvision&id=<?= $value['article_id']; ?>" class="dropdown-item">
                        <div class="tile tile-circle bg-warning"> A </div>
                        <div class="dropdown-item-body">
                          <p class="subject"> <?= $value['libelle_article']; ?> </p>
                        </div>
                      </a> <!-- /.dropdown-item -->

                    <?php } ?>
                  </div><!-- /.dropdown-scroll -->
                </div><!-- /.dropdown-menu -->
              </li><!-- /.nav-item -->
            </ul><!-- /.nav -->
        <?php endif;
        endif; ?>



        <!-- .btn-account -->
        <div class="dropdown">
          <button class="btn-account d-none d-md-flex" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"><span class="user-avatar user-avatar-md"><img
                src="<?= ASSETS; ?>images/avatars/apple-touch-icon.png" alt=""></span> <span
              class="account-summary pr-lg-4 d-none d-lg-block"><span
                class="account-name"><?= $_SESSION['nom']; ?></span> <span
                class="account-description"><?= $_SESSION['role']; ?></span></span></button>
          <div class="dropdown-arrow dropdown-arrow-left"></div><!-- .dropdown-menu -->
          <div class="dropdown-menu">
            <h6 class="dropdown-header d-none d-md-block d-lg-none"> <?= $_SESSION['nom']; ?> </h6>
            <a class="dropdown-item" href="<?= URL; ?>profile&id=<?= $_SESSION['id_employe']; ?>">
              <span class="dropdown-icon oi oi-person"></span> Activité</a>
            <a class="dropdown-item" href="<?= URL; ?>parametre&id=<?= $_SESSION['id_employe']; ?>">
              <span class="dropdown-icon oi oi-person"></span> Profile</a>
            <?php if (strtolower($_SESSION['role']) == ADMIN): ?>

              <a class="dropdown-item" href="<?= URL; ?>configuration">
                <span class="dropdown-icon oi oi-person"></span> Configuration</a>
              <button class="dropdown-item" id="reset_db">
                <span class="dropdown-icon oi oi-database"></span> Restauration</button>
            <?php endif; ?>

            <div class="dropdown-divider"></div>
            <button class="dropdown-item btn_deconnexion" style="cursor: pointer;">
              <span class="dropdown-icon oi oi-account-logout"></span>
              Déconnexion
            </button>
          </div><!-- /.dropdown-menu -->
        </div><!-- /.btn-account -->
      </div><!-- /.top-bar-item -->
    </div><!-- /.top-bar-list -->

  </div><!-- /.top-bar -->
</header><!-- /.app-header -->