<aside class="app-aside app-aside-expand-md app-aside-light">
  <!-- .aside-content -->
  <div class="aside-content">
    <!-- .aside-header -->
    <header class="aside-header d-block d-md-none">
      <!-- .btn-account -->
      <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside">
        <span class="user-avatar user-avatar-lg"><img src="<?= ASSETS; ?>images/avatars/apple-touch-icon.png" alt=""></span>
        <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span>
        <span class="account-summary"><span class="account-name"><?= $_SESSION['nom']; ?></span>
          <span class="account-description"><?= $_SESSION['role']; ?></span></span>
      </button> <!-- /.btn-account -->
      <!-- .dropdown-aside -->
      <div id="dropdown-aside" class="dropdown-aside collapse">
        <!-- dropdown-items -->
        <div class="pb-3">
          <a class="dropdown-item" href="<?= URL; ?>profile&id=<?= $_SESSION['id_employe']; ?>">
            <span class="dropdown-icon oi oi-person"></span>
            Activité
          </a>
          <a class="dropdown-item" href="<?= URL; ?>parametre&id=<?= $_SESSION['id_employe']; ?>">
            <span class="dropdown-icon oi oi-person"></span>
            Profile
          </a>
          <?php if (strtolower($_SESSION['role']) == ADMIN): ?>
            <a class="dropdown-item" href="<?= URL; ?>configuration">
              <span class="dropdown-icon oi oi-person"></span>
              Configuration
            </a>
          <?php endif; ?>

          <div class="dropdown-divider"></div>

          <button class="dropdown-item btn_deconnexion">
            <span class="dropdown-icon oi oi-account-logout"></span>
            Deconnexion
          </button>
        </div><!-- /dropdown-items -->
      </div><!-- /.dropdown-aside -->
    </header><!-- /.aside-header -->
    <!-- .aside-menu -->
    <section class="aside-menu overflow-hidden">
      <!-- .stacked-menu -->
      <nav id="stacked-menu" class="stacked-menu">
        <!-- .menu -->
        <ul class="menu">
          <!-- .menu-item -->
          <li class="menu-item <?= isActive('') == '' ? 'has-active' : ''; ?> <?= isActive('dashbord'); ?>">
            <a href="<?= RACINE; ?>" class="menu-link"><span class="menu-icon fa fa-home"></span> <span class="menu-text">Dashboard</span></a>
          </li><!-- /.menu-item -->

          <?php if (strtolower($_SESSION['role']) == ADMIN): ?>
            <!-- SI ADMINTRATEUR -->

            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('employe'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span> <span class="menu-text">Employé</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('employe'); ?>">
                  <a href="<?= URL; ?>employe" class="menu-link">Liste employés </a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <?php if (Soutra::getState('fournisseur') == 1) { ?>
              <!-- .menu-item -->
              <li class="menu-item has-child  <?= isActive('fournisseur'); ?>">
                <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span> <span class="menu-text">Fourniseur</span></a> <!-- child menu -->
                <ul class="menu">
                  <li class="menu-item <?= isActive('fournisseur'); ?>">
                    <a href="<?= URL; ?>fournisseur" class="menu-link">Liste fournisseur</a>
                  </li>
                </ul><!-- /child menu -->
              </li><!-- /.menu-item -->
            <?php } ?>

            <?php if (Soutra::getState('client') == 1) { ?>
              <!-- .menu-item -->
              <li class="menu-item has-child <?= isActive('client'); ?>">
                <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span> <span class="menu-text">Client</span>
                  <?php $cl = Soutra::getCountNew('client');
                  if ($cl > 0) : ?>
                    <span class="badge badge-subtle badge-success">
                      +<?= $cl; ?>
                    </span>
                  <?php endif; ?>
                </a> <!-- child menu -->
                <ul class="menu">
                  <li class="menu-item <?= isActive('client'); ?>">
                    <a href="<?= URL; ?>client" class="menu-link">Liste clients</a>
                  </li>
                </ul><!-- /child menu -->
              </li><!-- /.menu-item -->
            <?php } ?>
            <div class="dropdown-divider"></div>

            <!-- .menu-header -->
            <li class="menu-header">Stock </li><!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('achat'); ?> <?= isActive('ajouter_achat'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-puzzle-piece"></span> <span class="menu-text">Approvisionner</span>
                <?php $cl = Soutra::getCountNew('achat');
                if ($cl > 0) : ?>
                  <span class="badge badge-subtle badge-success">
                    +<?= $cl; ?>
                  </span>
                <?php endif; ?>
              </a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('achat'); ?>">
                  <a href="<?= URL; ?>achat" class="menu-link">Liste achat</a>
                </li>
                <li class="menu-item <?= isActive('ajouter_achat'); ?>">
                  <a href="<?= URL; ?>ajouter_achat" class="menu-link">Ajouter achat</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item has-child  <?= isActive('vente'); ?> <?= isActive('ajouter_vente'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Vente</span>
                <?php $cl = Soutra::getCountNew('vente');
                if ($cl > 0) : ?>
                  <span class="badge badge-subtle badge-success">
                    +<?= $cl; ?>
                  </span>
                <?php endif; ?>
              </a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item  <?= isActive('vente'); ?>">
                  <a href="<?= URL; ?>vente" class="menu-link">liste ventes</a>
                </li>
                <li class="menu-item  <?= isActive('ajouter_vente'); ?>">
                  <a href="<?= URL; ?>ajouter_vente" class="menu-link">Ajouter vente</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->

            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('retour'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Retour</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('retour'); ?>">
                  <a href="<?= URL; ?>retour" class="menu-link"> Detail</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->

            <!-- .menu-item -->
            <!-- <li class="menu-item has-child <?= isActive('correction'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Correction</span></a> 
              <ul class="menu">
                <li class="menu-item <?= isActive('correction'); ?>">
                  <a href="<?= URL; ?>correction" class="menu-link"> Liste</a>
                </li>
              </ul>
            </li> -->
            <!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('audit'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon  oi oi-pencil"></span> <span class="menu-text">Audit stock</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item  <?= isActive('audit'); ?>">
                  <a href="<?= URL; ?>audit" class="menu-link">Voir</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <div class="dropdown-divider"></div>

            <!--comptabilite supprimé-->

            <!-- .menu-item -->
            <li class="menu-header">Comptabilité </li><!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item has-child  <?= isActive('depense'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Depense</span>

              </a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item  <?= isActive('depense'); ?>">
                  <a href="<?= URL; ?>depense" class="menu-link">liste depenses</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('inventaire'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon fa fa-table"></span> <span class="menu-text">Inventaire</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item  <?= isActive('inventaire'); ?>">
                  <a href="<?= URL; ?>inventaire" class="menu-link">liste</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <!-- .menu-item -->
            <!-- .menu-header -->
            <li class="menu-header">produit </li><!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('categorie'); ?> <?= isActive('mark'); ?> <?= isActive('famille'); ?> <?= isActive('unite'); ?> <?= isActive('article'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Catalogue article</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('categorie'); ?>">
                  <a href="<?= URL; ?>categorie" class="menu-link">liste categories</a>
                </li>
                <li class="menu-item <?= isActive('mark'); ?>">
                  <a href="<?= URL; ?>mark" class="menu-link">liste marks</a>
                </li>
                <li class="menu-item <?= isActive('famille'); ?>">
                  <a href="<?= URL; ?>famille" class="menu-link">liste familles</a>
                </li>
                <li class="menu-item <?= isActive('unite'); ?>">
                  <a href="<?= URL; ?>unite" class="menu-link">liste unites</a>
                </li>
                <li class="menu-item <?= isActive('article'); ?>">
                  <a href="<?= URL; ?>article" class="menu-link">liste produits</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->

            <div class="dropdown-divider">Configuration</div>
            <!-- .menu-item -->
            <li class="menu-item has-child  <?= isActive('entrepot'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Entrepot</span>

              </a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item  <?= isActive('entrepot'); ?>">
                  <a href="<?= URL; ?>entrepot" class="menu-link">liste entrepots</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-header">Archive </li><!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item has-child">
              <a href="#" class="menu-link"><span class="menu-icon fa fa-trash"></span> <span class="menu-text">Corbeille</span></a> <!-- child menu -->
              <ul class="menu">
                <!-- <li class="menu-item">
                      <a href="<?= URL; ?>arc_emplye" class="menu-link">Employe</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_fournisseur" class="menu-link">Fourniseur</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_client" class="menu-link">Client</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_categorie" class="menu-link">Categorie</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_mark" class="menu-link">Mark</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_famille" class="menu-link">Famille</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_article" class="menu-link">Article</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_achat" class="menu-link">Achat</a>
                    </li>
                    <li class="menu-item">
                      <a href="<?= URL; ?>arc_vente" class="menu-link">Vente</a>
                    </li>-->
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->

          <?php else: ?>
            <!-- SINON AUTRE EMPLOYE -->

            <?php if (Soutra::getState('client') == 1) : ?>

              <li class="menu-header">Gestion </li><!-- /.menu-header -->

              <!-- .menu-item -->
              <li class="menu-item has-child <?= isActive('client'); ?>">
                <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span> <span class="menu-text">Client</span>
                  <?php $cl = Soutra::getCountNew('client');
                  if ($cl > 0) : ?>
                    <span class="badge badge-subtle badge-success">
                      +<?= $cl; ?>
                    </span>
                  <?php endif; ?>
                </a> <!-- child menu -->
                <ul class="menu">
                  <li class="menu-item <?= isActive('client'); ?>">
                    <a href="<?= URL; ?>client" class="menu-link">Liste clients</a>
                  </li>
                </ul><!-- /child menu -->
              </li><!-- /.menu-item -->
            <?php endif; ?>

            <li class="menu-header">Stock </li><!-- /.menu-header -->

            <li class="menu-item has-child <?= isActive('vente'); ?> <?= isActive('ajouter_vente'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Vente</span>
                <?php $cl = Soutra::getCountNew('vente');
                if ($cl > 0) : ?>
                  <span class="badge badge-subtle badge-success">
                    +<?= $cl; ?>
                  </span>
                <?php endif; ?>
              </a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('vente'); ?>">
                  <a href="<?= URL; ?>vente" class="menu-link">liste vente</a>
                </li>
                <li class="menu-item <?= isActive('ajouter_vente'); ?>">
                  <a href="<?= URL; ?>ajouter_vente" class="menu-link">Ajouter vente</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item has-child <?= isActive('retour'); ?>">
              <a href="#" class="menu-link"><span class="menu-icon oi oi-pencil"></span> <span class="menu-text">Retour</span></a> <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?= isActive('retour'); ?>">
                  <a href="<?= URL; ?>retour" class="menu-link"> Detail</a>
                </li>
              </ul><!-- /child menu -->
            </li><!-- /.menu-item -->


          <?php endif; ?>
          <!-- .menu-item -->
        </ul><!-- /.menu -->
      </nav><!-- /.stacked-menu -->
    </section><!-- /.aside-menu -->

  </div><!-- /.aside-content -->
</aside><!-- /.app-aside -->