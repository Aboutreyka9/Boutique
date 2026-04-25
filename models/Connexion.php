<?php

class Connexion
{

    /*  private $username = 'root';
    private $password = '';
    private $dbase = 'boutique';  
    */
    private static $con = null;
    private $dbase = 'c2588565c_boutique';
    private $username = 'c2588565c_kassann';
    private $password = 'c2588565c_kassann';
    // private $username = 'root';
    // private $password = '';
    private $host = 'localhost';
    private $dns;

    public function __construct()
    {
        $this->dns = "mysql:host=$this->host;dbname=$this->dbase;charset=utf8mb4";
        try {
            self::$con = new PDO($this->dns, $this->username, $this->password);
            $sql = self::getConnexion()->query(" SET lc_time_names = 'fr_FR' ;");
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            //die($e->getMessage());
            echo '<stron style="color:orangered;">Pas de connexion à la base de données</strong>';
            die();
        }
    }

    public static function getConnexion()
    {
        if (self::$con == null) {
            new Connexion();
        }

        return self::$con;
    }
}
