<?php

class Employe extends Connexion {
    private $ID_employe;
    private $nom_employe;
    private $pre_employe;
    private $tel_employe;
    private $email_employe;
    private $type_employe;
    private $etat_employe;
    private $sexe_employe;
    private $login_employe;
    private $passe_employe;
    
    public function hydratation(array $data){
        foreach ($data as $key => $value) 
        {
              $method='set'.ucfirst($key);
              if(method_exists($this, $method))
              {
                  $this->$method($value);
              }
        }
    }
    
    public function getID_employe() {
        return $this->ID_employe;
    }

    public function getNom_employe() {
        return $this->nom_employe;
    }

    public function getPre_employe() {
        return $this->pre_employe;
    }

    public function getTel_employe() {
        return $this->tel_employe;
    }

    public function getEmail_employe() {
        return $this->email_employe;
    }

    public function getType_employe() {
        return $this->type_employe;
    }

    public function getEtat_employe() {
        return $this->etat_employe;
    }

    public function getSexe_employe() {
        return $this->sexe_employe;
    }

    public function getLogin_employe() {
        return $this->login_employe;
    }

    public function getPasse_employe() {
        return $this->passe_employe;
    }

    public function setID_employe($ID_employe) {
        $this->ID_employe = $ID_employe;
    }

    public function setNom_employe($nom_employe) {
        $this->nom_employe = $nom_employe;
    }

    public function setPre_employe($pre_employe) {
        $this->pre_employe = $pre_employe;
    }

    public function setTel_employe($tel_employe) {
        $this->tel_employe = $tel_employe;
    }

    public function setEmail_employe($email_employe) {
        $this->email_employe = $email_employe;
    }

    public function setType_employe($type_employe) {
        $this->type_employe = $type_employe;
    }

    public function setEtat_employe($etat_employe) {
        $this->etat_employe = $etat_employe;
    }

    public function setSexe_employe($sexe_employe) {
        $this->sexe_employe = $sexe_employe;
    }

    public function setLogin_employe($login_employe) {
        $this->login_employe = $login_employe;
    }

    public function setPasse_employe($passe_employe) {
        $this->passe_employe = $passe_employe;
    }

    public static function dateConEmploye($ID){
      $sql=" UPDATE employe SET date_con = NOW() WHERE ID_employe = ?";
      $query = self::getConnexion()->prepare($sql);
      if($query->execute(array($ID))){
          return 1;
      }else{
        return 0;
      }
    }
    
    //retourne le nombre 1 si user existe sinon 0 
    public static function existEmploye($username,$password){
        $sql ="SELECT * FROM employe WHERE etat_employe = ? AND login_employe = ? AND passe_employe = ?";
        $query = self::getConnexion()->prepare($sql);
        $query -> execute(array(1,$username,$password));
        return $result = $query->rowCount();
    }
    
    public static function verrif_etat_user($ID){
        $sql ="SELECT etat_employe FROM employe WHERE ID_employe = ?";
        $query = self::getConnexion()->prepare($sql);
        $query -> execute(array($ID));
        $result = 0;
        while ($data = $query->fetch()) {
            $result = $data['etat_employe']; 
        }
        return $result ;
    }
    
    /* permet de trouver grace a un parametre fourni */
    public static function getEmploye($username,$password){
        $sql =" SELECT * FROM employe e, type_employe t 
        WHERE e.etat_employe = ? AND t.ID_type_employe = e.ID_type_employe AND e.login_employe = ? AND e.passe_employe = ?";
        $query = self::getConnexion()->prepare($sql);
        $query -> execute(array(1,$username,$password));
        $table = array();
	    while ($data = $query->fetch()) {
	        $table[] = $data; 
	    }	
        return $table;
    }
    
     //verification des variables
     public static function verification($username,$password){
         if (empty(htmlspecialchars(trim($username)))) {
             echo "<span class='text-danger'>Nom utilisateur requis !</span>"; 
         }elseif(empty(htmlspecialchars(trim($password)))){
              echo "<span class='text-danger'>Mot de passe requis !</span>";
         }elseif(self::existEmploye($username, md5($password))==0){
             echo "<span class='text-danger'>Nom utilisateur ou mot de passe incorect !</span>";
         }else{
            foreach (self::getEmploye($username, md5($password)) as $row) {
                $_SESSION["id_employe"] = $row["ID_employe"];
                $_SESSION["role"] = $row["I"];
                $_SESSION["libelle_type"] = $row["libelle_type_employe"];
                $_SESSION["nom"] = $row["nom_employe"];
                $_SESSION["prenom"] = $row["prenom_employe"];
                self::dateConEmploye($row["ID_employe"]);
                echo "ok";
            }
         }
         
    }


    
}
