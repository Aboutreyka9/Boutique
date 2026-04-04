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
} //fin de la class
