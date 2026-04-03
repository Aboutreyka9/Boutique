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

      $entrepot = $_SESSION['entrepot'] ?? null;

      $reapprovisionnements = Soutra::getTotalReapprovisionnementDashboard($start, $end, $entrepot);
      $ventes = Soutra::getTotalVenteDashboard($start, $end, $entrepot);

      $data = [
        "ventes" => $ventes,
        "reapprovisionnements" => $reapprovisionnements
      ];
      echo json_encode($data);
    }
  }
} //fin de la class
