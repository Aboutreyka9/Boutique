<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
  <!-- Begin SEO tag -->
  <title> Boutique </title>
  <meta name="author" content="Smart codes">

  <!-- FAVICONS -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= ASSETS ?>apple-touch-icon.png">
  <link rel="shortcut icon" href="<?= ASSETS ?>favicon.ico">
  <meta name="theme-color" content="#3063A0"><!-- End FAVICONS -->
  <!-- GOOGLE FONT -->
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
  <!-- BEGIN PLUGINS STYLES -->
  <link rel="stylesheet" href="<?= ASSETS ?>vendor/open-iconic/css/open-iconic-bootstrap.min.css">

  <link rel="stylesheet" href="<?= ASSETS ?>vendor/fontawesome/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= ASSETS ?>vendor/flatpickr/flatpickr.min.css"><!-- END PLUGINS STYLES -->
  <!-- BEGIN THEME STYLES -->

  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/theme.min.css" data-skin="default">
  <link rel="stylesheet" href="<?= ASSETS ?>vendor/select2/css/select2.min.css">


  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/theme-dark.min.css" data-skin="dark">

  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/custom.css"><!-- Disable unused skin immediately -->
  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/datatable.css">
  <!-- DATE RANGER-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/app.css">
  <link rel="stylesheet" href="<?= ASSETS ?>stylesheets/responsive-style.css">

  <script>
    var skin = localStorage.getItem('skin') || 'default';
    var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');

    unusedLink.setAttribute('rel', '');
    unusedLink.setAttribute('disabled', true);
  </script><!-- END THEME STYLES -->
</head>