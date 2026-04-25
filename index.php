<?php
// session_destroy();
if (session_status() == PHP_SESSION_NONE) {
  session_start();
  //var_dump(md5(123));
}

include './config/const.php';

if (isset($_SESSION) && !empty($_SESSION)) {
  header('location:' . URL . 'dashbord');
}


?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uselooper.com/auth-signin-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:21:02 GMT -->

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
  <!-- Begin SEO tag -->
  <title> Connexion page </title>
  <meta property="og:title" content="Sign In">
  <meta name="author" content="Beni Arisandi">
  <meta property="og:locale" content="en_US">
  <meta name="description" content="Responsive admin theme build on top of Bootstrap 4">
  <meta property="og:description" content="Responsive admin theme build on top of Bootstrap 4">
  <link rel="canonical" href="index.html">
  <meta property="og:url" content="index.html">
  <meta property="og:site_name" content="Looper - Bootstrap 4 Admin Theme">

  <!-- Favicons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/apple-touch-icon.png">
  <link rel="shortcut icon" href="assets/favicon.ico">
  <meta name="theme-color" content="#3063A0"><!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End Google font -->
  <!-- BEGIN PLUGINS STYLES -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.css"><!-- END PLUGINS STYLES -->
  <!-- BEGIN THEME STYLES -->
  <link rel="stylesheet" href="assets/stylesheets/theme.min.css" data-skin="default">
  <link rel="stylesheet" href="assets/stylesheets/theme-dark.min.css" data-skin="dark">
  <link rel="stylesheet" href="assets/stylesheets/custom.css"><!-- Disable unused skin immediately -->
  <script>
    var skin = localStorage.getItem('skin') || 'default';
    var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');

    unusedLink.setAttribute('rel', '');
    unusedLink.setAttribute('disabled', true);
  </script><!-- END THEME STYLES -->
  <style>
    .module-info {
      font-size: 20px;
      font-weight: 800;
      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, 'sans-serif';
    }

    #togglePasswordIcon {
      font-size: 20px;
      font-weight: 800;
      color: #777070FF;
      cursor: pointer;

    }

    /* Amélioration mobile */
    @media (max-width: 768px) {
      .auth {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
      }

      .auth-form {
        width: 100% !important;
        max-width: 100%;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        background: #fff;
        border-radius: 10px;
        z-index: 2;
      }

      .auth-announcement {
        margin-top: 20px;
        padding: 10px;
        background-size: cover !important;
        background-position: center;
        border-radius: 8px;
        text-align: center;
      }

      .announcement-title {
        font-size: 18px;
        text-align: center;
        padding: 5px;
      }

      .module-info {
        font-size: 14px;
        font-weight: 600;
        text-align: left;
        margin-bottom: 5px;
      }

      .announcement-body {
        padding: 10px !important;
        margin: 0 auto;
        max-width: 95%;
      }
    }
  </style>
</head>

<body>
  <!--[if lt IE 10]>
    <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
    <![endif]-->
  <!-- .auth -->
  <main class="auth auth-floated">
    <!-- form -->
    <form method="post" action="" id="frm_conexion" class="auth-form" accept-charset="UTF-8">
      <div class="mb-4">
        <div class="mb-3">
          <img class="rounded" src="assets/apple-touch-icon.png" alt="" height="72">
        </div>
        <h1 class="h3"> Espace connexion </h1>
      </div>
      <p class="mb-4"> Renseignez vos coordonnés pour acceder a plus de Fonctionnalités.
        <!-- Don't have a account? <a href="auth-signup.html">Create One</a> -->
      </p><!-- .form-group -->
      <div class="form-group mb-4">
        <label class="d-block text-left" for="telephone">Telephone <i class="fa fa-phone"></i></label>
        <input type="text" name="telephone" placeholder="Ex:0566015412" id="telephone" class="form-control form-control-lg" autofocus="">
      </div><!-- /.form-group -->
      <input type="hidden" name="btn_connexion" id="btn_connexion" class="form-control form-control-lg">

      <!-- .form-group -->
      <div class="form-group mb-4">
        <label class="d-block text-left" for="password">Mot de passe <i class="fa fa-lock"></i></label>
        <div class="input-group">
          <!-- <span><i class="fa fa-lock t-eye"></i></span> -->
          <input type="password" name="password" placeholder="..........." id="password" class="form-control form-control-lg">
          <span onclick="togglePassword()"><i class="fa fa-eye mt-2 mr-2" id="togglePasswordIcon"></i></span>
        </div>
      </div><!-- /.form-group -->

      <!-- .form-group -->
      <div class="form-group mb-4">
        <button class="btn btn-lg btn-danger btn-block btn_connexion" type="submit">Se connecter</button>
      </div><!-- /.form-group -->
      <!-- .form-group -->
      <div class="form-group text-center">
        <div class="custom-control custom-control-inline custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="remember-me"> <label class="custom-control-label" for="remember-me">Se souvenir</label>
        </div>
      </div><!-- /.form-group -->
      <!-- recovery links -->
      <p class="py-2">
        <!-- <a href="auth-recovery-username.html" class="link">Forgot Username?</a> <span class="mx-2">·</span> <a href="auth-recovery-password.html" class="link">Forgot Password?</a> -->
      </p><!-- /recovery links -->
      <!-- copyright -->
      <p class="mb-0 px-3 text-muted text-center"> © 2022 tous droit reservés SMART-CODE. Conception et deployement des solutions informatique <a href="#!">Privacy</a> and <a href="#!">Terms</a>
      </p>
    </form><!-- /.auth-form -->
    <!-- .auth-announcement -->
    <section id="announcement" class="auth-announcement" style="background-image: url(assets/images/illustration/img-1.png);">
      <div style="background: rgba(0, 0, 0, 0.4); border-radius: 1%;" class="announcement-body text-left py-3">
        <h2 class="announcement-title ml-5 pl-4"> Les fonctionnalités interne du logiciel </h2>
        <ul class="ml-5 pl-5">
          <li class="module-info">Gestion fournisseurs</li>
          <li class="module-info">Gestion clients</li>
          <li class="module-info">Gestion d'achats & ventes</li>
          <li class="module-info">Gestion de stocks</li>
          <li class="module-info">Gestion de factures</li>
          <li class="module-info">comptabilité</li>
          <li class="module-info">Multi-utilisateur</li>
          <li class="module-info">Sauvegarde des données (Excel,PDF)</li>

        </ul>
      </div>
    </section><!-- /.auth-announcement -->
  </main><!-- /.auth -->
  <!-- BEGIN BASE JS -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/popper.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script> <!-- END BASE JS -->
  <!-- BEGIN PLUGINS JS -->
  <script src="assets/vendor/particles.js/particles.min.js"></script>
  <script src="<?= ASSETS; ?>swal/sweetalert.min.js"></script> <!-- END THEME JS -->

  <script>
    /**
     * Keep in mind that your scripts may not always be executed after the theme is completely ready,
     * you might need to observe the `theme:load` event to make sure your scripts are executed after the theme is ready.
     */
    $(document).on('theme:init', () => {
      /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
      particlesJS.load('announcement', 'assets/javascript/pages/particles.json');
    })
  </script> <!-- END PLUGINS JS -->
  <!-- BEGIN THEME JS -->
  <script src="assets/javascript/theme.min.js"></script> <!-- END THEME JS -->
  <!-- <script src="assets/javascript/app.js"></script> END THEME JS -->
  <!-- <script src="assets/javascript/app.js"></script> END THEME JS -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116692175-1"></script>
  <script>
    function togglePassword() {
      var passwordField = document.getElementById("password");
      var toggleIcon = document.getElementById("togglePasswordIcon");
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
      }
    }
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-116692175-1');
  </script>
  <script>
    $(function() {

      login_employe()

      function login_employe() {
        $('body').delegate('#frm_conexion', 'submit', function(e) {
          e.preventDefault();
          var employe = $(this).serialize();
          $.ajax({
            url: "./partials/rooter.php",
            method: "POST",
            data: employe,
            dataType: "JSON",
            beforeSend: function() {
              $('.btn_connexion').attr('disabled', 'disabled');
              $('.btn_connexion').html('<i class="fa fa-spinner fa-spin"></i> En cours...');
            },
            success: function(data) {
              // console.log(data);
              $('.btn_connexion').removeAttr('disabled');
              $('.btn_connexion').html('Se connecter');
              // var verif = data.split("&");

              console.log(data);
              if (data.code == 200) {
                document.location.href = "home.php/?pg=dashbord";
              } else {
                // console.log(data);

                swal({
                  title: "Alert",
                  text: data.message,
                  icon: 'warning',
                  button: true,

                });
                //  notify(data,"","Alert",'warning');
              }

            }
          });

        });

      }

    });
  </script>

</body>

<!-- Mirrored from uselooper.com/auth-signin-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Dec 2018 11:21:02 GMT -->

</html>