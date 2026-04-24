<?php
if (session_status() == PHP_SESSION_NONE)
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
// if(isset($_SESSION) && !empty($_SESSION)) {
//   $_SESSION['id_entrepot'] = 6;
// }
// var_dump($_SESSION);return;

?>
<?php include_once './config/const.php' ?>
<?php include_once './config/helpers.php' ?>
<?php include_once './config/action.php' ?>
<?php include_once './models/Connexion.php' ?>
<?php include_once './controllers/Soutra.php' ?>
<?php include_once './controllers/ControllerEmploye.php' ?>
<?php include_once './controllers/ControllerClient.php' ?>
<?php include_once './controllers/ControllerFournisseur.php' ?>
<?php include_once './controllers/ControllerCategorie.php' ?>
<?php include_once './controllers/ControllerFamille.php' ?>
<?php include_once './controllers/ControllerMark.php' ?>
<?php include_once './controllers/ControllerUnite.php' ?>
<?php include_once './controllers/ControllerArticle.php' ?>
<?php include_once './controllers/ControllerAchat.php' ?>
<?php include_once './controllers/ControllerVente.php' ?>
<?php include_once './controllers/ControllerCommande.php' ?>
<?php include_once './controllers/ControllerConfig.php' ?>
<?php include_once './controllers/ControllerPrinter.php' ?>
<?php include_once './controllers/ControllerMailer.php' ?>

<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from uselooper.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:18:28 GMT -->
<?php include_once './partials/header.php' ?>

<body>
  <!-- .app -->
  <div class="app">
    <!--[if lt IE 10]>
      <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
      <![endif]-->
    <!-- .app-header -->
    <?php include_once './partials/nav.php' ?>
    <!-- .app-aside -->
    <?php include_once './partials/sidebar.php' ?>

    <!-- .app-main -->
    <main style="background-color: #e4e6ec !important;" class="app-main">

      <!-- .wrapper -->
      <div class="wrapper">
        <!-- .page -->
        <div class="page">
          <!-- .page-inner -->
          <div class="page-inner">

            <!-- .page-title-bar -->
            <?php include_once './content.php' ?>
          </div><!-- /.page-inner -->
        </div><!-- /.page -->
      </div><!-- .app-footer -->
      <?php include_once './partials/footer.php' ?>

      <!-- /.wrapper -->
    </main><!-- /.app-main -->
  </div><!-- /.app -->
  <!-- BEGIN BASE JS -->
  <?php include_once './partials/scripte.php' ?>
</body>

<!-- Mirrored from uselooper.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:19:30 GMT -->

</html>