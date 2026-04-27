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

      $reapprovisionnements = (isGestionnaire()) ? Soutra::getTotalReapprovisionnementValideDashboardNotAdmin($start, $end, $entrepot) : Soutra::getTotalReapprovisionnementValideDashboardAdmin($start, $end, $entrepot);

      $ventes = (isGestionnaireCommercial()) ? Soutra::getTotalVenteValideDashboardNotAdmin($start, $end, $entrepot) : Soutra::getTotalVenteValideDashboardAdmin($start, $end, $entrepot);

      $detteFournisseur = Soutra::getTotalDetteFournisseurDashboard($start, $end, 'achat', $entrepot);

      $detteClient = Soutra::getTotalDetteClientDashboard($start, $end, 'vente', $entrepot);

      $depenses = Soutra::getTotalDepenseDAshboard($start, $end, $entrepot);

      $stockDispo = Soutra::getTotauxViewStockProduit();

      $stockAlert = Soutra::getCountStockAlert();

      $totalAchatAttente = Soutra::getTotauxAchatEnAttente(); // méthode adaptée que l'on a créée

      $totalVenteAttente = (isGestionnaireCommercial()) ? Soutra::getTotauxVenteEnAttenteNotAdmin() : Soutra::getTotauxVenteEnAttenteAdmin(); // méthode adaptée que l'on a créée

      $tresorerie = Soutra::getTotauxTresorerie(); // méthode adaptée que l'on a créée

      $reliquat  = Soutra::getTotalDetteClientDashboard($start, $end, 'achat', $entrepot);

      $totauxAchat = Soutra::getTotauxAchatByDateRange($start, $end); // méthode adaptée que l'on a créée

      // ajout propre dans le même objet
      $totauxAchat['total_montant_regler'] = (int)$totauxAchat['total'] - (int)$reliquat['montant_total'];
      // var_dump($totauxAchat,$reliquat);return;
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
        'totalVenteAttente',
        'tresorerie',
        'totauxAchat',
        'reliquat'
      ));
    }
  }
} //fin de la class
