<?php


class Soutra extends Connexion
{

    // Nouvelle méthode pour la connexion API
    public static function apiConnect($telephone, $password = null)
    {
        $data = [];
        $sql = "SELECT emp.*, r.libelle_role role FROM employe emp INNER JOIN role r ON r.ID_role = emp.role_id  WHERE emp.telephone_employe = ? AND etat_employe = 1";
        $params = [$telephone];

        if (!is_null($password)) {
            $sql .= " AND emp.password_employe = ?";
            $params[] = $password;
        }

        $query = self::getConnexion()->prepare($sql);
        $query->execute($params);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
            // Mettre à jour l'heure de connexion
            $updateSql = "UPDATE employe SET login = NOW() WHERE ID_employe = ?";
            $updateQuery = self::getConnexion()->prepare($updateSql);
            $updateQuery->execute([$data['ID_employe']]);
            $data['login'] = date('Y-m-d H:i:s');
        }
        $query->closeCursor();
        return $data;
    }

    // Nouveau compte

    public static function getProdByCat($id = null)
    {
        $sql = "SELECT * FROM article";
        if (!is_null($id)) {
            $sql .= " WHERE categorie_id = ?";
        }
        $data = "";
        try {
            $query = self::getConnexion()->prepare($sql);
            !is_null($id) ? $query->bindParam(1, $id) : "";
            $query->execute();
            $data = $query->fetchAll();
        } catch (PDOException $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
        return $data;
    }

    public static function getMontant($table, $qte, $pu, $idprod)
    {
        $sql = "SELECT SUM($qte*$pu) AS mtt FROM $table WHERE article_id = ? ";
        $result = 0;
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->bindParam(1, $idprod);
            $query->execute();
            $data = $query->fetch();
            $result = $data['mtt'];
        } catch (PDOException $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
        return $result;
    }



    public static function getQte($table, $champ, $idprod)
    {
        $sql = "SELECT SUM($champ) as qte FROM $table WHERE article_id = ? ";
        $result = 0;
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->bindParam(1, $idprod);
            $query->execute();
            $data = $query->fetch();
            $result = $data['qte'];
        } catch (PDOException $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
        return $result;
    }

    public static function getHistoriqueEntree(int $etat = 1)
    {
        $data = [];
        $sql = "SELECT en.*,ar.libelle_article AS article,ac.created_at d_achat ,ac.etat_achat AS e_a FROM entree en 
        INNER JOIN article ar ON ar.ID_article = en.article_id 
        INNER JOIN achat ac ON ac.code_achat=en.achat_id
        GROUP BY ac.created_at, ar.ID_article,en.ID_entree
        HAVING e_a=?
        ORDER BY ac.created_at DESC";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute([$etat]);
            $data = $query->fetchAll();
        } catch (PDOException $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
        return $data;
    }



    public static function getHistoriqueSortie(int $etat = 1)
    {

        $data = [];
        $sql = "SELECT so.*,ar.libelle_article AS article,ve.created_at d_vente ,ve.etat_vente AS e_v FROM sortie so 
        INNER JOIN article ar ON ar.ID_article = so.article_id 
        INNER JOIN vente ve ON ve.code_vente=so.vente_id
        GROUP BY ve.created_at, ar.ID_article,so.ID_sortie
        HAVING e_v=?
        ORDER BY ve.created_at DESC;";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute([$etat]);
            $data = $query->fetchAll();
        } catch (PDOException $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
        return $data;
    }

    public static function updateVersement($id, $solde)
    {
        $retour = false;

        try {

            $sql1 = 'SELECT solde_client FROM client WHERE ID_client = ?';
            $query = self::getConnexion()->prepare($sql1);
            $query->execute([$id]);
            $data = $query->fetch();

            $sql = "UPDATE client SET solde_client = ? WHERE ID_client =?";
            $query = self::getConnexion()->prepare($sql);
            $exec = $query->execute([$data['solde_client'] + $solde, $id]);
            if ($exec) {
                $retour = true;
            }
        } catch (Exception $th) {
            return $th;
        }
        $query->closeCursor();

        return $retour;
    }


    // NOUVEAU COMPTE FIN
    private static $lastId;
    // methode qui permet de verifier l'existence d'un element
    public static function Ecole()
    {
        return "GEST-ACCADMIQUE";
    }


    public static function lastInsertId()
    {
        return self::$lastId;
    }



    public static function date_format($date, bool $f = true)
    {
        if ($f)
            return (new DateTime($date))->format('d/m/Y');
        else
            return (new DateTime($date))->format('d-m-Y');
    }

    public static function getField($libelle, $c, $v)
    {
        $sql = "SELECT $libelle FROM inscrire,annee WHERE inscrire.ID_annee=annee.ID_annee AND annee.etat_annee = 1 AND $c= ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($v));
        $data = $query->fetch();
        $query->closeCursor();
        return $data[$libelle];
    }

    public static function exite($table, $condition, $value)
    {
        $sql = "SELECT * FROM $table WHERE $condition = ? ";
        $table = array($value);
        $query = self::getConnexion()->prepare($sql);
        $query->execute($table);
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function getAllByItem3p($table, $libelle, $value)
    {
        $sql = "SELECT * FROM $table WHERE $libelle != ? ORDER BY nom_employe";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($value));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }

    public static function getAllByItem6p($tab1, $tab2, $lib1, $lib2, $lib3, $lib4, $val1, $val2)
    {
        $sql = "SELECT * FROM $tab1 t1, $tab2 t2 WHERE t1.$lib1=t2.$lib2 AND $lib3 = ? AND $lib4 = ? ORDER BY t1.nom_eleve";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($val1, $val2));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }


    public static function existe($table, $condition, $value)
    {
        $sql = "SELECT * FROM $table WHERE $condition = ? ";
        $table = array($value);
        $query = self::getConnexion()->prepare($sql);
        $query->execute($table);
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function exist2($table, $lib1, $lib2, $v1, $v2)
    {
        $sql = "SELECT * FROM $table WHERE $lib1 = :val1 AND $lib2 = :val2 LIMIT 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array('val1' => $v1, 'val2' => $v2));
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function rowCounter($table, $ref, $val)
    {
        $count = 0;
        $query = "SELECT * FROM $table WHERE $ref = ? LIMIT 1";
        $statement = self::getConnexion()->prepare($query);
        $statement->execute(array($val));
        if ($statement->rowCount() > 0) {
            $count = 1;
        }
        return $count;
    }

    public static function verif_email($email)
    {
        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function verif_type($val)
    {
        if (ctype_digit($val)) {
            return true;
        } else {
            return false;
        }
    }

    //liste d'une table
    public static function getAll($table, $libelle)
    {
        $sql = "SELECT * FROM $table ORDER BY $libelle  ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }

    public static function getAllByItem2($tab1, $tab2, $lib1, $lib2, $lib, $value)
    {
        $sql = "SELECT * FROM $tab1 t1, $tab2 t2 WHERE t1.$lib1=t2.$lib2 AND $lib = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($value));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }

    public static function getAllByItem6($tab1, $tab2, $lib1, $lib2, $lib3, $lib4, $val1, $val2)
    {
        $sql = "SELECT * FROM $tab1 t1, $tab2 t2 WHERE t1.$lib1=t2.$lib2 AND $lib3 = ? AND $lib4 = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($val1, $val2));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }

    public static function getEleveClasseNiveau($classe, $niveau, $annee)
    {
        $tab = [];
        $sql = "SELECT el.*, cl.*,nv.*,ins.* FROM inscrire ins
         INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve 
        INNER JOIN classe cl  ON ins.ID_classe = cl.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.Id_annee
         INNER JOIN niveau nv ON nv.ID_niveau = cl.ID_niveau  WHERE ins.ID_classe = ? AND  nv.ID_niveau = ? AND an.ID_annee = ?";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute(array($classe, $niveau, $annee));
            if ($query->rowCount() > 0) {
                $tab = $query->fetchAll();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getEleveInscrire($date, $etat)
    {
        $tab = [];
        $sql = "SELECT el.*, cl.*,nv.*,ins.* FROM inscrire ins
         INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve 
        INNER JOIN classe cl  ON ins.ID_classe = cl.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.Id_annee
         INNER JOIN niveau nv ON nv.ID_niveau = cl.ID_niveau 
          WHERE ins.date_inscrire like '%" . $date . "%' AND an.etat_annee = ?";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute(array($etat));
            if ($query->rowCount() > 0) {
                $tab = $query->fetchAll();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }


    public static function getEleveInfo($id)
    {
        $tab = [];
        $sql = "SELECT el.*, cl.*,nv.*,ins.* FROM inscrire ins
         INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve 
        INNER JOIN classe cl  ON ins.ID_classe = cl.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.Id_annee
         INNER JOIN niveau nv ON nv.ID_niveau = cl.ID_niveau  WHERE el.ID_eleve = ?";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute(array($id));
            if ($query->rowCount() > 0) {
                $tab = $query->fetch();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getEleveInfoInscrire($id)
    {
        $tab = [];
        $sql = "SELECT el.*, cl.*,nv.*,ins.* FROM inscrire ins
         INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve 
        INNER JOIN classe cl  ON ins.ID_classe = cl.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.Id_annee
         INNER JOIN niveau nv ON nv.ID_niveau = cl.ID_niveau  WHERE el.ID_eleve = ?";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute(array($id));
            if ($query->rowCount() > 0) {
                $tab = $query->fetch();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }



    public static function getEleveInfoLike($var)
    {
        $tab = [];
        $sql = "SELECT el.*, cl.*,nv.*,ins.* FROM inscrire ins
         INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve 
        INNER JOIN classe cl  ON ins.ID_classe = cl.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.Id_annee
         INNER JOIN niveau nv ON nv.ID_niveau = cl.ID_niveau  WHERE el.mat_eleve LIKE '%" . $var . "%' OR el.tel_eleve LIKE '%" . $var . "%' OR ins.ID_inscrire LIKE '%" . $var . "%' LIMIT 1";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute([]);
            if ($query->rowCount() > 0) {
                $tab = $query->fetch();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }




    public static function getVersementEleve($id)
    {
        $tab = [];
        $sql = "SELECT ver.*, ins.ID_inscrire inscrire, ins.montant_inscrire FROM versement ver
        INNER JOIN inscrire ins  ON ins.ID_inscrire = ver.ID_inscrire
        INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve
        INNER JOIN annee an  ON ins.ID_annee = an.ID_annee
        WHERE an.etat_annee = 1 AND el.ID_eleve = ?";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute([$id]);
            if ($query->rowCount() > 0) {
                $tab = $query->fetchALl();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getCompterArticleEntrepot($entrepot_id, $etat = 1)
    {
        $nb = 0;
        $sql = "SELECT COUNT(id_entrepot_article) AS nb FROM entrepot_article WHERE etat_article = :etat AND entrepot_id = :entrepot_id";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['etat' => $etat, 'entrepot_id' => $entrepot_id]);
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
            $nb = $data['nb'];
        }
        $query->closeCursor();
        return $nb;
    }

    public static function getStockDisponibleEntrepot($entrepot_id, $etat = 1)
    {
        $sql = "SELECT SUM(qte) AS nb FROM entrepot_article WHERE entrepot_id = ? AND etat_article = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$entrepot_id, $etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterVenteToDay($date, $etat)
    {
        $sql = "SELECT SUM(qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE DATE(ve.created_at) = ? AND ve.etat_vente =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$date, $etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterVente($etat)
    {
        $sql = "SELECT SUM(qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterAchatToDay($etat)
    {
        $sql = "SELECT SUM(qte) AS nb FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE DATE(ac.created_at) = CURDATE() AND ac.etat_achat =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterAchat($etat)
    {
        $sql = "SELECT SUM(qte) AS nb FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE ac.etat_achat =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterVenteArticleByEmploye($etat, $id_employe)
    {
        $sql = "SELECT SUM(qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente =? AND employe_id = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat, $id_employe]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }


    public static function getStockLimit()
    {
        $tab = [];
        $sql = "SELECT cp.article,cp.qte_reste,be.en_qte,ar.stock_alert,
        ((cp.qte_reste*100)/ be.en_qte) AS moyenne,
        IF(cp.qte_reste <= ar.stock_alert,'mal','bien') AS niveau
        FROM comptabilite cp
        INNER JOIN article ar ON ar.ID_article = cp.id_article
        INNER JOIN bilan_entree be ON be.ID_article= cp.id_article
        ORDER BY cp.qte_reste LIMIT 4";
        try {
            $query = self::getConnexion()->query($sql);
            if ($query->rowCount() > 0) {
                $tab = $query->fetchAll();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }
    public static function getBestVente()
    {
        $tab = [];
        $sql = "SELECT 
                    a.ID_article,
                    a.libelle_article AS article,
                    so.total_sortie,
                    COALESCE(en.total_entree, 0) AS total_entree,
                    so.chiffre_affaire,
                    ROUND((so.total_sortie * 100) / NULLIF(en.total_entree,0), 1) AS moyenne,
                    IF(so.total_sortie < en.total_entree,'mal','bien') AS niveau
                FROM article a
                JOIN (
                    SELECT article_id,
                           SUM(qte) AS total_sortie,
                           SUM(qte * prix_vente) AS chiffre_affaire
                    FROM sortie
                    WHERE etat_sortie = 1
                    GROUP BY article_id
                ) AS so
                  ON so.article_id = a.ID_article
                JOIN (
                    SELECT article_id,
                           SUM(qte) AS total_entree
                    FROM entree
                    WHERE etat_entree = 1
                    GROUP BY article_id
                ) AS en
                  ON en.article_id = a.ID_article
                ORDER BY so.total_sortie DESC
                LIMIT 4;

        ";
        try {
            $query = self::getConnexion()->query($sql);
            if ($query->rowCount() > 0) {
                $tab = $query->fetchAll();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getTotalReapprovisionnementDashboard($startDate, $endDate, $entrepot = null)
    {
        try {

            $sql = "SELECT 
                COALESCE(
                    COUNT(CASE WHEN type_mouvement = 'ENTREE' THEN (ID_mouvement_stock) END)
                    -
                    COUNT(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (ID_mouvement_stock) END)
                , 0) AS nombre_reapprovisionnement,
                COALESCE(SUM(CASE 
                    WHEN type_mouvement = 'ENTREE' 
                    THEN (quantite * prix_achat) 
                END), 0) AS montant_reapprovisionnement,

                COALESCE(SUM(CASE 
                    WHEN type_mouvement = 'RETOUR_FOURNISSEUR' 
                    THEN (quantite * prix_achat) 
                END), 0) AS montant_retours,

                COALESCE(
                    SUM(CASE WHEN type_mouvement = 'ENTREE' THEN (quantite * prix_achat) END)
                    -
                    SUM(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (quantite * prix_achat) END)
                , 0) AS investissement_net

            FROM mouvement_stock ms
            WHERE date_mouvement BETWEEN :startDate AND :endDate
        ";

            $params = [
                ':startDate' => $startDate,
                ':endDate'   => $endDate
            ];

            // Ajout condition dynamique
            if (!empty($entrepot)) {
                $sql .= " AND ms.entrepot_id = :entrepot_id";
                $params[':entrepot_id'] = $entrepot;
            }

            $query = self::getConnexion()->prepare($sql);
            $query->execute($params);

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public static function getTotalVenteDashboard($startDate, $endDate, $entrepot = null)
    {
        try {

            $sql = "SELECT 
                COALESCE(
                    COUNT(CASE WHEN type_mouvement = 'SORTIE' THEN (ID_mouvement_stock) END)
                    -
                    COUNT(CASE WHEN type_mouvement = 'RETOUR_CLIENT' THEN (ID_mouvement_stock) END)
                , 0) AS nombre_vente,
                COALESCE(SUM(CASE 
                    WHEN type_mouvement = 'SORTIE' 
                    THEN (quantite * prix_vente) 
                END), 0) AS montant_vente,

                COALESCE(SUM(CASE 
                    WHEN type_mouvement = 'RETOUR_CLIENT' 
                    THEN (quantite * prix_vente) 
                END), 0) AS montant_retours,

                COALESCE(
                    SUM(CASE WHEN type_mouvement = 'SORTIE' THEN (quantite * prix_vente) END)
                    -
                    SUM(CASE WHEN type_mouvement = 'RETOUR_CLIENT' THEN (quantite * prix_vente) END)
                , 0) AS montant_net

            FROM mouvement_stock ms
            WHERE DATE(date_mouvement) BETWEEN :startDate AND :endDate
        ";

            $params = [
                ':startDate' => $startDate,
                ':endDate'   => $endDate
            ];

            // Ajout condition dynamique
            if (!empty($entrepot)) {
                $sql .= " AND ms.entrepot_id = :entrepot_id";
                $params[':entrepot_id'] = $entrepot;
            }

            $query = self::getConnexion()->prepare($sql);
            $query->execute($params);

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getTotalDepenseDAshboard($startDate, $endDate, $entrepot = null)
    {
        $data = [];

        $sql = 'SELECT  COALESCE(SUM(d.montant),0) montant_depense,  COALESCE(COUNT(d.ID_depense),0) nombre_depense
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id AND d.statut_depense = :statut_depense
            WHERE DATE(d.date_created) BETWEEN :startDate AND :endDate ';

        $params = [
            ':startDate' => $startDate,
            ':endDate'   => $endDate,
            ':statut_depense'   => STATUT_DEPENSE[2],
        ];

        // Ajout condition dynamique
        if (!empty($entrepot)) {
            $sql .= ' AND d.entrepot_id = :entrepot_id ';
            $params[':entrepot_id'] = $entrepot;
        }

        $query = self::getConnexion()->prepare($sql);
        $query->execute($params);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }

        $query->closeCursor();

        return $data;
    }

    public static function getStockLimitAlert()
    {
        $tab = [];
        $sql = "SELECT ar.ID_article, cp.article,
        IF(cp.qte_reste <= ar.stock_alert,'Stock insuffisant',1) AS niveau
        FROM comptabilite cp
        INNER JOIN article ar ON ar.ID_article = cp.id_article
        INNER JOIN bilan_entree be ON be.ID_article= cp.id_article
        HAVING niveau ='Stock insuffisant'
        ORDER BY cp.qte_reste";
        try {
            $query = self::getConnexion()->query($sql);
            if ($query->rowCount() > 0) {
                $tab = $query->fetchAll();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getCompter($table, $id, $etat, $val)
    {
        $sql = "SELECT COUNT($id) AS nb FROM $table WHERE $etat=?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$val]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterClientByEmploye($etat, $id_employe)
    {
        $sql = "SELECT COUNT(ID_client) AS nb FROM client WHERE etat_client =? AND employe_id =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat, $id_employe]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getCompterSum($table, $qte, $etat, $val)
    {
        $sql = "SELECT SUM($qte) AS nb FROM $table WHERE $etat=?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$val]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }
    public static function getSumMontantVenteToDay($date, $etat)
    {
        $sql = "SELECT SUM(prix_vente * qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE DATE(ve.created_at) = ? AND ve.etat_vente =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$date, $etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getSumMontantVente($etat)
    {
        $sql = "SELECT SUM(prix_vente * qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }
    public static function getSumMontantAchatToDay($etat)
    {
        $sql = "SELECT SUM(prix_achat * qte) AS nb FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE DATE(ac.created_at) = CURDATE() AND ac.etat_achat =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }
    public static function getSumMontantAchat($etat)
    {
        $sql = "SELECT SUM(prix_achat * qte) AS nb FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE ac.etat_achat =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getSumMontantVenteByArticle($etat)
    {
        $sql = "SELECT ar.libelle_article article, SUM(prix_vente * qte) AS total FROM sortie so 
        INNER JOIN vente ve ON ve.code_vente = so.vente_id 
        INNER JOIN article ar ON ar.ID_article = so.article_id 
        WHERE ve.etat_vente =? GROUP BY so.article_id";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);
        $data = $query->fetchAll();
        $query->closeCursor();
        return $data;
    }

    public static function getSumMontantAchatByEmploye($etat, $id_employe)
    {
        $sql = "SELECT SUM(prix_achat * qte) AS nb FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE ac.etat_achat =? AND employe_id =?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat, $id_employe]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getSumMontantVenteByEmploye($etat, $id_employe)
    {
        $sql = "SELECT SUM(prix_vente * qte) AS nb FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente =? AND employe_id = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat, $id_employe]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }

    public static function getSumMontantVenteByVente($etat, $id_vente)
    {
        $sql = "SELECT SUM(prix_vente * qte) AS nb FROM sortie so WHERE so.etat_sortie = :etat AND so.vente_id = :id_vente";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['etat' => $etat, 'id_vente' => $id_vente]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'] ?? 0;
    }
    public static function getSumMontantAchatByAchat($etat, $id_achat)
    {
        $sql = "SELECT SUM(prix_achat * qte) AS nb FROM entree en WHERE en.etat_entree = :etat AND en.achat_id = :id_achat";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['etat' => $etat, 'id_achat' => $id_achat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'] ?? 0;
    }

    public static function getSumMontantVersementByVente($etat, $id_vente)
    {
        $sql = "SELECT SUM(montant_versement) AS nb FROM versement WHERE etat_versement = :etat AND transaction_code = :id_vente";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['etat' => $etat, 'id_vente' => $id_vente]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'] ?? 0;
    }

    public static function getSumMontantVersementByAchat($etat, $id_achat)
    {
        $sql = "SELECT SUM(montant_versement) AS nb FROM versement WHERE etat_versement = :etat AND transaction_code = :id_achat";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['etat' => $etat, 'id_achat' => $id_achat]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'] ?? 0;
    }

    public static function getAllEmployer($id, $etat = 1)
    {
        $data = [];
        $sql = "SELECT emp.*, r.libelle_role role FROM employe emp INNER JOIN role r ON r.ID_role = emp.role_id WHERE etat_employe = ? AND ID_employe != ?  ORDER BY ID_employe DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat, $id]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllEmployerToPrint($etat = 1)
    {
        $data = [];
        $sql = "SELECT emp.*, r.libelle_role role FROM employe emp INNER JOIN role r ON r.ID_role = emp.role_id WHERE etat_employe = ? ORDER BY ID_employe DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getAllFournisseur($etat = 1)
    {
        $data = [];
        $sql = "SELECT * FROM fournisseur WHERE etat_fournisseur = ?  ORDER BY ID_fournisseur DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllClient($etat = 1)
    {
        $data = [];
        $sql = "SELECT * FROM client WHERE etat_client = ?  ORDER BY ID_client DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getInfoClient($idClient)
    {
        $data = [];
        $sql = "SELECT * FROM client WHERE ID_client = ?  LIMIT 1 ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idClient]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getBilanFournisseur($idFournisseur, $etat_achat = 1, $etat_entree = 1)
    {
        $data = [];
        $sql = "SELECT SUM(en.qte) AS qte ,SUM(en.prix_achat * en.qte) total,ac.fournisseur_id
        FROM entree en
        INNER JOIN achat ac ON en.achat_id = ac.code_achat
        WHERE  ac.etat_achat = ? AND en.etat_entree= ?
        GROUP BY ac.fournisseur_id
        HAVING ac.fournisseur_id = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->bindParam(1, $etat_achat);
        $query->bindParam(2, $etat_entree);
        $query->bindParam(3, $idFournisseur);
        $query->execute();

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getBilanFournisseurNbre($idFournisseur)
    {
        $data = [];
        $sql = "SELECT COUNT(ac.ID_achat) AS nb_achat,ac.fournisseur_id
        FROM achat ac WHERE ac.etat_achat =1 AND ac.fournisseur_id = ?";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idFournisseur]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllListeCommandeFournisseur($id_fournisseur, $etat_achat = 1, $etat_entree = 1)
    {
        $data = [];
        $sql = "SELECT ac.*, COUNT(en.ID_entree) article,SUM(en.prix_achat * en.qte) total
        FROM achat ac
        INNER JOIN entree en ON en.achat_id = ac.code_achat
        INNER JOIN fournisseur fo ON fo.ID_fournisseur = ac.fournisseur_id
        WHERE ac.fournisseur_id= ? AND ac.etat_achat = ? AND en.etat_entree = ?  GROUP BY ac.ID_achat ORDER BY ac.ID_achat DESC";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_fournisseur, $etat_achat, $etat_entree]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getAllUnite($etat = 1)
    {
        $data = [];
        $sql = "SELECT * FROM unite WHERE etat_unite = ?  ORDER BY ID_unite DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllCategorie($etat = 1)
    {
        $data = [];
        $sql = "SELECT * FROM categorie WHERE etat_categorie = ?  ORDER BY ID_categorie DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllFamille($etat = 1)
    {
        $data = [];
        $sql = "SELECT fa.*, ca.libelle_categorie AS categorie  FROM famille fa INNER JOIN categorie ca ON ca.ID_categorie = fa.categorie_id WHERE etat_famille = ?  ORDER BY ID_famille DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllMark($etat = 1)
    {
        $data = [];
        $sql = "SELECT * FROM mark WHERE etat_mark = ?  ORDER BY ID_mark DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllArticle($etat = 1)
    {
        $data = [];
        $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark, un.libelle_unite unite FROM article ar INNER JOIN famille fa ON fa.ID_famille = ar.famille_id LEFT JOIN mark ma ON ma.ID_mark = ar.mark_id LEFT JOIN unite un ON un.ID_unite = ar.unite_id  ORDER BY ID_article DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllArticleFamilleMark($etat = 1)
    {
        $data = [];
        $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark 
        FROM article ar 
        JOIN entrepot_article ent ON ent.article_id = ar.ID_article AND ent.entrepot_id = :entrepot_id AND ent.etat_article = :etat_entrepot_article
        JOIN famille fa ON fa.ID_famille = ar.famille_id 
        JOIN mark ma ON ma.ID_mark = ar.mark_id  
        WHERE ar.etat_article = :etat  ORDER BY ID_article DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([
            'entrepot_id' => $_SESSION['entrepot_id'],
            'etat_entrepot_article' => STATUT[1],
            'etat' => STATUT[1]
        ]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getAllRealAchat($etat = 1)
    {
        $data = [];
        $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark 
        FROM entree e
        INNER JOIN article ar ON e.article_id = ar.ID_article
        INNER JOIN famille fa ON fa.ID_famille = ar.famille_id 
        INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  
        WHERE etat_article = ? group by ar.ID_article ORDER BY ID_article DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getListeVersement($idClient)
    {
        $data = [];
        $sql = "SELECT ver.*,em.code_employe FROM versement ver
        INNER JOIN employe em ON em.ID_employe = ver.employe_id 
        INNER JOIN client cl ON cl.ID_client = ver.client_id 
        WHERE cl.ID_client = ?  ORDER BY ver.created_at DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idClient]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getQteByComptablite($id)
    {
        $data = 0;
        $rest = [];
        $sql = "SELECT b.en_qte FROM bilan_entree b WHERE b.ID_article= ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $rest = $query->fetchAll();
            $data = $rest['en_qte'];
        }
        $query->closeCursor();
        return $data;
    }
    public static function getComptabiliteBilant()
    {
        $data = [];

        $sql = "SELECT * FROM comptabilite";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getSingleVenteArticle($id_sortie)
    {
        $data = [];
        $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar 
        INNER JOIN famille fa ON fa.ID_famille = ar.famille_id 
        INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  
        INNER JOIN sortie so ON so.article_id = ar.ID_article  
        WHERE so.ID_sortie = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_sortie]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getSingleAchatArticle($id_entree)
    {
        $data = [];
        $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark 
        FROM article ar 
        INNER JOIN famille fa ON fa.ID_famille = ar.famille_id 
        INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  
        INNER JOIN sortie so ON so.article_id = ar.ID_article  
        WHERE so.ID_sortie = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_entree]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }




    public static function getAllVenteCodeAndeTelephone($etat = 1)
    {
        $data = [];
        $sql = "SELECT ve.code_vente as code,cl.telephone_client as client FROM vente ve INNER JOIN client cl ON cl.ID_client = ve.client_id WHERE etat_vente = ?  ORDER BY ID_vente DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function singleAchat($id)
    {
        $data = [];
        // $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar INNER JOIN famille fa ON fa.ID_famille = ar.famille_id INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  WHERE etat_article = ?  ORDER BY ID_article DESC";
        $sql = "SELECT v.*, en.*, ar.libelle_article,fn.*,SUM(en.prix_achat * en.qte) as prix_total FROM achat v
        INNER JOIN entree en ON v.code_achat = en.achat_id 
        INNER JOIN article ar ON ar.ID_article = en.article_id
        INNER JOIN fournisseur fn ON fn.ID_fournisseur = v.fournisseur_id 
        WHERE v.code_achat =? 
        GROUP BY en.ID_entree
        ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }
    public static function singleVente($id)
    {
        $data = [];
        // $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar INNER JOIN famille fa ON fa.ID_famille = ar.famille_id INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  WHERE etat_article = ?  ORDER BY ID_article DESC";
        $sql = "SELECT v.*, so.*, ar.libelle_article,cl.*,SUM(so.prix_vente * so.qte) as prix_total FROM vente v
        INNER JOIN sortie so ON v.code_vente = so.vente_id 
        INNER JOIN article ar ON ar.ID_article = so.article_id
        INNER JOIN client cl ON cl.ID_client = v.client_id 
        WHERE v.code_vente =? 
        GROUP BY so.ID_sortie
        ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function singleVenteDetail($id)
    {
        $data = [];

        $sql = "SELECT DISTINCT ve.*,cl.*,em.telephone_employe AS tel, sum(so.qte * so.prix_vente) montant FROM vente ve 
        INNER JOIN sortie so ON so.vente_id = ve.code_vente
        INNER JOIN client cl ON cl.ID_client = ve.client_id
        INNER JOIN employe em ON em.ID_employe = ve.employe_id
        WHERE vente_id = ? AND ve.etat_vente = 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getPanierAchat($id_article, $entrepot)
    {
        $data = [];
        $sql = "SELECT ar.*, ent.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar 
         JOIN entrepot_article ent ON ent.article_id = ar.ID_article AND ent.entrepot_id = :entrepot_id
        JOIN famille fa ON fa.ID_famille = ar.famille_id INNER JOIN mark ma ON ma.ID_mark = ar.mark_id
        WHERE ar.ID_article IN($id_article)";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getPanierVente($id_article, $entrepot)
    {
        $data = [];
        $sql = "SELECT ar.*, ent.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar 
        JOIN entrepot_article ent ON ent.article_id = ar.ID_article AND ent.entrepot_id = :entrepot_id
        INNER JOIN famille fa ON fa.ID_famille = ar.famille_id INNER JOIN mark ma ON ma.ID_mark = ar.mark_id
        WHERE ar.ID_article IN($id_article)";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getApprovisionById($id_achat)
    {
        $data = [];
        $sql = "SELECT en.*,ar.libelle_article article, fa.libelle_famille famille, ma.libelle_mark mark FROM entree en  INNER JOIN article ar ON ar.ID_article = en.article_id
        INNER JOIN famille fa ON fa.ID_famille = ar.famille_id
        INNER JOIN mark ma ON ma.ID_mark = ar.mark_id
        WHERE en.achat_id = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_achat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllListeAchat($etat_achat = 1, $etat_entree = 1)
    {
        $data = [];
        $sql = "SELECT ac.*, SUM(en.qte) article,SUM(en.prix_achat * en.qte) total,fr.code_fournisseur 
        FROM achat ac 
        INNER JOIN entree en ON en.achat_id = ac.code_achat 
        INNER JOIN fournisseur fr ON fr.ID_fournisseur = ac.fournisseur_id 
        WHERE ac.etat_achat = ? AND en.etat_entree = ?  GROUP BY ac.ID_achat ORDER BY ac.ID_achat DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat_achat, $etat_entree]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getMinYear()
    {
        $data = "";
        $sql = "SELECT MIN(created_at) AS minime FROM achat";

        $query = self::getConnexion()->query($sql);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data["minime"];
    }

    public static function getTotalVenteByMonth($annee)
    {

        $sql = "SELECT  
            CASE MONTH(ve.created_at)
            WHEN 1 THEN 'janvier'
            WHEN 2 THEN 'février'
            WHEN 3 THEN 'mars'
            WHEN 4 THEN 'avril'
            WHEN 5 THEN 'mai'
            WHEN 6 THEN 'juin'
            WHEN 7 THEN 'juillet'
            WHEN 8 THEN 'aoûts'
            WHEN 9 THEN 'septembre'
            WHEN 10 THEN 'octobre'
            WHEN 11 THEN 'novembre' 
            ELSE 'décembre'
            END 
            AS
             mois,YEAR(ve.created_at) annee, SUM(so.prix_vente * qte)  AS total 
            FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente = 1
            GROUP BY YEAR(ve.created_at),  MONTH(ve.created_at) ";;

        if (!empty($annee)) {
            $sql .= " HAVING annee = $annee ";
        }
        $sql .= "ORDER BY YEAR(ve.created_at) DESC, MONTH(ve.created_at) ASC  LIMIT 12";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getTotalAchatByMonth($annee)
    {

        $sql = "SELECT  
        CASE MONTH(ac.created_at)
        WHEN 1 THEN 'janvier'
        WHEN 2 THEN 'février'
        WHEN 3 THEN 'mars'
        WHEN 4 THEN 'avril'
        WHEN 5 THEN 'mai'
        WHEN 6 THEN 'juin'
        WHEN 7 THEN 'juillet'
        WHEN 8 THEN 'aoûts'
        WHEN 9 THEN 'septembre'
        WHEN 10 THEN 'octobre'
        WHEN 11 THEN 'novembre' 
        ELSE 'décembre'
        END 
        AS
         mois,YEAR(ac.created_at) annee, SUM(en.prix_achat * qte)  AS total ,SUM(qte) AS qte
        FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id WHERE ac.etat_achat = 1
        GROUP BY YEAR(ac.created_at), MONTH(ac.created_at) ";;

        if (!empty($annee)) {
            $sql .= " HAVING annee = $annee ";
        }
        $sql .= "ORDER BY YEAR(ac.created_at) DESC, MONTH(ac.created_at) ASC  LIMIT 12";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }


    public static function getTotalVenteByMonthClient($id_client, $annee)
    {
        $data = [];
        $sql = "SELECT  
        CASE MONTH(ve.created_at)
        WHEN 1 THEN 'JAN'
        WHEN 2 THEN 'FEV'
        WHEN 3 THEN 'MAR'
        WHEN 4 THEN 'AVR'
        WHEN 5 THEN 'MAI'
        WHEN 6 THEN 'JUIN'
        WHEN 7 THEN 'JUIE'
        WHEN 8 THEN 'AOU'
        WHEN 9 THEN 'SEP'
        WHEN 10 THEN 'OCT'
        WHEN 11 THEN 'NOV' 
        ELSE 'DEC'
        END 
        AS
         mois,YEAR(ve.created_at) annee, SUM(so.prix_vente * qte)  AS total, ve.client_id 
        FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id
         WHERE ve.client_id = ? AND ve.etat_vente = 1 AND so.etat_sortie = 1
        GROUP BY YEAR(ve.created_at), MONTH(ve.created_at) ";
        if (!empty($annee)) {
            $sql .= " HAVING annee = $annee ";
        }

        $sql .= " ORDER BY YEAR(ve.created_at) DESC, MONTH(ve.created_at) ASC LIMIT 12";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_client]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getTotalAchatByMonthFournisseur($id_fournisseur, $annee)
    {
        $data = [];
        $sql = "SELECT  
        CASE MONTH(ac.created_at)
        WHEN 1 THEN 'JAN'
        WHEN 2 THEN 'FEV'
        WHEN 3 THEN 'MAR'
        WHEN 4 THEN 'AVR'
        WHEN 5 THEN 'MAI'
        WHEN 6 THEN 'JUIN'
        WHEN 7 THEN 'JUIE'
        WHEN 8 THEN 'AOU'
        WHEN 9 THEN 'SEP'
        WHEN 10 THEN 'OCT'
        WHEN 11 THEN 'NOV' 
        ELSE 'DEC'
        END 
        AS
         mois,YEAR(ac.created_at) annee, SUM(en.prix_achat * qte)  AS total, ac.fournisseur_id 
        FROM entree en INNER JOIN achat ac ON ac.code_achat = en.achat_id
         WHERE ac.fournisseur_id = ? AND ac.etat_achat = 1 AND en.etat_entree = 1
        GROUP BY YEAR(ac.created_at), MONTH(ac.created_at) ";
        if (!empty($annee)) {
            $sql .= " HAVING annee = $annee ";
        }

        $sql .= " ORDER BY YEAR(ac.created_at) DESC, MONTH(ac.created_at) ASC LIMIT 12";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_fournisseur]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }



    public static function getTotalVenteByWeek()
    {
        $data = [];
        // setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        // $sql = "SET lc_time_names = 'fr_FR' ;";

        $sql = "SELECT ve.created_at AS dates,SUM(so.prix_vente*so.qte) AS total,
        MONTH(ve.created_at) mois, WEEK(ve.created_at) periode, DAYNAME(ve.created_at) jour
        FROM sortie so 
        INNER JOIN vente ve ON ve.code_vente = so.vente_id
        WHERE (ve.etat_vente = 1 AND so.etat_sortie = 1)
        GROUP BY YEAR(ve.created_at),MONTH(ve.created_at),WEEK(ve.created_at),DAY(ve.created_at)
        HAVING WEEK(ve.created_at) = (SELECT MAX(WEEK(vente.created_at)) FROM vente WHERE YEAR(vente.created_at) = (SELECT MAX(YEAR(created_at)) FROM vente ))
        ORDER BY DAY(ve.created_at) ASC, ve.created_at DESC";

        // $sql = "SELECT DAYNAME(ve.created_at) AS  jour, WEEK(ve.created_at) periode, SUM(so.prix_vente * qte)  AS total 
        // FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente = 1
        // GROUP BY DAY(ve.created_at) HAVING  periode = (select MAX(WEEK(created_at)) semaine FROM vente)
        // ORDER BY DAY(ve.created_at) ASC LIMIT 7";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getCountNew($table)
    {
        $data = [];
        $date = date('Y-m-d');
        $sql = "SELECT COUNT(*) AS nbr FROM $table WHERE created_at = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$date]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data["nbr"];
    }

    public static function getTotalVenteByEmployeInMonth($p, $annee)
    {
        $data = [];
        $sql = "SELECT 
        -- MONTHNAME(ve.created_at)
        CASE MONTH(ve.created_at)
            WHEN 1 THEN 'Janvier'
            WHEN 2 THEN 'Février'
            WHEN 3 THEN 'Mars'
            WHEN 4 THEN 'Avril'
            WHEN 5 THEN 'Mai'
            WHEN 6 THEN 'Juin'
            WHEN 7 THEN 'Juillet'
            WHEN 8 THEN 'Août'
            WHEN 9 THEN 'Septembre'
            WHEN 10 THEN 'Octobre'
            WHEN 11 THEN 'Novembre'
            ELSE 'Décembre'
            END 
         AS
         periode,YEAR(ve.created_at) annee, SUM(so.prix_vente * qte)  AS total 
        FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id WHERE ve.etat_vente = 1 AND ve.employe_id = ?
        GROUP BY YEAR(ve.created_at), MONTH(ve.created_at) ";

        if (!empty($annee)) {
            $sql .= " HAVING annee = $annee ";
        }

        $sql .= " ORDER BY YEAR(ve.created_at) DESC, MONTH(ve.created_at) ASC  LIMIT 12";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$p]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllListeVente($etatvente = 1, $etatSortie = 1)
    {
        $data = [];
        $sql = "SELECT ve.*, SUM(so.qte) article,SUM(so.prix_vente * so.qte) total, cl.nom_client,
        cl.prenom_client,cl.telephone_client,cl.code_client
        FROM vente ve INNER JOIN sortie so ON so.vente_id = ve.code_vente
        INNER JOIN client cl ON cl.ID_client = ve.client_id
        WHERE ve.etat_vente = ? AND so.etat_sortie = ?  GROUP BY ve.ID_vente ORDER BY ve.ID_vente DESC";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etatvente, $etatSortie]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllListeVenteClient($id_client, $etatvente = 1, $etatSortie = 1)
    {
        $data = [];
        $sql = "SELECT ve.*, COUNT(so.ID_sortie) article,SUM(so.prix_vente * so.qte) total
        FROM vente ve INNER JOIN sortie so ON so.vente_id = ve.code_vente
        INNER JOIN client cl ON cl.ID_client = ve.client_id
        WHERE ve.client_id= ? AND ve.etat_vente = ? AND so.etat_sortie = ?  GROUP BY ve.ID_vente ORDER BY ve.ID_vente DESC";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_client, $etatvente, $etatSortie]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllListeCommande($idclient)
    {
        $data = [];
        $sql = "SELECT ve.*,so.etat_sortie,SUM(so.prix_vente * so.qte) total
        FROM vente ve 
        INNER JOIN sortie so ON so.vente_id = ve.code_vente
        WHERE  so.etat_sortie=1
        GROUP BY ve.ID_vente
        HAVING (ve.client_id = ? and ve.etat_vente=2)
        ORDER BY ve.ID_vente DESC";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idclient]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getBilanClient($idclient, $etat_vente = 1, $etat_sortie = 1)
    {
        $data = [];
        $sql = "SELECT SUM(so.qte) AS qte ,SUM(so.prix_vente * so.qte) total,ve.client_id
        FROM sortie so
        INNER JOIN vente ve ON so.vente_id = ve.code_vente
        WHERE  ve.etat_vente = ? AND so.etat_sortie= ?
        GROUP BY ve.client_id
        HAVING ve.client_id = ?";;
        $query = self::getConnexion()->prepare($sql);
        $query->bindParam(1, $etat_vente);
        $query->bindParam(2, $etat_sortie);
        $query->bindParam(3, $idclient);
        $query->execute();

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }
    public static function getBilanClientNbre($idclient)
    {
        $data = [];
        $sql = "SELECT COUNT(ve.ID_vente) AS nb_vente,ve.client_id
        FROM vente ve WHERE ve.etat_vente =1 AND ve.client_id = ?";;
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idclient]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getEmployeVente($idvente)
    {
        $data = [];
        $sql = "SELECT ve.employe_id AS employe FROM vente ve WHERE code_vente = ?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$idvente]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getDetailVente($id_vente, $entrepot, $etat = 1)
    {
        $data = [];
        $sql = "SELECT ent.*, so.*,ve.entrepot_id,ve.created_at AS date_vente,ar.libelle_article article,ent.garantie_article garantie, fa.libelle_famille famille, ma.libelle_mark mark FROM sortie so  
        INNER JOIN article ar ON ar.ID_article = so.article_id
        JOIN famille fa ON fa.ID_famille = ar.famille_id
        JOIN mark ma ON ma.ID_mark = ar.mark_id
        JOIN vente ve ON ve.code_vente = so.vente_id
        JOIN entrepot_article ent ON ve.entrepot_id = ent.entrepot_id
        WHERE ve.entrepot_id = :entrepot_id AND ve.code_vente = :code_vente AND so.etat_sortie= :etat GROUP BY ve.code_vente, so.ID_sortie ORDER BY ar.libelle_article";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot, 'code_vente' => $id_vente, 'etat' => $etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getDetailAchat($id_achat, $entrepot, $etat = 1)
    {
        $data = [];
        $sql = "SELECT en.*, ac.entrepot_id, ac.created_at AS date_achat,ar.libelle_article article,ent.garantie_article garantie, fa.libelle_famille famille, ma.libelle_mark mark 
        FROM entree en  
		JOIN article ar ON ar.ID_article = en.article_id
        JOIN famille fa ON fa.ID_famille = ar.famille_id
        JOIN mark ma ON ma.ID_mark = ar.mark_id
        JOIN achat ac ON ac.code_achat = en.achat_id
        JOIN entrepot_article ent ON ac.entrepot_id = ent.entrepot_id
        WHERE ac.entrepot_id = :entrepot_id AND  ac.code_achat = :code_achat AND en.etat_entree= :etat GROUP BY ac.code_achat, en.ID_entree ORDER BY ar.libelle_article";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot, 'code_achat' => $id_achat, 'etat' => $etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();
        return $data;
    }






    public static function loginEmployer($telephone, $password)
    {
        $data = [];
        $sql = "SELECT emp.*, r.libelle_role role FROM employe emp INNER JOIN role r ON r.ID_role = emp.role_id  WHERE emp.telephone_employe = ? AND emp.password_employe = ? AND etat_employe = 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($telephone, $password));

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function listeVersementByClasse($ref, $val)
    {
        $tab = [];
        $sql = "SELECT ver.*,el.ID_eleve,el.nom_eleve,el.prenom_eleve,el.mat_eleve,el.statut_eleve, cl.*,ins.ID_inscrire inscrire, ins.montant_inscrire FROM versement ver
        INNER JOIN inscrire ins  ON ins.ID_inscrire = ver.ID_inscrire
        INNER JOIN eleve el  ON ins.ID_eleve = el.ID_eleve
        INNER JOIN classe cl  ON cl.ID_classe = ins.ID_classe
        INNER JOIN annee an  ON ins.ID_annee = an.ID_annee
        WHERE an.etat_annee = 1 AND $ref LIKE '%" . $val . "%' ";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute([]);
            if ($query->rowCount() > 0) {
                $tab = $query->fetchALl();
            }
        } catch (Exception $e) {
            die('Erreur de recherche ' . $e->getMessage());
        }
        return $tab;
    }

    public static function getAllLike($table, $c1, $c2, $v1, $v2)
    {
        $sql = "SELECT * FROM $table WHERE $c1 LIKE '%-$v1-%' AND $c2 = ? ";
        $table = array($v2);
        $query = self::getConnexion()->prepare($sql);
        $query->execute($table);
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        $query->closeCursor();
        return $tab;
    }

    public static function getAllByItem($table, $libelle, $value)
    {
        $sql = "SELECT * FROM $table WHERE $libelle = ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($value));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        $query->closeCursor();
        return $tab;
    }

    public static function getAllByItemsa($table, $libelle, $value)
    {
        $sql = "SELECT * FROM $table WHERE $libelle = ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($value));
        $data = array();
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    //annee combo
    public static function combobox_element()
    {
        foreach (self::getAllByItem("annee", "etat_annee", 1) as $value) {
            echo '<option value ="' . $value['ID_annee'] . '">' . ($value['libelle_annee'] - 1) . '-' . ($value['libelle_annee']) . '</option>';
        }
    }




    public static function getLastIdRecord($table, $libelle)
    {
        $sql = "SELECT $libelle FROM $table ORDER BY $libelle DESC LIMIT 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $tab = '';
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab = $data[$libelle];
            }
        }
        return $tab;
    }






    public static function libelle($table, $libelle, $ref, $value)
    {
        $data = "";
        $sql = "SELECT $libelle as libelle FROM $table WHERE $ref = ? LIMIT 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($value));
        $d = $query->fetch();

        if (!empty($d)) {
            $data = $d['libelle'];
        }
        $query->closeCursor();
        return $data;
        // return 2;
    }
    public static function libelleExiste($table, $ref, $value)
    {
        $result = false;
        $sql = "SELECT * FROM $table WHERE $ref = ? LIMIT 1";
        try {
            $query = self::getConnexion()->prepare($sql);
            $query->execute(array($value));
            if ($query->rowCount() > 0) {
                $result = true;
            }
        } catch (Exception $e) {
            die('erreur ' . $e->getMessage());
        }
        $query->closeCursor();
        return $result;
    }

    public static function getNombre($table)
    {
        $sql = "SELECT COUNT(*) AS nb FROM $table";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $data = $query->fetch();
        $query->closeCursor();
        return $data['nb'];
    }


    public static function getSommeByIns($inscrire)
    {
        $sql = "SELECT SUM(montant_versement) AS mtt FROM versement WHERE ID_inscrire = ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($inscrire));
        $data = $query->fetch();
        $query->closeCursor();
        return $data['mtt'];
    }

    public static function getSommeDep($annee)
    {
        $sql = "SELECT SUM(montant_depense) AS mtt FROM depenses WHERE annee = ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($annee));
        $data = $query->fetch();
        $query->closeCursor();
        return $data['mtt'];
    }

    public static function getAllVersement()
    {
        $sql = "SELECT SUM(montant_versement) as montant FROM annee a,versement v,inscrire i WHERE a.ID_annee=i.ID_annee AND v.ID_inscrire=i.ID_inscrire AND a.etat_annee =1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $data = $query->fetch();
        $query->closeCursor();
        return $data['montant'];
    }

    public static function insert($table, array $data)
    {
        $sql = "INSERT INTO $table (";
        $a = 0;
        foreach ($data as $key) {
            $a++;
        }

        $n = 0;
        foreach ($data as $key => $value) {
            $n++;
            if ($a == $n)
                $sql .= $key;
            else
                $sql .= $key . ",";
        }
        $sql .= ") VALUES(";
        for ($i = 1; $i <= $n; $i++) {
            if ($i == $n)
                $sql .= "?";
            else
                $sql .= "?,";
        }
        $sql .= ")";
        $tableau = array();

        $x = 0;
        foreach ($data as $key => $value) {
            $tableau[$x] = $value;
            $x++;
        }

        try {
            $query = self::getConnexion()->prepare($sql);
            if ($query->execute($tableau)) {
                self::$lastId = self::getConnexion()->lastInsertId();
                return true;
            } else
                return false;
        } catch (Exception $e) {
            die('erreur d\'insertion ' . $e->getMessage());
        }
    }

    public static function update($table, array $data)
    {
        $sql = "UPDATE $table SET ";
        $a = count($data);

        $n = 0;
        $ref = "";
        foreach ($data as $key => $value) {
            $n++;
            if ($n == ($a - 1))
                $sql .= $key . " = ? ";
            elseif ($n == $a)
                $ref = $key;
            else
                $sql .= $key . " = ?,";
        }
        $sql .= "WHERE $ref = ?";

        $tableau = array();
        $x = 0;
        foreach ($data as $key => $value) {
            $tableau[$x] = $value;
            $x++;
        }

        $query = self::getConnexion()->prepare($sql);

        if ($query->execute($tableau))
            return true;
        else
            return false;
    }

    public static function inserted($table, array $data)
    {
        if (empty($data)) {
            throw new Exception("Aucune donnée à insérer");
        }

        // Colonnes
        $columns = implode(', ', array_keys($data));

        // Placeholders (?, ?, ?)
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $query = self::getConnexion()->prepare($sql);

        $query->execute(array_values($data));

        return self::getConnexion()->lastInsertId();
    }

    public static function insertMultiple($table, array $rows)
    {
        if (empty($rows)) {
            throw new Exception("Aucune donnée à insérer");
        }

        // Colonnes (on prend celles de la première ligne)
        $columns = array_keys($rows[0]);
        $columnsList = implode(', ', $columns);

        // (?, ?, ?)
        $placeholders = '(' . implode(', ', array_fill(0, count($columns), '?')) . ')';

        // Générer (?, ?), (?, ?), (?, ?)
        $allPlaceholders = implode(', ', array_fill(0, count($rows), $placeholders));

        $sql = "INSERT INTO $table ($columnsList) VALUES $allPlaceholders";

        // Aplatir les valeurs
        $values = array_merge(...array_map(fn($row) => array_values($row), $rows));

        $query = self::getConnexion()->prepare($sql);

        return $query->execute($values);
    }

    public static function updated($table, array $data, array $where)
    {
        // SET part
        $set = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));

        // WHERE part
        $conditions = implode(' AND ', array_map(fn($col) => "$col = ?", array_keys($where)));

        $sql = "UPDATE $table SET $set WHERE $conditions";

        // Fusion des valeurs
        $values = array_merge(array_values($data), array_values($where));

        $query = self::getConnexion()->prepare($sql);

        return $query->execute($values);
    }

    public static function delete($table, array $data)
    {
        $sql = "DELETE FROM $table ";

        $n = 0;
        $ref = "";
        foreach ($data as $key => $value) {
            $ref = $key;
        }
        $sql .= "WHERE $ref = ?";

        $tableau = array();
        $x = 0;
        foreach ($data as $key => $value) {
            $tableau[$x] = $value;
            $x++;
        }
        //var_dump($tableau);
        $query = self::getConnexion()->prepare($sql);

        if ($query->execute($tableau))
            return true;
        else
            return false;
    }

    public static function vue_globale($annee, $ecole)
    {
        $result = [];
        $sql = "SELECT c.libelle_classe AS libelle,c.ID_classe AS IDC ,COUNT(c.ID_classe) AS nb, SUM(i.montant_sco) AS montant FROM inscrire i,ecole e,annee a,classe c WHERE e.ID_ecole =c.ID_ecole AND c.ID_classe=i.ID_classe AND a.ID_annee=i.ID_annee AND e.ID_ecole = ? AND a.ID_annee = ? GROUP BY c.ID_classe";
        $statement = self::getConnexion()->prepare($sql);
        $statement->execute(array($ecole, $annee));
        while ($data = $statement->fetch()) {
            $result[] = $data;
        }
        return $result;
    }

    public static function montant_globale_verse_by_classe($annee, $classe)
    {
        $result = 0;
        $query = "SELECT SUM(montant_versement) AS montant FROM versement v, inscrire i,classe c WHERE c.ID_classe=i.ID_classe AND i.ID_inscrire=v.ID_inscrire AND i.ID_annee = ? AND c.ID_classe =? GROUP BY c.ID_classe";
        $statement = self::getConnexion()->prepare($query);
        $statement->execute(array($annee, $classe));
        while ($data = $statement->fetch()) {
            $result = $data['montant'];
        }
        return $result;
    }

    public static function verifParams()
    {
        if (isset($_POST) && sizeof($_POST) > 0) {
            foreach ($_POST as $key => $value) {
                //var_dump($va);die();
                $data = trim($value);
                $data = stripslashes($data);
                $data = strip_tags($data);
                $data = htmlspecialchars($data);
                $_POST[$key] = $data;
            }
            //print_r($_POST);exit();
        }

        if (isset($_GET) && sizeof($_GET) > 0) {
            foreach ($_GET as $key => $value) {
                $data = trim($value);
                $data = stripslashes($data);
                $data = strip_tags($data);
                $data = htmlspecialchars($data);
                $_GET[$key] = $data;
            }
            //print_r($_POST);exit();
        }
    }

    public static function getByItem($table, $ref, $value)
    {

        $sql = "SELECT * FROM $table WHERE $ref = :value ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array('value' => $value));
        $data = $query->fetch();
        $query->closeCursor();
        return $data;
    }

    public static function getItem($table, $libelle, $ref, $value)
    {

        $sql = "SELECT $libelle FROM $table WHERE $ref = :value ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array('value' => $value));
        $data = $query->fetch();
        $query->closeCursor();
        return $data[$libelle];
    }
    public static function getElementSingle($table, $ref, $value)
    {
        $data = [];

        $sql = "SELECT * FROM $table WHERE $ref = :ref ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array('ref' => $value));
        if ($query->rowCount() > 0)
            $data = $query->fetch(PDO::FETCH_ASSOC);

        $query->closeCursor();
        return $data;
    }

    public static function getAllBetweenByItem($table, $lib, $clause, $d1, $d2, $value)
    {
        $sql = "SELECT * FROM $table WHERE $lib BETWEEN :d1 AND :d2 AND $clause = :value";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array('d1' => $d1, 'd2' => $d2, 'value' => $value));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }
    public static function getAllBetweenBy($table, $lib, $clause, $d1, $d2)
    {
        $sql = "SELECT * FROM $table WHERE $lib BETWEEN ? AND ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($d1, $d2));
        $tab = array();
        if ($query->rowCount() > 0) {
            while ($data = $query->fetch()) {
                $tab[] = $data;
            }
        }
        return $tab;
    }

    public static function existeDate($table, $lib, $clause, $d1, $d2)
    {
        $sql = "SELECT * FROM $table WHERE $lib BETWEEN ? AND ? ";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(array($d1, $d2));
        $query->execute($table);
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function getAllTable($table, $etat, $val = 1)
    {
        $data = [];
        $sql = "SELECT * FROM $table WHERE $etat=?";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$val]);
        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getAllByElement($table, $element, $val)
    {
        $data = [];
        $sql = "SELECT * FROM $table WHERE $element = :val";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['val' => $val]);
        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();
        return $data;
    }
    // get all table by 2 elements 
    public static function getAllTableByClauses($table, $clause1, $val1, $clause2, $val2)
    {
        $data = [];
        $sql = "SELECT * FROM $table WHERE $clause1 =:val1 AND $clause2 =:val2";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['val1' => $val1, 'val2' => $val2]);
        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();
        return $data;
    }




    public static function dateDiff(String $dateDepart, string $duree, $dateActu = ''): bool
    {

        $retour = false;
        $dateActu = !empty($dateActu) ? $dateActu : date('d-m-Y H:i:s');
        $dateDepartTimestamp = strtotime($dateDepart);

        //on calcule la date de fin
        $dateFin = date('d-m-Y', strtotime('+' . $duree . 'month', $dateDepartTimestamp));
        if (strtotime($dateFin) >= strtotime($dateActu)) {
            $retour = true;
        }

        return $retour;
    }

    public static function getInfoBoutique()
    {
        $data = [];
        // $sql = "SELECT ar.*, fa.libelle_famille famille, ma.libelle_mark mark FROM article ar INNER JOIN famille fa ON fa.ID_famille = ar.famille_id INNER JOIN mark ma ON ma.ID_mark = ar.mark_id  WHERE etat_article = ?  ORDER BY ID_article DESC";
        $sql = "SELECT * FROM config";

        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data;
    }

    public static function getState($libelle)
    {

        $data = "";
        $sql = "SELECT $libelle FROM config LIMIT 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $data = $query->fetch();
        $query->closeCursor();
        return $data[$libelle];
    }



    public static function getInfoFournisseur($codeFournisseur)
    {
        $data = [];
        $sql = 'SELECT * FROM fournisseur  WHERE code_fournisseur = ?  LIMIT 1 ';
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$codeFournisseur]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();

        return $data;
    }

    public static function getAllListeBonCommandeFournisseur($dateStart, $dateEnd)
    {
        $data = [];
        $sql = 'SELECT ach.*, 
            SUM(en.qte) AS article,
            SUM(en.prix_achat * en.qte) AS total,
            -- ach._achat,ach.created_at,
            fr.nom_fournisseur AS fournisseur, CONCAT(emp.nom_employe, " ", emp.prenom_employe) AS employe
            FROM achat ach 
            JOIN entree en ON en.achat_id = ach.code_achat
            JOIN fournisseur fr ON fr.ID_fournisseur = ach.fournisseur_id
            JOIN employe emp ON emp.ID_employe = ach.employe_id
            WHERE DATE(ach.created_at) BETWEEN :dateStart AND :dateEnd
            GROUP BY ach.ID_achat 
            ORDER BY ach.ID_achat DESC';

        $query = self::getConnexion()->prepare($sql);
        $query->execute(['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();

        return $data;
    }


    public static function getSingleDataBonCommandeFournisseur($code_achat)
    {
        $data = [];
        $sql = 'SELECT ach.*, 
            SUM(en.qte) AS article,
            SUM(en.prix_achat * en.qte) AS total,
            -- ach._achat,ach.created_at,
            fr.nom_fournisseur AS fournisseur, CONCAT(emp.nom_employe, " ", emp.prenom_employe) AS employe
            FROM achat ach 
            JOIN entree en ON en.achat_id = ach.code_achat
            JOIN fournisseur fr ON fr.ID_fournisseur = ach.fournisseur_id
            JOIN employe emp ON emp.ID_employe = ach.employe_id
            WHERE ach.code_achat = :code_achat
            GROUP BY ach.ID_achat';

        $query = self::getConnexion()->prepare($sql);
        $query->execute(['code_achat' => $code_achat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();

        return $data;
    }


    public static function getAllListeBonCommandeClient($dateStart, $dateEnd, $entrepot)
    {
        $data = [];
        $sql = 'SELECT ve.*, 
                COALESCE(SUM(so.qte),0) AS article,
                   COALESCE(SUM(so.prix_vente * so.qte),0) AS total,
                --    ve._vente,ve.created_at,
            COALESCE(CONCAT(cl.nom_client, " ", cl.prenom_client),"inconnu") AS client, CONCAT(emp.nom_employe, " ", emp.prenom_employe) AS employe
            FROM vente ve 
            JOIN sortie so ON so.vente_id = ve.code_vente
            JOIN client cl ON cl.ID_client = ve.client_id
            JOIN employe emp ON emp.ID_employe = ve.employe_id
            WHERE ve.entrepot_id = :entrepot_id AND DATE(ve.created_at) BETWEEN :dateStart AND :dateEnd
            GROUP BY ve.ID_vente 
            ORDER BY ve.ID_vente DESC';

        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();

        return $data;
    }


    public static function getSingleVenteByCode($codeVente)
    {
        $data = [];
        $sql = 'SELECT
            v.code_vente AS reference,
            v.statut_vente,
            v.pay_mode AS mode_paiement,
            v.created_at AS date_emission,
            CONCAT(c.nom_client, \' \', c.prenom_client) AS nom_client,
            c.telephone_client AS telephone_client,
            c.email_client AS email_client,
            e.nom_employe AS fait_par,   -- si vous avez une table employe
            SUM(s.prix_vente * s.qte) AS total_ttc,
            ent.libelle_entrepot AS entrepot
        FROM vente v
        JOIN client c ON v.client_id = c.ID_client
        LEFT JOIN sortie s ON s.vente_id = v.code_vente
        LEFT JOIN entrepot ent ON ent.ID_entrepot = v.entrepot_id
        LEFT JOIN employe e ON e.ID_employe = v.employe_id  -- si table employe existe
        WHERE v.code_vente = :codeVente
        ';
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['codeVente' => $codeVente]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();

        return $data;
    }

    public static function getSingleAchatByCode($codeVente)
    {
        $data = [];
        $sql = 'SELECT
            a.code_achat AS reference,
            a.statut_achat,
            a.pay_mode AS mode_paiement,
            a.created_at AS date_emission,
            fn.nom_fournisseur,
            fn.telephone_fournisseur AS telephone_fournisseur,
            fn.email_fournisseur AS email_fournisseur,
            e.nom_employe AS fait_par,   -- si vous avez une table employe
            SUM(s.prix_achat * s.qte) AS total_ttc,
            ent.libelle_entrepot AS entrepot
        FROM achat a
        JOIN fournisseur fn ON a.fournisseur_id = fn.ID_fournisseur
        LEFT JOIN entree s ON s.achat_id = a.code_achat
        LEFT JOIN entrepot ent ON ent.ID_entrepot = a.entrepot_id
        LEFT JOIN employe e ON e.ID_employe = a.employe_id  -- si table employe existe
        WHERE a.code_achat = :codeAchat
        ';
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['codeAchat' => $codeVente]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();

        return $data;
    }

    // public static function getAllArticleByVenteCode($codeVente)
    // {
    //     $data = [];
    //     $sql = 'SELECT
    //         a.libelle_article AS article,
    //         a.garantie_article AS garantie,
    //         m.libelle_mark AS mark,
    //         f.libelle_famille AS famille,
    //         s.prix_vente AS `prix_vente`,
    //         s.qte ,
    //         s.da
    //         (s.prix_vente * s.qte) AS total,
    //         s.ID_sortie
    //     FROM sortie s
    //     JOIN article a ON s.article_id = a.ID_article
    //     LEFT JOIN mark m ON a.mark_id = m.ID_mark
    //     LEFT JOIN famille f ON a.famille_id = f.ID_famille
    //     WHERE s.vente_id = :codeVente';
    //     $query = self::getConnexion()->prepare($sql);
    //     $query->execute(['codeVente' => $codeVente]);

    //     if ($query->rowCount() > 0) {
    //         $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //     }
    //     $query->closeCursor();

    //     return $data;
    // }

    public static function getAllListeVenteByDateRange($startDate, $endDate, $etatvente = 1, $etatSortie = 1)
    {
        $data = [];
        $sql = 'SELECT ve.*, 
                   SUM(so.qte) AS article,
                   SUM(so.prix_vente * so.qte) AS total,
                --    ve._vente,ve.created_at,
                   cl.nom_client, cl.prenom_client, cl.telephone_client, cl.code_client
            FROM vente ve 
            INNER JOIN sortie so ON so.vente_id = ve.code_vente
            INNER JOIN client cl ON cl.ID_client = ve.client_id
            WHERE ve.etat_vente = ? 
              AND so.etat_sortie = ? 
              AND DATE(ve.created_at) BETWEEN ? AND ?
            GROUP BY ve.ID_vente 
            ORDER BY ve.ID_vente DESC';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etatvente, $etatSortie, $startDate, $endDate]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();

        return $data;
    }

    public static function getAllListeVenteByDateRangeByArticle($startDate, $endDate, $etatvente = 1, $etatSortie = 1)
    {
        $data = [];
        $sql = 'SELECT 
                ar.ID_article,
                ar.libelle_article,
                SUM(so.qte) AS article,
                SUM(so.prix_vente * so.qte) AS total
            FROM sortie so
            INNER JOIN vente ve ON so.vente_id = ve.code_vente
            INNER JOIN article ar ON so.article_id = ar.ID_article
            INNER JOIN client cl ON ve.client_id = cl.ID_client
            WHERE ve.etat_vente = ? 
              AND so.etat_sortie = ? 
              AND DATE(ve.created_at) BETWEEN ? AND ?
            GROUP BY so.article_id
            ORDER BY ar.libelle_article ASC';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etatvente, $etatSortie, $startDate, $endDate]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();

        return $data;
    }


    public static function getTotauxVenteByDateRange($startDate, $endDate, $etatvente = 1, $etatSortie = 1)
    {
        $sql = 'SELECT 
                COUNT(DISTINCT ve.ID_vente) AS nb_ventes,
                SUM(so.qte) AS total_articles,
                SUM(so.prix_vente * so.qte) AS total_montant
            FROM vente ve
            INNER JOIN sortie so ON so.vente_id = ve.code_vente
            WHERE ve.etat_vente = ? 
              AND so.etat_sortie = ? 
              AND DATE(ve.created_at) BETWEEN ? AND ?';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etatvente, $etatSortie, $startDate, $endDate]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();

        return [
            'nb_ventes' => $result['nb_ventes'] ?? 0,
            'total_articles' => $result['total_articles'] ?? 0,
            'total_montant' => $result['total_montant'] ?? 0,
        ];
    }

    public static function getTotauxVenteByDateRangeByArticle($startDate, $endDate, $etatvente = 1, $etatSortie = 1)
    {
        $sql = 'SELECT 
                COUNT(DISTINCT ve.ID_vente) AS nb_ventes,
                SUM(so.qte) AS total_articles,
                SUM(so.prix_vente * so.qte) AS total_montant
            FROM vente ve
            INNER JOIN sortie so ON so.vente_id = ve.code_vente
            WHERE ve.etat_vente = ? 
              AND so.etat_sortie = ? 
              AND DATE(ve.created_at) BETWEEN ? AND ?';
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etatvente, $etatSortie, $startDate, $endDate]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();

        return [
            'nb_ventes' => $result['total_articles'] ?? 0,
            // 'total_articles' => $result['total_articles'] ?? 0,
            'total_montant' => $result['total_montant'] ?? 0,
        ];
    }


    // public static function getAllListeAchatByDateRange($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    // {
    //     $data = [];

    //     $sql = 'SELECT ac.*, SUM(en.qte) article, SUM(en.prix_achat * en.qte) total, fr.code_fournisseur
    //         FROM achat ac
    //         INNER JOIN entree en ON en.achat_id = ac.code_achat
    //         INNER JOIN fournisseur fr ON fr.ID_fournisseur = ac.fournisseur_id
    //         WHERE ac.etat_achat = ? 
    //           AND en.etat_entree = ? 
    //           AND DATE(ac.created_at) BETWEEN ? AND ?
    //         GROUP BY ac.ID_achat
    //         ORDER BY ac.ID_achat DESC';

    //     $query = self::getConnexion()->prepare($sql);
    //     $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

    //     if ($query->rowCount() > 0) {
    //         $data = $query->fetchAll();
    //     }

    //     $query->closeCursor();

    //     return $data;
    // }

    public static function getAllListeAchatByDateRange($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    {
        $data = [];

        $sql = 'SELECT ac.*, SUM(en.qte) article, SUM(en.prix_achat * en.qte) total, fr.code_fournisseur
            FROM achat ac
            INNER JOIN entree en ON en.achat_id = ac.code_achat
            INNER JOIN fournisseur fr ON fr.ID_fournisseur = ac.fournisseur_id
            WHERE ac.etat_achat = ? 
              AND en.etat_entree = ? 
              AND DATE(ac.created_at) BETWEEN ? AND ?
            GROUP BY ac.ID_achat
            ORDER BY ac.ID_achat DESC';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }

        $query->closeCursor();

        return $data;
    }
    public static function getAllListeAchatByDateRangeByArticle($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    {
        $data = [];

        $sql = 'SELECT 
            ar.ID_article,
            ar.libelle_article,
            fr.code_fournisseur,
            SUM(en.qte) AS article,
            SUM(en.prix_achat * en.qte) AS total
            FROM entree en
            INNER JOIN achat ac ON en.achat_id = ac.code_achat
            INNER JOIN fournisseur fr ON ac.fournisseur_id = fr.ID_fournisseur
            INNER JOIN article ar ON en.article_id = ar.ID_article
            WHERE ac.etat_achat = ?
            AND en.etat_entree = ?
            AND DATE(ac.created_at) BETWEEN ? AND ?
            GROUP BY en.article_id, ac.fournisseur_id
            ORDER BY ar.libelle_article ASC;
        ';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }

        $query->closeCursor();

        return $data;
    }

    public static function getTotauxAchatByDateRange($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    {
        $data = [];

        $sql = 'SELECT SUM(en.qte) article, SUM(en.prix_achat * en.qte) total
            FROM achat ac
            INNER JOIN entree en ON en.achat_id = ac.code_achat
            INNER JOIN fournisseur fr ON fr.ID_fournisseur = ac.fournisseur_id
            WHERE ac.etat_achat = ? 
              AND en.etat_entree = ? 
              AND DATE(ac.created_at) BETWEEN ? AND ?
           ';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }

        $query->closeCursor();

        return $data;
    }
    // public static function getTotauxAchatByDateRange($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    // {
    //     $data = [];

    //     $sql = 'SELECT SUM(en.qte) article, SUM(en.prix_achat * en.qte) total
    //         FROM achat ac
    //         INNER JOIN entree en ON en.achat_id = ac.code_achat
    //         INNER JOIN fournisseur fr ON fr.ID_fournisseur = ac.fournisseur_id
    //         WHERE ac.etat_achat = ? 
    //           AND en.etat_entree = ? 
    //           AND DATE(ac.created_at) BETWEEN ? AND ?
    //       ';

    //     $query = self::getConnexion()->prepare($sql);
    //     $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

    //     if ($query->rowCount() > 0) {
    //         $data = $query->fetch();
    //     }

    //     $query->closeCursor();

    //     return $data;
    // }

    // public static function getAllListeAchatByDateRangeGroupByArticle($startDate, $endDate, $etat_achat = 1, $etat_entree = 1)
    // {
    //     $data = [];

    //     $sql = 'SELECT 
    //         ar.ID_article,
    //         ar.libelle_article,
    //         fr.code_fournisseur,
    //         SUM(en.qte) AS nb_article,
    //         SUM(en.prix_achat * en.qte) AS total
    //         FROM entree en
    //         INNER JOIN achat ac ON en.achat_id = ac.code_achat
    //         INNER JOIN fournisseur fr ON ac.fournisseur_id = fr.ID_fournisseur
    //         INNER JOIN article ar ON en.article_id = ar.ID_article
    //         WHERE ac.etat_achat = ?
    //         AND en.etat_entree = ?
    //         AND DATE(ac.created_at) BETWEEN ? AND ?
    //         GROUP BY en.article_id, ac.fournisseur_id
    //         ORDER BY ar.libelle_article ASC;
    //     ';

    //     $query = self::getConnexion()->prepare($sql);
    //     $query->execute([$etat_achat, $etat_entree, $startDate, $endDate]);

    //     if ($query->rowCount() > 0) {
    //         $data = $query->fetchAll();
    //     }

    //     $query->closeCursor();

    //     return $data;
    // }

    public static function formatGain($value)
    {
        $gain = $value;
        if ($gain > 0) {
            return '<span class="text-success">+ ' . number_format($gain, 0, ',', ' ') . '</span>';
        } elseif ($gain < 0) {
            return '<span style="color:red;">- ' . number_format(abs($gain), 0, ',', ' ') . '</span>';
        } else {
            return '<span>' . number_format($gain, 0, ',', ' ') . '</span>';
        }
    }


    public static function getSingleDepense($id_depense)
    {
        $data = [];
        $sql = 'SELECT *, date(d.periode) AS periode_depense FROM depense d JOIN type_depense td ON td.ID_type = d.type_id WHERE d.ID_depense = ? LIMIT 1';
        $query = self::getConnexion()->prepare($sql);
        $query->execute([$id_depense]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();

        return $data;
    }


    public static function getAllByFromTable($table, $libelle)
    {
        $sql = "SELECT * FROM $table ORDER BY $libelle ASc";
        $query = self::getConnexion()->prepare($sql);
        $query->execute();
        $tab = [];
        if ($query->rowCount() > 0) {
            $tab = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();

        return $tab;
    }

    public static function getDepenseByMouth($startDate, $endDate, $etat = 1)
    {
        $data = [];

        $sql = 'SELECT SUM(d.montant) total
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id
            WHERE  DATE(d.periode) BETWEEN ? AND ?
            AND d.etat_depense = ?
            ';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$startDate, $endDate, $etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }

        $query->closeCursor();

        return $data;
    }

    public static function getTotauxDepenseByMouth($startDate, $endDate, $etat = 1)
    {
        $data = [];

        $sql = 'SELECT SUM(d.montant) total
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id
            WHERE  DATE(d.periode) BETWEEN ? AND ?
            AND d.etat_depense = ?
            ';

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$startDate, $endDate, $etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }

        $query->closeCursor();

        return $data;
    }
    public static function getDepensesByMouth($startDate, $endDate, $etat = 1)
    {
        $data = [];

        $sql = "SELECT d.*,t.*, CONCAT(e.nom_employe,' ',prenom_employe) AS employe
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id
            JOIN employe e ON e.id_employe = d.employe_id
            WHERE  DATE(d.periode) BETWEEN ? AND ?
            AND d.etat_depense = ?
            GROUP BY d.ID_depense ORDER BY d.ID_depense DESC
            ";

        $query = self::getConnexion()->prepare($sql);
        $query->execute([$startDate, $endDate, $etat]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $query->closeCursor();

        return $data;
    }

    public static function getAllListeDepenses($startDate, $endDate, $entrepot = null)
    {
        $data = [];

        $params = [];
        $sql = "SELECT d.*,t.*, CONCAT(e.nom_employe,' ',prenom_employe) AS employe
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id
            JOIN employe e ON e.id_employe = d.employe_id
        WHERE  DATE(d.date_created) BETWEEN :startDate AND :endDate ";
        $params = ['startDate' => $startDate, 'endDate' => $endDate];


        if (!empty($entrepot)) {
            $sql .= " AND d.entrepot_id = :entrepot_id";
            $params['entrepot_id'] = $entrepot;
        }

        $query = self::getConnexion()->prepare($sql);
        $query->execute($params);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $query->closeCursor();

        return $data;
    }

    public static function getTotalDepenseAny($startDate, $endDate, $statut, $entrepot = null)
    {
        $data = [];

        $sql = 'SELECT  COALESCE(SUM(d.montant),0) montant_depense,  COALESCE(COUNT(d.ID_depense),0) nombre_depense
            FROM type_depense t
            JOIN depense d ON t.ID_type = d.type_id AND d.statut_depense = :statut_depense
            WHERE DATE(d.date_created) BETWEEN :startDate AND :endDate ';

        $params = [
            ':startDate' => $startDate,
            ':endDate'   => $endDate,
            ':statut_depense'   => $statut,
        ];

        // Ajout condition dynamique
        if (!empty($entrepot)) {
            $sql .= ' AND d.entrepot_id = :entrepot_id ';
            $params[':entrepot_id'] = $entrepot;
        }

        $query = self::getConnexion()->prepare($sql);
        $query->execute($params);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }

        $query->closeCursor();

        return $data;
    }

    public static function getSingleEntrepotByCode($id_entrepot)
    {
        $data = [];
        $sql = 'SELECT * FROM entrepot WHERE ID_entrepot = :id_entrepot';
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['id_entrepot' => $id_entrepot]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        $query->closeCursor();

        return $data;
    }

    public static function getAllEntrepot()
    {
        $data = [];
        $sql = "SELECT en.*, COALESCE(CONCAT(emp.nom_employe, ' ', emp.prenom_employe), 'Aucun') AS responsable FROM entrepot en
        LEFT JOIN service se ON se.entrepot_id = en.ID_entrepot AND se.responsable = 1
        LEFT JOIN employe emp ON emp.ID_employe = se.employe_id
        ORDER BY en.ID_entrepot DESC";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getEntrepotWithService($entrepot)
    {
        $data = [];
        $sql = "SELECT en.*, se.* FROM entrepot en
        LEFT JOIN service se ON se.entrepot_id = en.ID_entrepot 
        WHERE en.ID_entrepot = :entrepot_id LIMIT 1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot]);

        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getEmployeForResponsableEntrepot()
    {
        $data = [];
        $sql = "SELECT * FROM employe em JOIN role r ON r.ID_role = em.role_id WHERE r.libelle_role IN('admin','gestionnaire') AND em.etat_employe =1";
        $query = self::getConnexion()->prepare($sql);
        $query->execute([]);
        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        }
        $query->closeCursor();
        return $data;
    }

    public static function getServiceEntrepot($entrepot, $employe)
    {
        $data = [];
        $sql = "SELECT * FROM service se WHERE (se.entrepot_id = :entrepot_id AND se.employe_id = :employe_id) OR (se.entrepot_id = :entrepot_id AND se.responsable = 1)";
        $query = self::getConnexion()->prepare($sql);
        $query->execute(['entrepot_id' => $entrepot, 'employe_id' => $employe]);
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
        }
        $query->closeCursor();
        return $data;
    }

    /**
     * @param callable $callback
     * @return boolean
     */
    public static function transactionData($callback)
    {
        $conn = self::getConnexion();
        $conn->beginTransaction();
        try {
            $callback();
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
}
// fin de classe
