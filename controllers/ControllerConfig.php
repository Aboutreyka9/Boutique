<?php

class ControllerConfig extends Connexion {

    public static function ajouter_info() {
        if (isset($_POST['btn_config_info'])) {
        self::create_info();
        }
    }

    public static function create_info()
    {
        extract($_POST);
    
        if (empty($nom) || trim($nom) == "") {
            $msg =  '2&Veuillez remplir le champ nom !';
        } elseif (mb_strlen(trim($nom)) < 6) {
            $msg = '2&Le nom doit être au moins 6 caracteres!'; 
            // $msg = mb_strlen($telephone_client);
        }elseif (!empty($adresse) && mb_strlen(trim($adresse)) < 10) {
            $msg = '2&L\'adresse doit être au moins 10 caracteres!';
        }
        else {

            $data = array(
                'nom' => strtoupper($nom),
                'adresse' => ucfirst($adresse),
                'ID_config' => 1,
            );
            //var_dump($data);die();
            if (Soutra::update("config", $data)) {
                $msg = "1&Informations modifées avec succès.";
            } else {
                $msg= '2&Une erreur est survenue ! ';
            }

        }
        echo $msg;
    }

    public static function loadDate() {
        if (isset($_POST['loadDate'])) {
            $min = Soutra::getMinYear();
            echo $min;
        }
    }

    public static function ajouter_contact() {
        if (isset($_POST['btn_config_contact'])) {
        self::create_contact();
        }
    }

    public static function create_contact()
    {
        extract($_POST);
    
        if (empty($contact1) || trim($contact1) == "") {
            $msg =  '2&Veuillez remplir le champ contact 1 !';
        }
         elseif (mb_strlen(trim($contact1)) != 10 || !Soutra::verif_type($contact1)) {
            $msg = '2&Le contact 1 est invalide!'; 
        }
        elseif (!empty($contact2) && (mb_strlen(trim($contact2)) != 10 || !Soutra::verif_type($contact2))) {
            $msg = '2&Le contact 2 est invalide!';
        }
        elseif (!empty($email) && (trim($email) == "" || !Soutra::verif_email($email))) {
            $msg = '2&L\'adresse email est invalide!';
        }
        else {

            $data = array(
                'contact1' => $contact1,
                'contact2' => $contact2,
                'email' => $email,
                'ID_config' => 1,
            );
            

            if (Soutra::update("config", $data)) {
                $msg = "1&Infos contacts modifées avec succès.";
            } else {
                $msg= '2&Une erreur est survenue ! ';
            }

        }
        echo $msg;
    }
  
    public static function changeImageLogo() {
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {

            $to = "../assets/images/";
            $to2 = ASSETS."images/";

            $file = $_FILES['file'];
            $extension = ["jpg","jpeg","png"];
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($ext),$extension)){
                $msg = '2&Image invalide!';
            }elseif($file['size'] > 2000000){

                $msg = '2&Image trop volumineux!';
            }else{
                $image = rand().".".$ext;
                // $image = "logo.".$ext;
                $to .= $image;
                $to2 .= $image;
                $from = $file['tmp_name'];
                if(move_uploaded_file($from,$to)){
                    $data = array(
                        'image' => $to2,
                        'ID_config' => 1,
                    );

                    Soutra::update("config",$data);
                    
                    $msg = "1& $to & Image modifiée avec succes!";
                }else{
                    $msg = '2& Erreur de requete!';

                }
            }
            echo $msg;
        }
        
    }
  
    public static function switchClient() {
        if (isset($_POST['switch_client'])) {
            $state = $_POST['state'];

            $data = array(
                'client' => $state,
                'ID_config' => 1,
            );

            Soutra::update('config',$data);
            echo ($state != 1) ? 1 : 0;
            
        }
    }

    public static function switchFournisseur() {
        if (isset($_POST['switch_fournisseur'])) {
            $state = $_POST['state'];

            $data = array(
                'fournisseur' => $state,
                'ID_config' => 1,
            );

            Soutra::update('config',$data);
            echo ($state != 1) ? 1 : 0;
        }
    }

    public static function switchDelete() {
        if (isset($_POST['switch_delete'])) {
            $state = $_POST['state'];

            $data = array(
                'supprimer' => $state,
                'ID_config' => 1,
            );

            Soutra::update('config',$data);
            echo ($state != 1) ? 1 : 0;
        }
    }

    public static function switchUnite() {
        if (isset($_POST['switch_unite'])) {
            $state = $_POST['state'];

            $data = array(
                'unite' => $state,
                'ID_config' => 1,
            );

            Soutra::update('config',$data);
            echo ($state != 1) ? 1 : 0;
        }
    }
      

}

//fin de la class
