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
        $output .= '
                <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-sm btn_confirmer_depense " data-original-title="Voir details depense"> <i class="fa fa-eye text-icon-primary"></i> </button>
                ';

        // btn Valider la deSTATUT_DEPENSE
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
            $output .= '
                <button type="button"  
                id="btn_validation_depense"
                onclick="updateELementDepense(this,\'' . $row['ID_depense'] . '\')"
                data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm btn_confirmer_depense " data-original-title="Approuver la depense"> <i class="fa fa-check text-icon-success"></i> </button>
                ';
        endif;

        // btn Valider la commande
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
            $output .= '
                <button type="button" data-id="' . $row['ID_depense'] . '" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-sm btn_update_depense " data-original-title="Modifier depense"> <i class="fa fa-edit text-icon-info"></i> </button>
                ';
        endif;

        // btn Valider la deSTATUT_DEPENSE
        if ($row['statut_depense'] == STATUT_DEPENSE[0]):
            $output .= '
                <button type="button" 
                id="btn_annulation_depense"
                onclick="updateELementDepense(this,\'' . $row['ID_depense'] . '\')"
                data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-sm " data-original-title="annule la depense"> <i class="fa fa-times text-icon-danger"></i> </button>
                ';
        endif;

        $output . '
        </td>
        </tr>
        ';
    }
      echo $output;
    }
  }

  
public static function getDepense()
{
    if (isset($_POST["frm_updepense"])) {

        $id_depense = $_POST['id_depense'];
        $depense = Soutra::getSingleDepense($id_depense);

        $output = '
        <div class="form-row menu-modal">

            <div class="col-md-12">
                <div class="form-group">
                    <label>Dépense</label>
                    <select name="type_id" class="form-control select2">
        ';

        $data = Soutra::getAllByFromTable("type_depense", "libelle_type");

        foreach ($data as $value) {

            $selected = ($value['ID_type'] == $depense['ID_type']) ? 'selected' : '';

            $output .= '
                <option value="' . $value['ID_type'] . '" ' . $selected . '>
                    ' . htmlspecialchars($value['libelle_type']) . '
                </option>
            ';
        }

        $output .= '
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Montant</label>
                    <input type="text" value="' . $depense['montant'] . '" 
                           name="montant" class="form-control">
                </div>
            </div>
            <input type="hidden" name="btn_modifier_depense" value="1">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="hidden" name="id_depense_updated" 
                           value="' . $depense['ID_depense'] . '">

                    <label>Date</label>
                    <input type="date" name="periode" 
                           value="' . $depense['periode_depense'] . '" 
                           class="form-control">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">'
                        . htmlspecialchars($depense['description']) .
                    '</textarea>
                </div>
            </div>

        </div>
        ';

        echo json_encode(['success' => true, 'html' => $output]);
    }
}
  public static function ajouter_depense()
  {
    if (isset($_POST['btn_ajouter_depense'])) {
      $msg['code'] = 400;
      $msg['message'] = "";
      extract($_POST);
      // var_dump($_POST);return;
      if(isset($btn_modifier_depense)){
      self::modifier_depense();
      }else{
      if (!empty($type_id) && !empty($entrepot_id) && !empty($montant) && !empty($periode)) {
        if (is_numeric($montant)) {
          // TODO: Enregistrer la dépense dans la base de données
          $data = [
            'type_id' => $type_id,
            'entrepot_id' => $entrepot_id,
            'montant' => $montant,
            'periode' => $periode,
            'description' => $description ?? "Aucune description",
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
  }

  public static function modifier_depense()
  {
    $msg = [];
    
    // Étape 1 : validation
    $errors = self::validateDepense($_POST);
    extract($_POST);

    if (!empty($errors)) {
      $msg['code'] = 400;
      $msg['message'] = $errors;
      echo json_encode($msg);
      return;
    }
    $insertData = [
      'entrepot_id'  => $_SESSION['id_entrepot'],
      'montant'      => $montant,
      'description'  => $description,
      'periode'      => $periode,
      'type_id'      => $type_id,
      'ID_depense'   => $id_depense_updated,
    ];
    if (Soutra::update("depense", $insertData)) {
      // $retour = self::liste_depense_detail($code_depense);
      $msg['code'] = 200;
      $msg['message'] = "Dépendence modifiée avec succès.";
    } else {
      $msg['code'] = 400;
      $msg['message'] = "Une erreur est survenue !";
    }

    echo json_encode($msg);
  }

/**
   * Vérifie la validité des données envoyées
   */
  private static function validateDepense($data)
  {
    $errors = [];

    if (empty($data['type_id'])) {
      $errors[] = "Le type de dépense est obligatoire.";
    }
    if (empty($data['montant'])) {
      $errors[] = "Le montant est obligatoire.";
    } elseif (!is_numeric($data['montant'])) {
      $errors[] = "Le montant doit être un nombre.";
    }
    if (empty($data['periode'])) {
      $errors[] = "La date est obligatoire.";
    }

    return $errors;
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

  
  public static function validation_depense()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_validation_depense") {
      extract($_POST);
      $msg = [];

      if(empty($id)){
        $msg = ["success" => false, "msg" => "ID de la dépense manquant"];
        echo json_encode($msg);
        return;
      }

      $data = [
        'statut_depense' => STATUT_DEPENSE[1],
        'employe_confirm' => $_SESSION['id_employe'],
        'date_confirm' => date('Y-m-d H:i:s'),
        'entrepot_id' => $_SESSION['id_entrepot'],
        'ID_depense' => $id
      ];
      
      if (Soutra::update("depense", $data)) {
        $msg = ["success" => true, "msg" => "Dépense validee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }
  
  public static function annulation_depense()
  {
    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_annulation_depense") {
      extract($_POST);
      $msg = [];
        if(empty($id)){
        $msg = ["success" => false, "msg" => "ID de la dépense manquant"];
        echo json_encode($msg);
        return;
      }

      $data = [
        'statut_depense' => STATUT_DEPENSE[2],
        'employe_confirm' => $_SESSION['id_employe'],
        'date_confirm' => date('Y-m-d H:i:s'),
        'entrepot_id' => $_SESSION['id_entrepot'],
        'ID_depense' => $id
      ];
      
      if (Soutra::update("depense", $data)) {
        $msg = ["success" => true, "msg" => "Dépense annulee avec succès"];
      } else {
        $msg = ["success" => false, "msg" => "Une erreur est survenue !"];
      }
      echo json_encode($msg);
    }
  }
} //fin de la class
