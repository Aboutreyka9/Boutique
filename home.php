<?php if (session_status() == PHP_SESSION_NONE)
  session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Africa/Abidjan');
// setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
// date_default_timezone_set('Africa/Abidjan');

if (!isset($_SESSION) || empty($_SESSION)) {
  header('location:/');
}

if ($_SERVER['REQUEST_URI'] == "/home.php") {
  header("LOCATION:home.php/");
}

?>
<?php include './config/const.php' ?>
<?php include './config/helpers.php' ?>
<?php include './config/action.php' ?>
<?php include './models/Connexion.php' ?>
<?php include './controllers/Soutra.php' ?>
<?php include './controllers/ControllerEmploye.php' ?>
<?php include './controllers/ControllerClient.php' ?>
<?php include './controllers/ControllerFournisseur.php' ?>
<?php include './controllers/ControllerCategorie.php' ?>
<?php include './controllers/ControllerFamille.php' ?>
<?php include './controllers/ControllerMark.php' ?>
<?php include './controllers/ControllerUnite.php' ?>
<?php include './controllers/ControllerArticle.php' ?>
<?php include './controllers/ControllerAchat.php' ?>
<?php include './controllers/ControllerVente.php' ?>
<?php include './controllers/ControllerCommande.php' ?>
<?php include './controllers/ControllerConfig.php' ?>
<?php include './controllers/ControllerPrinter.php' ?>

<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from uselooper.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:18:28 GMT -->
<?php include './partials/header.php' ?>

<body>
  <!-- .app -->
  <div class="app">
    <!--[if lt IE 10]>
      <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
      <![endif]-->
    <!-- .app-header -->
    <?php include './partials/nav.php' ?>
    <!-- .app-aside -->
    <?php include './partials/sidebar.php' ?>

    <!-- .app-main -->
    <main style="background-color: #e4e6ec !important;" class="app-main">

      <!-- .wrapper -->
      <div class="wrapper">
        <!-- .page -->
        <div class="page">
          <!-- .page-inner -->
          <div class="page-inner">

            <!-- .page-title-bar -->
            <?php include './content.php' ?>
          </div><!-- /.page-inner -->
        </div><!-- /.page -->
      </div><!-- .app-footer -->
      <?php include './partials/footer.php' ?>

      <!-- /.wrapper -->
    </main><!-- /.app-main -->
  </div><!-- /.app -->
  <!-- BEGIN BASE JS -->
  <?php include './partials/scripte.php' ?>
</body>

<!-- Mirrored from uselooper.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:19:30 GMT -->

</html>