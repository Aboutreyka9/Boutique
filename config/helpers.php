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

function mergeArticlesCommande($articleSaved, $addedArticle)
{
  $result = [];

  // Injecter les  avec qte par défaut
  foreach ($articleSaved as $a) {
    $result[$a['ID_article']] = [
      "ID_article" => $a['ID_article'],
      "libelle_article" => $a['libelle_article'],
      "famille" => $a['famille'],
      "mark" => $a['mark'],
      "prix_achat" => $a['prix_achat'],
      "qte" => $a['qte'],
      "total_ttc" => $a['total_ttc']
      // "prix_achat" => $a['prix_achat'],
      // "qte" => 0
    ];
  }

  // Fusion avec le addedArticle
  foreach ($addedArticle as $s) {
    if (!isset($result[$s['ID_article']])) {
      // $result[$s['ID_article']]['qte'] = $s['qte'];
      // } else {
      // Cas où l'article existe seulement dans stock
      $result[$s['ID_article']] = [
        "ID_article" => $s['ID_article'],
        "libelle_article" => $s['libelle_article'],
        "famille" => $s['famille'],
        "mark" => $s['mark'],
        "prix_achat" => $s['prix_achat'],
        "qte" => 0,
        "total_ttc" => 0
        // "prix_achat" => $s['prix_achat'],
        // "qte" => $s['qte']
      ];
    }
  }

  // Optionnel : réindexer proprement (0,1,2…)
  return array_values($result);
}

function mergeByKeyArticlesCommande($arrayFull, $arrayPartial, $fieldsMap = [])
{
  $result = [];

  // champs configurables
  $priceField = $fieldsMap[0];
  $qtyField = $fieldsMap[1];
  // $priceField = $fieldsMap['price'] ?? 'prix_achat';
  // $qtyField  = $fieldsMap['qte'] ?? 'qte';

  // 1. Injecter arrayFull
  foreach ($arrayFull as $item) {
    $key = $item['ID_article'];

    $result[$key] = [
      "ID_article" => $item['ID_article'],
      "libelle_article" => $item['libelle_article'],
      "famille" => $item['famille'],
      "mark" => $item['mark'],
      $priceField => $item[$priceField] ?? null,
      $qtyField => 0
    ];
  }

  // 2. Fusion avec arrayPartial
  foreach ($arrayPartial as $item) {
    $key = $item['ID_article'];

    if (isset($result[$key])) {
      $result[$key][$qtyField] = $item[$qtyField] ?? 0;
    } else {
      $result[$key] = [
        "ID_article" => $item['ID_article'],
        "libelle_article" => $item['libelle_article'],
        "famille" => $item['famille'],
        "mark" => $item['mark'],
        $priceField => $item[$priceField] ?? null,
        $qtyField => $item[$qtyField] ?? 0
      ];
    }
  }

  return array_values($result);
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
function checkEtat(string $status, array $data = ETATS)
{
  $result = "";
  switch ($status) {
    case $data[0]:
      $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . 'En attente' . '</span>';
      break;
    case $data[1]:
      $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . 'confirmé' . '</span>';
      break;
    default:
      $result = 1;
      break;
  }


  return $result;
}


function checkEtatData(string $status, array $data = ETATS)
{
  $result = "";
  switch ($status) {
    case $data[0]:
      $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> inactif </span>';
      break;
    case $data[1]:
      $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> actif </span>';
      break;
    default:
      $result = 1;
      break;
  }


  return $result;
}


function checkStatusDepense(string $etat, array $data = STATUT_DEPENSE)
{
  $result = "";
  switch ($etat) {
    case $data[0]:
      $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . $data[0] . '</span>';
      break;
    case $data[1]:
      $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . $data[1] . '</span>';
      break;
    case $data[2]:
      $result = '<span class="badge badge-statut statut-danger"><span class="dot"></span> ' . $data[2] . '</span>';
      break;
    default:
      $result = '';
      break;
  }


  return $result;
}
