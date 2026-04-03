<?php

function isActive(string $page = '')
{
  $active = '';
  $urlbrute = $_SERVER['QUERY_STRING'];

  if (!empty($urlbrute)) {
    $urlSemi = explode('=', $urlbrute)[1];
    $url = explode('&', $urlSemi)[0];
    $pg = $url;
    $active = ($url == $page) ? 'has-active' : '';
  }

  return $active;
}

function pages()
{
  $urlbrute = $_SERVER['QUERY_STRING'];

  if (!empty($urlbrute)) {
    $urlSemi = explode('=', $urlbrute)[1];
    $url = explode('&', $urlSemi)[0];
  }

  return $url;
}

function notAdmin()
{
  if (isset($_SESSION['role']) && strtolower($_SESSION['role']) != ADMIN) {
    include 'views/not_found.php';

    return true;
    // die();
    //  return 'HTTP /1.0 404 not found';
    //  header('HTTP 1.0 404 not found');
  }
}

function notAccessPage($val)
{
  if ($val) {
    include 'views/not_found.php';

    return true;
    // die();
    //  return 'HTTP /1.0 404 not found';
    //  header('HTTP 1.0 404 not found');
  }
}

function checkStatusCommande(string $etat, array $data = STATUT_COMMANDE)
{
  $result = "";
  switch ($etat) {
    case $data[0]:
      $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . $data[0] . '</span>';
      break;
    case $data[1]:
      $result = '<span class="badge badge-statut statut-info"><span class="dot"></span> ' . $data[1] . '</span>';
      break;
    case $data[2]:
      $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . $data[2] . '</span>';
      break;
    case $data[3]:
      $result = '<span class="badge badge-statut statut-default"><span class="dot"></span> ' . $data[3] . '</span>';
      break;
    case $data[4]:
      $result = '<span class="badge badge-statut statut-danger"><span class="dot"></span> ' . $data[4] . '</span>';
      break;
    default:
      $result = '';
      break;
  }


  return $result;
}
