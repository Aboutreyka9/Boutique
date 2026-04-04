<?php

class ControllerDepense extends Connexion
{

  // connexion utilisateur


  public static function ajouter_depense()
  {
    if (isset($_POST['btn_ajouter_depense'])) {
      $msg['code'] = 400;
      $msg['message'] = "";
      extract($_POST);
      if (!empty($type_id) && !empty($entrepot_id) && !empty($montant) && !empty($periode) && !empty($description)) {
        if (is_numeric($montant)) {
          // TODO: Enregistrer la dépense dans la base de données
          $data = [
            'type_id' => $type_id,
            'entrepot_id' => $entrepot_id,
            'montant' => $montant,
            'periode' => $periode,
            'description' => $description,
            'date_created' => date('Y-m-d H:i:s'),
            'employe_id' => $_SESSION['id_employe'],
            'etat_depense' => 0,
            'statut_depense' => STATUT_DEPENSE[0],
          ];

          if (Soutra::inserted('depense', $data)) {
            $msg['code'] = 200;
            $msg['message'] = "Depense enregistée avec succès!";
          } else {
            $msg['message'] = "Une erreur est survenue lors du traitement";
          }
        } else {
          $msg['message'] = "Montant invalide";
        }
      } else {
        $msg['message'] = "Veuillez renseigner tous les champs";
      }
      echo json_encode($msg);
    }
  }


  public static function getDataDateRangeFilterDepense()
  {
    if (isset($_POST['btn_filter_depense'])) {
      extract($_POST);
      $dateDebut = $_POST['dateDebut'] ?? null;
      $dateFin = $_POST['dateFin'] ?? null;

      $depense_annule = Soutra::getTotalDepenseAny($dateDebut, $dateFin, STATUT_DEPENSE[2]); // méthode adaptée que l'on a créée
      $depense_en_attente = Soutra::getTotalDepenseAny($dateDebut, $dateFin, STATUT_DEPENSE[0]); // méthode adaptée que l'on a créée
      $depense_approuve = Soutra::getTotalDepenseAny($dateDebut, $dateFin, STATUT_DEPENSE[1]); // 


      echo json_encode(compact('depense_annule', 'depense_en_attente', 'depense_approuve'));
    }
  }
} //fin de la class
