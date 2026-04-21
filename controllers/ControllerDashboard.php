<?php

class ControllerDashboard extends Connexion
{

  // connexion utilisateur


  public static function getAllDashboardAdmin()
  {
    if (isset($_POST['dashboard_admin'])) {
      // Dates par défaut
      $start = !empty($_POST["dateStart"]) ? $_POST["dateStart"] : (new DateTime('first day of this month'))->format('Y-m-d');

      $end = !empty($_POST["dateEnd"]) ? $_POST["dateEnd"] : (new DateTime('today'))->format('Y-m-d');

      $entrepot = $_SESSION['id_entrepot'] ?? null;

      $reapprovisionnements = Soutra::getTotalReapprovisionnementValideDashboard($start, $end, $entrepot);
      $detteFournisseur = Soutra::getTotalDetteClientDashboard($start, $end,'achat',$entrepot);

      $detteClient = Soutra::getTotalDetteClientDashboard($start, $end,'vente',$entrepot);
      $ventes = Soutra::getTotalVenteValideDashboard($start, $end, $entrepot);
      $depenses = Soutra::getTotalDepenseDAshboard($start, $end, $entrepot);
      $stockDispo = Soutra::getTotauxViewStockProduit();
      $stockAlert = Soutra::getCountStockAlert();
      $totalAchatAttente = Soutra::getTotauxAchatEnAttente(); // méthode adaptée que l'on a créée
      $totalVenteAttente = Soutra::getTotauxVenteEnAttente(); // méthode adaptée que l'on a créée
      // $stockAlert = Soutra::getTotauxViewStockProduit();
// var_dump($detteClient);return;
      // $data = [
      //   "ventes" => $ventes,
      //   "reapprovisionnements" => $reapprovisionnements,
      //   "depenses" => $depenses
      // ];
      // echo json_encode($data);
      echo json_encode(compact(
        'reapprovisionnements',
        'detteClient',
        'detteFournisseur',
        'ventes',
        'depenses',
        'stockDispo',
        'stockAlert',
        'totalAchatAttente',
        'totalVenteAttente'
        ));
    }
  }
} //fin de la class
