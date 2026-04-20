<?php

class ControllerUnite extends Connexion {

    // connexion utilisateur
    

     public static function getunite() {
        if (isset($_POST["frm_upunite"])) {
            $unite = Soutra::getAllByItemsa('unite','ID_unite',$_POST['id_unite']);
            $output = '
            <div class="col-md-12">
            <div class="form-group">
              <label for="libelle_unite">Libelle long</label>
               <input type="text" name="libelle_unite" value="'.$unite['libelle_unite'].'" id="libelle_unite" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group">
            <label for="slug_unite">Libelle court</label>
             <input type="text" name="slug_unite" value="'.$unite['slug_unite'].'" id="slug_unite" class="form-control">
          </div>
        </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description_unite">Description</label>
            <textarea name="description_unite"  id="description_unite" rows="5" class="form-control">'.$unite['description_unite'].'</textarea>
            </div>
            <input type="hidden" id="id_unite" name="id_unite" value="'.$unite['ID_unite'].'" class="form-control">
          </div>
          </div>
            ';
            
            
            echo json_encode(['success' => true, 'html' => $output]);
        }
    }
  
    public static function liste_unite() {
        if(isset($_POST['btn_liste_unite'])){ 
        $output = '';
        $unite = Soutra::getAllUnite();
        if (!empty($unite)) {
            $i = 0;
            foreach ($unite as $row) {
                $i++;
                $output .= '
                <tr class="row'.$row['ID_unite'].'">
                   <td>' . $i . '</td>
                   <td>' . $row['libelle_unite'] . '</td>
                   <td>' . $row['slug_unite'] . '</td>
                   <td>' . $row['description_unite'] . '</td>
                   ';
                
                   $output .= '<td style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;"> 
            <button data-id="'. $row['ID_unite'].'" class="btn btn-primary btn-sm btn_update_unite">
            <i class="fa fa-edit"></i> 
    
</button> ';
            if (strtolower($_SESSION['role']) == ADMIN ) {
            $output.= '<div class="d-inline">
                <button data-id="'. $row['ID_unite'].'" class="btn btn-warning btn-sm btn_remove_unite">
                <i class="fa fa-trash"></i> </button>
            </div>';
          }
        $output.='
          </td>
             </tr>
             ';
            }
        }
        echo $output;
      }
    }

    public static function activation() {
        if (isset($_POST['active_unite'])) {
            if ($_POST['etat'] == 1) {
                $data = array(
                    'etat_unite' => 0,
                    'ID_unite' => $_POST['id']
                );
                if (Soutra::update("unite", $data)) {
                    echo 1;
                } else {
                    echo 3;
                }
            } elseif ($_POST['etat'] == 0) {
                $data = array(
                    'etat_unite' => 1,
                    'ID_unite' => $_POST['id']
                );
                if (Soutra::update("unite", $data)) {
                    echo 2;
                } else {
                    echo 3;
                }
            }
        }
    }


    public static function ajouter_unite() {
        if (isset($_POST['btn_ajouter_unite'])) {

           if (isset($_POST['id_unite'])) {
            // mod()
            self::modifier_unite();

           }else{
            // Ajouter
            self::createUnite();
           }

         
        }
    }

    public static function createUnite()
    {
        extract($_POST);
        $msg = "";
        if (empty($libelle_unite)) {
           $msg =  '2&Veuillez remplir tous les champs !';
        }elseif (Soutra::existe("unite", "libelle_unite", $libelle_unite)) {
            $msg = '2& Ce libelle existe déjà !';
        } else {
            $slug = !empty(trim($slug_unite)) ? $slug_unite : $libelle_unite;
            $data = array(
                'libelle_unite' => ucfirst($libelle_unite),
                'slug_unite' => strtoupper($slug),
                'description_unite' => $description_unite,
                'etat_unite'=> 1,
            );
            //var_dump($data);die();
            if (Soutra::insert("unite", $data)) {
                $msg = "1& Unite enregistrée avec succès.";
            } else {
                $msg= '2&Une erreur est survenue ! ';
            }
        }
        echo $msg;
    }

    public static function modifier_unite() {
        extract($_POST);
        $msg = "";
    
            if (empty($libelle_unite)) {
                $msg = '2&Veuillez remplir tous les champs !';
            }elseif (Soutra::existe("unite", "libelle_unite", $libelle_unite) && Soutra::libelle("unite", "ID_unite", "libelle_unite", $libelle_unite) != $id_unite) {
                $msg = '2& Ce libelle existe déjà !';
            }else {
            $slug = !empty(trim($slug_unite)) ? $slug_unite : $libelle_unite;

                $data = array(
                    'libelle_unite' => ucfirst($libelle_unite),
                    'slug_unite' => strtoupper($slug),
                    'description_unite' => ucfirst($description_unite),
                    'ID_unite' => $id_unite
                );
                //var_dump($data);die();
                if (Soutra::update("unite", $data)) {
                    $msg = "1&Unite modifiée avec succès.";
                } else {
                    $msg = '2&Une erreur est survenue !';
                }
            }
            echo $msg;

        
    }

    public static function suppresion_unite() {
        if (isset($_POST['btn_supprimer_unite'])) {
          
            $data = array(
                'etat_unite' => 0,
                'ID_unite' => $_POST['id_unite']
            );
            Soutra::update("unite", $data);
            echo 1;
            
        }
    }

}

//fin de la class
