<?php

class ControllerDepense extends Connexion
{

  // connexion utilisateur


  public static function liste_depense()
  {
    if (isset($_POST["btn_liste_depense"])) {

      // Dates par défaut
      $start = (new DateTime('first day of this month'))->format('Y-m-d');
      $end = (new DateTime('today'))->format('Y-m-d');

      $depenses = Soutra::getAllListeDepenses($start, $end, $_SESSION['id_entrepot']);

      $output = "";
      $i = 0;
      foreach ($depenses as $row) {
        ++$i;
        $output .= '
                <tr class="row' . $row['ID_depense'] . '">
                  <td>' . $i . '</td>
                  <td>' . $row['libelle_type'] . '</td>
                  <td>' . Soutra::date_format($row['periode']) . '</td>
                  <td>' . checkStatusDepense($row['statut_depense']) . '</td>
                  <td>' . number_format($row['montant'], 0, ',', ' ') . '</td>
                  <td>' . $row['employe'] . '</td>
                  <td>' . Soutra::date_format($row['date_created']) . '</td>
                  <td class="form-button-action"> ';

        // btn Valider la deSTATUT_DEPENSE
        $output .= '<button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm btn_confirmer_depense " data-original-title="Voir details depense"> <i class="fa fa-eye text-icon-primary"></i> </button>';

        // btn Valider la deSTATUT_DEPENSE
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
          $output .= '<button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm btn_confirmer_depense " data-original-title="Approuver la depense"> <i class="fa fa-check text-icon-success"></i> </button>';
        endif;

        // btn Valider la commande
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
          $output .= '<button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-sm btn_update_depense " data-original-title="Modifier depense"> <i class="fa fa-edit text-icon-info"></i> </button>';
        endif;

        // btn Valider la deSTATUT_DEPENSE
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
          $output .= ' <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm btn_remove_depense " data-original-title="Annulé la depense"> <i class="fa fa-times text-icon-danger"></i> </button>
                                        ';
        endif;

        $output . '</td>
        </tr>';
      }
      echo $output;
    }
  }

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
