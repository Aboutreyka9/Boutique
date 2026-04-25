-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 23 avr. 2026 à 11:42
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `c2588565c_boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

DROP TABLE IF EXISTS `achat`;
CREATE TABLE IF NOT EXISTS `achat` (
  `ID_achat` int NOT NULL AUTO_INCREMENT,
  `code_achat` varchar(50) NOT NULL,
  `employe_id` int NOT NULL,
  `fournisseur_id` int NOT NULL,
  `etat_achat` int DEFAULT '1',
  `pay_mode` enum('espece','mobile money','credit','virement','cheque','autre') NOT NULL,
  `entrepot_id` int NOT NULL,
  `statut_achat` enum('en attente','valide','encaisse','retourne','annule') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` date NOT NULL,
  `date_echeance` date DEFAULT NULL,
  PRIMARY KEY (`ID_achat`),
  KEY `employe_id` (`employe_id`),
  KEY `fournisseur_id` (`fournisseur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `ID_article` int NOT NULL AUTO_INCREMENT,
  `libelle_article` varchar(100) NOT NULL,
  `famille_id` int DEFAULT NULL,
  `mark_id` int DEFAULT NULL,
  `unite_id` int DEFAULT NULL,
  `etat_article` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `code_article` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_peramption` date DEFAULT NULL,
  PRIMARY KEY (`ID_article`),
  KEY `famille_article` (`famille_id`),
  KEY `mark_id` (`mark_id`),
  KEY `unite_id` (`unite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_article`, `libelle_article`, `famille_id`, `mark_id`, `unite_id`, `etat_article`, `created_at`, `slug`, `code_article`, `date_peramption`) VALUES
(1, 'BOîTE DE CLOUS 100G', 1, 1, 1, 1, NULL, 'BT', NULL, NULL),
(2, 'PEINTURE', 1, 1, 1, 1, NULL, '', NULL, NULL),
(3, 'MACHINE LABOUREUSE', 1, 2, 2, 1, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID_categorie` int NOT NULL AUTO_INCREMENT,
  `libelle_categorie` varchar(100) NOT NULL,
  `etat_categorie` int NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`ID_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID_categorie`, `libelle_categorie`, `etat_categorie`, `created_at`) VALUES
(1, 'CATEGORIE A', 1, '2026-03-29'),
(2, 'CATEGORIE B', 1, '2026-03-29');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `ID_client` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `telephone_client` varchar(15) DEFAULT NULL,
  `code_client` varchar(50) NOT NULL,
  `solde_client` int NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `etat_client` int NOT NULL,
  `employe_id` int NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_client` varchar(50) DEFAULT NULL,
  `adresse_client` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID_client`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID_client`, `nom_client`, `prenom_client`, `telephone_client`, `code_client`, `solde_client`, `created_at`, `etat_client`, `employe_id`, `updated_at`, `email_client`, `adresse_client`) VALUES
(1, 'CLIENT 3', 'Colman', '0102030405', 'CL2629365', 0, '2026-03-29', 1, 1, '2026-03-29 16:29:37', 'abasanogo9@gmail.com', ''),
(2, 'EAQUE ID AB AD DOLOR', '', '656565646', 'CL2630972', 0, '2026-03-30', 1, 1, '2026-03-30 01:11:45', 'pubat@mailinator.com', 'Molestiae '),
(3, 'CLIENT 9', '', '6565', 'CL2630584', 0, '2026-03-30', 1, 1, '2026-03-30 02:46:13', '', ''),
(4, 'KONE PATRICE', '', '0566015517', 'CL2608208', 0, '2026-04-08', 1, 1, '2026-04-08 09:35:58', 'lespros13131@gmail.com', 'Zone'),
(5, 'ASSUMENDA QUO AB REP', '', '05040305', 'CL2619981', 0, '2026-04-19', 1, 1, '2026-04-19 13:09:04', 'wavylo@mailinator.com', 'At laborio'),
(6, 'CLIENT TEST', '', '0588990022', 'CL2622648', 0, '2026-04-22', 1, 15, '2026-04-22 20:01:50', 'lespros1313@gmail.com', 'Zone'),
(7, 'CLIENT FIDEL', '', '0589002662', 'CL2622593', 0, '2026-04-22', 1, 15, '2026-04-22 20:02:42', 'lespros1313@gmail.com', 'Zone');

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `ID_config` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `contact1` varchar(20) NOT NULL,
  `contact2` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `crreated_at` date DEFAULT NULL,
  `client` int DEFAULT NULL,
  `fournisseur` int DEFAULT NULL,
  `supprimer` int DEFAULT NULL,
  `taxe` int DEFAULT NULL,
  PRIMARY KEY (`ID_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `config`
--

INSERT INTO `config` (`ID_config`, `nom`, `adresse`, `contact1`, `contact2`, `email`, `image`, `crreated_at`, `client`, `fournisseur`, `supprimer`, `taxe`) VALUES
(1, 'BOUTIQUE PROMAX', 'BOUAKE,ZONE TERMINUS', '0504030201', '0102030406', 'exemple@nom.com', 'https://boutique.kassanngroup.com/assets/images/1244890654.jpeg', '2020-01-01', 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `ID_depense` int NOT NULL AUTO_INCREMENT,
  `type_id` int NOT NULL,
  `employe_id` int NOT NULL,
  `montant` float NOT NULL,
  `description` text NOT NULL,
  `periode` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `etat_depense` int NOT NULL DEFAULT '1',
  `statut_depense` varchar(50) NOT NULL,
  `employe_confirm` int DEFAULT NULL,
  `date_confirm` datetime DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  PRIMARY KEY (`ID_depense`),
  KEY `type_id` (`type_id`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `ID_employe` int NOT NULL AUTO_INCREMENT,
  `code_employe` varchar(50) NOT NULL,
  `nom_employe` varchar(50) NOT NULL,
  `prenom_employe` varchar(50) NOT NULL,
  `telephone_employe` varchar(15) NOT NULL,
  `email_employe` varchar(100) DEFAULT NULL,
  `password_employe` varchar(100) NOT NULL,
  `etat_employe` int NOT NULL,
  `role_id` int NOT NULL,
  `login` datetime DEFAULT NULL,
  `service` int DEFAULT NULL,
  `entrepot` int DEFAULT NULL,
  PRIMARY KEY (`ID_employe`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`ID_employe`, `code_employe`, `nom_employe`, `prenom_employe`, `telephone_employe`, `email_employe`, `password_employe`, `etat_employe`, `role_id`, `login`, `service`, `entrepot`) VALUES
(1, 'EM00000', 'Admin', 'Admin', '0102030405', NULL, '202cb962ac59075b964b07152d234b70', 1, 1, '2026-04-22 07:01:21', 0, 1),
(11, 'EM25051188', 'CAMARA', 'Georges', '0566015516', NULL, '202cb962ac59075b964b07152d234b70', 1, 2, '2026-03-28 08:23:41', 0, 1),
(12, 'EM25093690', 'KOFFI', 'André', '0166749966', NULL, '6ac91f0ed946885e7573b4f2a2ee8075', 1, 1, NULL, 0, 1),
(13, 'EM25095215', 'AYA', 'Sanogo', '0699331122', NULL, 'de4ea80ff5c195340cd6666d7223a3e7', 1, 2, NULL, 0, 1),
(14, 'EM250979', 'CAMARA', 'Blaise', '0122334455', NULL, '53e6086284353cb73d4979f08537d950', 1, 2, '2026-04-23 09:54:04', 0, 1),
(15, 'EM26084111', 'Test Moi', 'Moi', '0566015517', 'realitecrue13@gmail.com', '53e6086284353cb73d4979f08537d950', 1, 1, '2026-04-22 08:36:34', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

DROP TABLE IF EXISTS `entree`;
CREATE TABLE IF NOT EXISTS `entree` (
  `ID_entree` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `achat_id` varchar(50) NOT NULL,
  `etat_entree` int NOT NULL DEFAULT '1',
  `prix_achat` int NOT NULL,
  `qte` int NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_entree`),
  UNIQUE KEY `unique_achat_article` (`achat_id`,`article_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `entrepot`
--

DROP TABLE IF EXISTS `entrepot`;
CREATE TABLE IF NOT EXISTS `entrepot` (
  `ID_entrepot` int NOT NULL AUTO_INCREMENT,
  `libelle_entrepot` varchar(100) NOT NULL,
  `ville_entrepot` varchar(100) NOT NULL,
  `adresse_entrepot` varchar(200) NOT NULL,
  `etat_entrepot` int NOT NULL,
  `created_at_entrepot` date NOT NULL,
  PRIMARY KEY (`ID_entrepot`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entrepot`
--

INSERT INTO `entrepot` (`ID_entrepot`, `libelle_entrepot`, `ville_entrepot`, `adresse_entrepot`, `etat_entrepot`, `created_at_entrepot`) VALUES
(1, 'Ma Boutique Bio', 'Bouake', 'Zone,terminus', 1, '2026-04-17'),
(2, 'Boutik golfd', 'Yakro', '', 1, '2026-04-23'),
(3, 'LMagasin Heintein', 'OUmé', '', 1, '2026-04-23');

-- --------------------------------------------------------

--
-- Structure de la table `entrepot_article`
--

DROP TABLE IF EXISTS `entrepot_article`;
CREATE TABLE IF NOT EXISTS `entrepot_article` (
  `ID_entrepot_article` int NOT NULL AUTO_INCREMENT,
  `code_entrepot_article` varchar(50) NOT NULL,
  `etat_article` int NOT NULL,
  `created_at` date NOT NULL,
  `stock_alert` int NOT NULL,
  `date_peramption` date DEFAULT NULL,
  `garantie_article` int NOT NULL,
  `prix_achat` int NOT NULL,
  `prix_vente` int NOT NULL,
  `entrepot_id` int DEFAULT NULL,
  `article_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID_entrepot_article`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `entrepot_article`
--

INSERT INTO `entrepot_article` (`ID_entrepot_article`, `code_entrepot_article`, `etat_article`, `created_at`, `stock_alert`, `date_peramption`, `garantie_article`, `prix_achat`, `prix_vente`, `entrepot_id`, `article_id`) VALUES
(1, '', 1, '2026-04-22', 5, NULL, 1, 3000, 5000, 1, '1'),
(2, '', 1, '2026-04-22', 2, NULL, 0, 2000, 3000, 1, '2');

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

DROP TABLE IF EXISTS `famille`;
CREATE TABLE IF NOT EXISTS `famille` (
  `ID_famille` int NOT NULL AUTO_INCREMENT,
  `libelle_famille` varchar(100) NOT NULL,
  `categorie_id` int NOT NULL,
  `etat_famille` int NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`ID_famille`),
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `famille`
--

INSERT INTO `famille` (`ID_famille`, `libelle_famille`, `categorie_id`, `etat_famille`, `created_at`) VALUES
(1, 'FA A1', 1, 1, '2026-03-29'),
(2, 'FA A2', 1, 1, '2026-03-29'),
(3, 'FA B1', 2, 1, '2026-03-29');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `ID_fournisseur` int NOT NULL AUTO_INCREMENT,
  `code_fournisseur` varchar(50) NOT NULL,
  `nom_fournisseur` varchar(100) NOT NULL,
  `telephone_fournisseur` varchar(20) NOT NULL,
  `etat_fournisseur` int NOT NULL,
  `created_at` date NOT NULL,
  `email_fournisseur` varchar(50) DEFAULT NULL,
  `adresse_fournisseur` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`ID_fournisseur`, `code_fournisseur`, `nom_fournisseur`, `telephone_fournisseur`, `etat_fournisseur`, `created_at`, `email_fournisseur`, `adresse_fournisseur`) VALUES
(1, 'FS26295878', 'FOURNISSEUR A', '0102030405', 1, '2026-03-29', NULL, ''),
(2, 'FS26296647', 'IN ET EA CUPIDATAT N', '657655356477', 1, '2026-03-29', 'abasao9@gmail.com', 'Illo mollitia deleni'),
(3, 'FS26291050', 'FOURNISSEUR C', '545344354545', 1, '2026-03-29', 'abasanogo9@gmail.com', NULL),
(4, 'FS26304057', 'EST RERUM LIBERO VO', '56454564646465', 1, '2026-03-30', NULL, 'Recusandae Odit ut '),
(5, 'FS26301126', 'OFFICIIS VENIAM SED', '768767555', 1, '2026-03-30', 'leliweli@mailinator.com', 'Mollit eligendi duci'),
(6, 'FS26086726', 'KONE PATRICE', '0566015517', 1, '2026-04-08', 'lespros13131@gmail.com', 'Zone'),
(7, 'FS26081422', 'KOUAME MASCO', '0566015533', 1, '2026-04-08', 'lespros1313@gmail.com', 'Zone');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_transfert`
--

DROP TABLE IF EXISTS `ligne_transfert`;
CREATE TABLE IF NOT EXISTS `ligne_transfert` (
  `ID_ligne_transfert` int NOT NULL AUTO_INCREMENT,
  `transfert_id` varchar(50) NOT NULL,
  `article_id` int NOT NULL,
  `etat_transfert` int NOT NULL DEFAULT '1',
  `prix_transfert` int NOT NULL,
  `qte` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_ligne_transfert`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

DROP TABLE IF EXISTS `mark`;
CREATE TABLE IF NOT EXISTS `mark` (
  `ID_mark` int NOT NULL AUTO_INCREMENT,
  `libelle_mark` varchar(100) NOT NULL,
  `etat_mark` int NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`ID_mark`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `mark`
--

INSERT INTO `mark` (`ID_mark`, `libelle_mark`, `etat_mark`, `created_at`) VALUES
(1, 'MARK A', 1, '2026-03-29'),
(2, 'MARK B', 1, '2026-03-29');

-- --------------------------------------------------------

--
-- Structure de la table `mouvement_stock`
--

DROP TABLE IF EXISTS `mouvement_stock`;
CREATE TABLE IF NOT EXISTS `mouvement_stock` (
  `ID_mouvement_stock` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `type_mouvement` enum('ENTREE','RETOUR_CLIENT','INVENTAIRE','AJUSTEMENT_NEGATIF','RETOUR_FOURNISSEUR','SORTIE','TRANSFERT_IN','TRANSFERT_OUT','AJUSTEMENT_POSITIF') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantite` int DEFAULT NULL,
  `date_mouvement` datetime NOT NULL,
  `reference_document` varchar(100) DEFAULT NULL,
  `employe_id` int NOT NULL,
  `prix_achat` decimal(10,0) DEFAULT NULL,
  `prix_vente` decimal(10,0) DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  PRIMARY KEY (`ID_mouvement_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `ID_role` int NOT NULL AUTO_INCREMENT,
  `libelle_role` varchar(100) NOT NULL,
  `etat_role` int NOT NULL,
  PRIMARY KEY (`ID_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`ID_role`, `libelle_role`, `etat_role`) VALUES
(1, 'admin', 1),
(2, 'commercial', 1),
(3, 'gestionnaire', 1),
(4, 'comptable', 1);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `ID_service` int NOT NULL AUTO_INCREMENT,
  `entrepot_id` int NOT NULL,
  `employe_id` int NOT NULL,
  `etat_service` int NOT NULL,
  `created_at_service` date NOT NULL,
  `responsable` int DEFAULT NULL,
  PRIMARY KEY (`ID_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
  `ID_sortie` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `vente_id` varchar(50) NOT NULL,
  `prix_vente` int NOT NULL,
  `qte` int NOT NULL,
  `etat_sortie` int NOT NULL DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_sortie`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

DROP TABLE IF EXISTS `transfert`;
CREATE TABLE IF NOT EXISTS `transfert` (
  `ID_transfert` int NOT NULL AUTO_INCREMENT,
  `code_transfert` varchar(50) NOT NULL,
  `entrepot_source_id` int NOT NULL,
  `entrepot_destination_id` int NOT NULL,
  `date_transfert` datetime NOT NULL,
  `employe_id` int DEFAULT NULL,
  `pay_mode` enum('espece','mobile money','credit','virement','cheque','autre') NOT NULL,
  `statut_transfert` enum('en attente','valide','encaisse','retourne','annule') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_transfert`),
  UNIQUE KEY `code_transfert` (`code_transfert`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_depense`
--

DROP TABLE IF EXISTS `type_depense`;
CREATE TABLE IF NOT EXISTS `type_depense` (
  `ID_type` int NOT NULL AUTO_INCREMENT,
  `libelle_type` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_type`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_depense`
--

INSERT INTO `type_depense` (`ID_type`, `libelle_type`) VALUES
(1, 'Loyer'),
(2, 'Electricite'),
(3, 'Eau'),
(4, 'Internet'),
(5, 'Telephone'),
(6, 'Salaire'),
(7, 'Transport'),
(8, 'Alimentation'),
(9, 'Entretien'),
(10, 'Fournitures'),
(11, 'Sante'),
(12, 'Education'),
(13, 'Imprevus'),
(14, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `ID_unite` int NOT NULL AUTO_INCREMENT,
  `libelle_unite` varchar(50) NOT NULL,
  `slug_unite` char(50) NOT NULL,
  `description_unite` text NOT NULL,
  `etat_unite` enum('0','1') NOT NULL,
  PRIMARY KEY (`ID_unite`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `unite`
--

INSERT INTO `unite` (`ID_unite`, `libelle_unite`, `slug_unite`, `description_unite`, `etat_unite`) VALUES
(1, 'PiÃ¨ce', 'P', 'PiÃ¨ce en detail', '1'),
(2, 'BoÃ®te', 'B', 'BoÃ®te de tout genre', '1'),
(3, 'MÃ¨tre', 'M', '', '1'),
(4, 'Litre', 'L', '', '1'),
(5, 'Kit', 'K', 'en carton et autre', '1');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `ID_vente` int NOT NULL AUTO_INCREMENT,
  `code_vente` varchar(50) NOT NULL,
  `client_id` int NOT NULL,
  `employe_id` int NOT NULL,
  `etat_vente` int NOT NULL DEFAULT '1',
  `statut_vente` enum('en attente','valide','encaisse','retourne','annule') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'en attente',
  `pay_mode` varchar(100) DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `date_echeance` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_vente`),
  KEY `employe_id` (`employe_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

DROP TABLE IF EXISTS `versement`;
CREATE TABLE IF NOT EXISTS `versement` (
  `ID_versement` int NOT NULL AUTO_INCREMENT,
  `code_versement` varchar(50) NOT NULL,
  `montant_versement` int NOT NULL,
  `type_versement` enum('achat','vente','','') NOT NULL,
  `pay_mode` enum('especes','mobile money','cheque','credit','autre') NOT NULL,
  `transaction_code` varchar(50) NOT NULL,
  `client_id` int DEFAULT NULL,
  `fournisseur_id` int DEFAULT NULL,
  `employe_id` int DEFAULT NULL,
  `created_at` date NOT NULL,
  `etat_versement` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_versement`),
  KEY `client_id` (`client_id`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_stock_produit`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `view_stock_produit`;
CREATE TABLE IF NOT EXISTS `view_stock_produit` (
`ID_article` int
,`libelle_article` varchar(100)
,`ID_entrepot` int
,`libelle_entrepot` varchar(100)
,`quantite_disponible` decimal(33,0)
,`montant_total_stock` decimal(43,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_bilan_articles`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_bilan_articles`;
CREATE TABLE IF NOT EXISTS `vue_bilan_articles` (
`entrepot_id` int
,`libelle_entrepot` varchar(100)
,`article_id` int
,`libelle_article` varchar(100)
,`qte_approvisionnement` decimal(33,0)
,`cout_achat` decimal(43,0)
,`qte_vendue` decimal(32,0)
,`montant_vendu` decimal(42,0)
,`benefice` decimal(43,0)
,`qte_restante` decimal(33,0)
,`montant_quantite_restant` decimal(43,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_caisse_mode_paiement`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_caisse_mode_paiement`;
CREATE TABLE IF NOT EXISTS `vue_caisse_mode_paiement` (
`entrepot_id` int
,`mode_paiement` varchar(12)
,`total_entree` decimal(41,0)
,`total_sortie_achat` decimal(41,0)
,`total_depense` double
,`solde` double
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_dernier_inventaire_entrepot`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_dernier_inventaire_entrepot`;
CREATE TABLE IF NOT EXISTS `vue_dernier_inventaire_entrepot` (
`article_id` int
,`entrepot_id` int
,`last_inv_id` int
,`quantite_inv` int
,`prix_achat` decimal(10,0)
,`prix_vente` decimal(10,0)
,`date_inventaire` datetime
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_etat_paiements`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_etat_paiements`;
CREATE TABLE IF NOT EXISTS `vue_etat_paiements` (
`nature` varchar(5)
,`entrepot` int
,`code_transaction` varchar(50)
,`pay_mode` varchar(12)
,`date_facture` datetime
,`statut_commande` varchar(10)
,`montant_facture` decimal(42,0)
,`total_paye` decimal(32,0)
,`reste_a_payer` decimal(43,0)
,`statut_paiement` varchar(8)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_flux_post_inventaire`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_flux_post_inventaire`;
CREATE TABLE IF NOT EXISTS `vue_flux_post_inventaire` (
`article_id` int
,`entrepot_id` int
,`total_flux` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_montant_achats`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_montant_achats`;
CREATE TABLE IF NOT EXISTS `vue_montant_achats` (
`ID_achat` int
,`code_achat` varchar(50)
,`employe_id` int
,`fournisseur_id` int
,`etat_achat` int
,`pay_mode` enum('espece','mobile money','credit','virement','cheque','autre')
,`entrepot_id` int
,`statut_achat` enum('en attente','valide','encaisse','retourne','annule')
,`created_at` date
,`date_echeance` date
,`libelle_entrepot` varchar(100)
,`nom_fournisseur` varchar(100)
,`montant_total` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_montant_ventes`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_montant_ventes`;
CREATE TABLE IF NOT EXISTS `vue_montant_ventes` (
`ID_vente` int
,`code_vente` varchar(50)
,`client_id` int
,`employe_id` int
,`etat_vente` int
,`statut_vente` enum('en attente','valide','encaisse','retourne','annule')
,`pay_mode` varchar(100)
,`entrepot_id` int
,`created_at` datetime
,`date_echeance` datetime
,`updated_at` timestamp
,`libelle_entrepot` varchar(100)
,`nom_client` varchar(101)
,`montant_total` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_tresorerie_par_entrepot`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_tresorerie_par_entrepot`;
CREATE TABLE IF NOT EXISTS `vue_tresorerie_par_entrepot` (
`entrepot_id` int
,`total_entree` decimal(41,0)
,`total_sortie_achat` decimal(41,0)
,`total_depense` double
,`solde_tresorerie` double
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_versement_achat`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_versement_achat`;
CREATE TABLE IF NOT EXISTS `vue_versement_achat` (
`fournisseur_id` int
,`code_achat` varchar(50)
,`entrepot_id` int
,`created_at` date
,`date_echeance` date
,`montant_total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_versement_vente`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_versement_vente`;
CREATE TABLE IF NOT EXISTS `vue_versement_vente` (
`client_id` int
,`code_vente` varchar(50)
,`entrepot_id` int
,`created_at` datetime
,`date_echeance` datetime
,`montant_total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure de la vue `view_stock_produit`
--

DROP TABLE IF EXISTS `view_stock_produit`;

DROP VIEW IF EXISTS `view_stock_produit`;
CREATE ALGORITHM=UNDEFINED VIEW `view_stock_produit`  AS SELECT `a`.`ID_article` AS `ID_article`, `a`.`libelle_article` AS `libelle_article`, `e`.`ID_entrepot` AS `ID_entrepot`, `e`.`libelle_entrepot` AS `libelle_entrepot`, (coalesce(`vdi`.`quantite_inv`,0) + coalesce(`vfp`.`total_flux`,0)) AS `quantite_disponible`, ((coalesce(`vdi`.`quantite_inv`,0) + coalesce(`vfp`.`total_flux`,0)) * (select `mouvement_stock`.`prix_achat` from `mouvement_stock` where ((`mouvement_stock`.`article_id` = `a`.`ID_article`) and (`mouvement_stock`.`prix_achat` > 0)) order by `mouvement_stock`.`date_mouvement` desc,`mouvement_stock`.`ID_mouvement_stock` desc limit 1)) AS `montant_total_stock` FROM ((((`article` `a` join `entrepot_article` `ea` on((`a`.`ID_article` = `ea`.`article_id`))) join `entrepot` `e` on((`e`.`ID_entrepot` = `ea`.`entrepot_id`))) left join `vue_dernier_inventaire_entrepot` `vdi` on(((`a`.`ID_article` = `vdi`.`article_id`) and (`e`.`ID_entrepot` = `vdi`.`entrepot_id`)))) left join `vue_flux_post_inventaire` `vfp` on(((`a`.`ID_article` = `vfp`.`article_id`) and (`e`.`ID_entrepot` = `vfp`.`entrepot_id`)))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_bilan_articles`
--
DROP TABLE IF EXISTS `vue_bilan_articles`;

DROP VIEW IF EXISTS `vue_bilan_articles`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_bilan_articles`  AS SELECT `ea`.`entrepot_id` AS `entrepot_id`, `e`.`libelle_entrepot` AS `libelle_entrepot`, `a`.`ID_article` AS `article_id`, `a`.`libelle_article` AS `libelle_article`, (coalesce(`vdi`.`quantite_inv`,0) + coalesce((select sum(`m`.`quantite`) from `mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) and (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`))),0)) AS `qte_approvisionnement`, (coalesce((`vdi`.`quantite_inv` * `ea`.`prix_achat`),0) + coalesce((select sum((`m`.`quantite` * `ea`.`prix_achat`)) from `mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) and (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`))),0)) AS `cout_achat`, coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then `m`.`quantite` when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -(`m`.`quantite`) else 0 end)) from `mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`))),0) AS `qte_vendue`, coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * `m`.`prix_vente`) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * `m`.`prix_vente`)) else 0 end)) from `mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`))),0) AS `montant_vendu`, coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`)) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`))) else 0 end)) from `mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`))),0) AS `benefice`, coalesce(`vs`.`quantite_disponible`,0) AS `qte_restante`, (coalesce(`vs`.`quantite_disponible`,0) * `ea`.`prix_achat`) AS `montant_quantite_restant` FROM ((((`entrepot_article` `ea` join `article` `a` on((`ea`.`article_id` = `a`.`ID_article`))) join `entrepot` `e` on((`ea`.`entrepot_id` = `e`.`ID_entrepot`))) left join `vue_dernier_inventaire_entrepot` `vdi` on(((`a`.`ID_article` = `vdi`.`article_id`) and (`e`.`ID_entrepot` = `vdi`.`entrepot_id`)))) left join `view_stock_produit` `vs` on(((`a`.`ID_article` = `vs`.`ID_article`) and (`e`.`ID_entrepot` = `vs`.`ID_entrepot`)))) ORDER BY `e`.`libelle_entrepot` ASC, `a`.`libelle_article` ASC ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_caisse_mode_paiement`
--
DROP TABLE IF EXISTS `vue_caisse_mode_paiement`;

DROP VIEW IF EXISTS `vue_caisse_mode_paiement`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_caisse_mode_paiement`  AS SELECT `t`.`entrepot_id` AS `entrepot_id`, `t`.`mode_paiement` AS `mode_paiement`, sum(`t`.`entree`) AS `total_entree`, sum(`t`.`sortie_achat`) AS `total_sortie_achat`, sum(`t`.`depense`) AS `total_depense`, ((sum(`t`.`entree`) - sum(`t`.`sortie_achat`)) - sum(`t`.`depense`)) AS `solde` FROM (select `ve`.`entrepot_id` AS `entrepot_id`,coalesce(`v`.`pay_mode`,'inconnu') AS `mode_paiement`,`v`.`montant_versement` AS `entree`,0 AS `sortie_achat`,0 AS `depense` from (`versement` `v` join `vente` `ve` on((`ve`.`code_vente` = `v`.`transaction_code`))) where ((`v`.`type_versement` = 'vente') and (`v`.`etat_versement` = 1)) union all select `ac`.`entrepot_id` AS `entrepot_id`,coalesce(`v`.`pay_mode`,'inconnu') AS `COALESCE(v.pay_mode, 'inconnu')`,0 AS `0`,`v`.`montant_versement` AS `montant_versement`,0 AS `0` from (`versement` `v` join `achat` `ac` on((`ac`.`code_achat` = `v`.`transaction_code`))) where ((`v`.`type_versement` = 'achat') and (`v`.`etat_versement` = 1)) union all select `d`.`entrepot_id` AS `entrepot_id`,'especes' AS `mode_paiement`,0 AS `0`,0 AS `0`,`d`.`montant` AS `montant` from `depense` `d` where (`d`.`etat_depense` = 0)) AS `t` GROUP BY `t`.`entrepot_id`, `t`.`mode_paiement` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_dernier_inventaire_entrepot`
--
DROP TABLE IF EXISTS `vue_dernier_inventaire_entrepot`;

DROP VIEW IF EXISTS `vue_dernier_inventaire_entrepot`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_dernier_inventaire_entrepot`  AS SELECT `st`.`article_id` AS `article_id`, `st`.`entrepot_id` AS `entrepot_id`, max(`st`.`ID_mouvement_stock`) AS `last_inv_id`, `st`.`quantite` AS `quantite_inv`, `st`.`prix_achat` AS `prix_achat`, `st`.`prix_vente` AS `prix_vente`, `st`.`date_mouvement` AS `date_inventaire` FROM `mouvement_stock` AS `st` WHERE (`st`.`type_mouvement` = 'INVENTAIRE') GROUP BY `st`.`article_id`, `st`.`entrepot_id`, `st`.`quantite` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_etat_paiements`
--
DROP TABLE IF EXISTS `vue_etat_paiements`;

DROP VIEW IF EXISTS `vue_etat_paiements`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_etat_paiements`  AS SELECT `ver`.`type_versement` AS `nature`, `v`.`entrepot_id` AS `entrepot`, `v`.`code_vente` AS `code_transaction`, ifnull(`ver`.`pay_mode`,'...') AS `pay_mode`, `v`.`created_at` AS `date_facture`, `v`.`statut_vente` AS `statut_commande`, `vmt`.`montant_total` AS `montant_facture`, coalesce(sum(`ver`.`montant_versement`),0) AS `total_paye`, (`vmt`.`montant_total` - coalesce(sum(`ver`.`montant_versement`),0)) AS `reste_a_payer`, (case when (coalesce(sum(`ver`.`montant_versement`),0) <= 0) then 'Non payé' when (coalesce(sum(`ver`.`montant_versement`),0) < `vmt`.`montant_total`) then 'Partiel' else 'Soldé' end) AS `statut_paiement` FROM (((`vente` `v` join `vue_montant_ventes` `vmt` on((`vmt`.`code_vente` = `v`.`code_vente`))) join `sortie` `so` on((`so`.`vente_id` = `v`.`code_vente`))) left join `versement` `ver` on(((`v`.`code_vente` = `ver`.`transaction_code`) and (`ver`.`type_versement` = 'vente') and (`ver`.`etat_versement` = 1)))) WHERE (`v`.`statut_vente` in ('valide','encaisse')) GROUP BY `v`.`ID_vente`union all select `ver`.`type_versement` AS `nature`,`a`.`entrepot_id` AS `entrepot`,`a`.`code_achat` AS `code_transaction`,`ver`.`pay_mode` AS `pay_mode`,`a`.`created_at` AS `date_facture`,`a`.`statut_achat` AS `statut_commande`,`vma`.`montant_total` AS `montant_facture`,coalesce(sum(`ver`.`montant_versement`),0) AS `total_paye`,(`vma`.`montant_total` - coalesce(sum(`ver`.`montant_versement`),0)) AS `reste_a_payer`,(case when (coalesce(sum(`ver`.`montant_versement`),0) <= 0) then 'Non payé' when (coalesce(sum(`ver`.`montant_versement`),0) < `vma`.`montant_total`) then 'Partiel' else 'Soldé' end) AS `statut_paiement` from (((`achat` `a` join `vue_montant_achats` `vma` on((`vma`.`code_achat` = `a`.`code_achat`))) join `entree` `en` on((`en`.`achat_id` = `a`.`code_achat`))) left join `versement` `ver` on(((`a`.`code_achat` = `ver`.`transaction_code`) and (`ver`.`type_versement` = 'achat') and (`ver`.`etat_versement` = 1)))) where (`a`.`statut_achat` in ('valide','encaisse')) group by `a`.`ID_achat`  ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_flux_post_inventaire`
--
DROP TABLE IF EXISTS `vue_flux_post_inventaire`;

DROP VIEW IF EXISTS `vue_flux_post_inventaire`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_flux_post_inventaire`  AS SELECT `m`.`article_id` AS `article_id`, `m`.`entrepot_id` AS `entrepot_id`, sum((case when (`m`.`type_mouvement` in ('ENTREE','RETOUR_CLIENT','TRANSFERT_IN','AJUSTEMENT_POSITIF')) then `m`.`quantite` when (`m`.`type_mouvement` in ('SORTIE','RETOUR_FOURNISSEUR','TRANSFERT_OUT','AJUSTEMENT_NEGATIF')) then -(`m`.`quantite`) else 0 end)) AS `total_flux` FROM (`mouvement_stock` `m` join `vue_dernier_inventaire_entrepot` `vdi` on(((`m`.`article_id` = `vdi`.`article_id`) and (`m`.`entrepot_id` = `vdi`.`entrepot_id`)))) WHERE (`m`.`ID_mouvement_stock` > `vdi`.`last_inv_id`) GROUP BY `m`.`article_id`, `m`.`entrepot_id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_montant_achats`
--
DROP TABLE IF EXISTS `vue_montant_achats`;

DROP VIEW IF EXISTS `vue_montant_achats`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_montant_achats`  AS SELECT `ac`.`ID_achat` AS `ID_achat`, `ac`.`code_achat` AS `code_achat`, `ac`.`employe_id` AS `employe_id`, `ac`.`fournisseur_id` AS `fournisseur_id`, `ac`.`etat_achat` AS `etat_achat`, `ac`.`pay_mode` AS `pay_mode`, `ac`.`entrepot_id` AS `entrepot_id`, `ac`.`statut_achat` AS `statut_achat`, `ac`.`created_at` AS `created_at`, `ac`.`date_echeance` AS `date_echeance`, `ent`.`libelle_entrepot` AS `libelle_entrepot`, `fn`.`nom_fournisseur` AS `nom_fournisseur`, coalesce(sum((`la`.`qte` * `la`.`prix_achat`)),0) AS `montant_total` FROM (((`achat` `ac` join `entree` `la` on((`ac`.`code_achat` = `la`.`achat_id`))) join `fournisseur` `fn` on((`ac`.`fournisseur_id` = `fn`.`ID_fournisseur`))) join `entrepot` `ent` on((`ac`.`entrepot_id` = `ent`.`ID_entrepot`))) GROUP BY `la`.`achat_id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_montant_ventes`
--
DROP TABLE IF EXISTS `vue_montant_ventes`;

DROP VIEW IF EXISTS `vue_montant_ventes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_montant_ventes`  AS SELECT `v`.`ID_vente` AS `ID_vente`, `v`.`code_vente` AS `code_vente`, `v`.`client_id` AS `client_id`, `v`.`employe_id` AS `employe_id`, `v`.`etat_vente` AS `etat_vente`, `v`.`statut_vente` AS `statut_vente`, `v`.`pay_mode` AS `pay_mode`, `v`.`entrepot_id` AS `entrepot_id`, `v`.`created_at` AS `created_at`, `v`.`date_echeance` AS `date_echeance`, `v`.`updated_at` AS `updated_at`, `ent`.`libelle_entrepot` AS `libelle_entrepot`, concat(`c`.`nom_client`,' ',`c`.`prenom_client`) AS `nom_client`, coalesce(sum((`lv`.`qte` * `lv`.`prix_vente`)),0) AS `montant_total` FROM (((`vente` `v` join `sortie` `lv` on((`v`.`code_vente` = `lv`.`vente_id`))) join `client` `c` on((`v`.`client_id` = `c`.`ID_client`))) join `entrepot` `ent` on((`v`.`entrepot_id` = `ent`.`ID_entrepot`))) GROUP BY `lv`.`vente_id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_tresorerie_par_entrepot`
--
DROP TABLE IF EXISTS `vue_tresorerie_par_entrepot`;

DROP VIEW IF EXISTS `vue_tresorerie_par_entrepot`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_tresorerie_par_entrepot`  AS SELECT `t`.`entrepot_id` AS `entrepot_id`, sum(`t`.`entree`) AS `total_entree`, sum(`t`.`sortie_achat`) AS `total_sortie_achat`, sum(`t`.`depense`) AS `total_depense`, ((sum(`t`.`entree`) - sum(`t`.`sortie_achat`)) - sum(`t`.`depense`)) AS `solde_tresorerie` FROM (select `ve`.`entrepot_id` AS `entrepot_id`,`v`.`montant_versement` AS `entree`,0 AS `sortie_achat`,0 AS `depense` from (`versement` `v` join `vente` `ve` on((`ve`.`code_vente` = `v`.`transaction_code`))) where ((`v`.`type_versement` = 'vente') and (`v`.`etat_versement` = 1)) union all select `ac`.`entrepot_id` AS `entrepot_id`,0 AS `0`,`v`.`montant_versement` AS `montant_versement`,0 AS `0` from (`versement` `v` join `achat` `ac` on((`ac`.`code_achat` = `v`.`transaction_code`))) where ((`v`.`type_versement` = 'achat') and (`v`.`etat_versement` = 1)) union all select `d`.`entrepot_id` AS `entrepot_id`,0 AS `0`,0 AS `0`,`d`.`montant` AS `montant` from `depense` `d` where (`d`.`statut_depense` = 'approuve')) AS `t` GROUP BY `t`.`entrepot_id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_versement_achat`
--
DROP TABLE IF EXISTS `vue_versement_achat`;

DROP VIEW IF EXISTS `vue_versement_achat`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_versement_achat`  AS SELECT `ac`.`fournisseur_id` AS `fournisseur_id`, `ac`.`code_achat` AS `code_achat`, `ac`.`entrepot_id` AS `entrepot_id`, `ac`.`created_at` AS `created_at`, `ac`.`date_echeance` AS `date_echeance`, coalesce(sum(`vs`.`montant_versement`),0) AS `montant_total` FROM (`versement` `vs` join `achat` `ac` on(((`ac`.`code_achat` = `vs`.`transaction_code`) and (`ac`.`statut_achat` in ('valide','encaisse'))))) WHERE ((`vs`.`type_versement` = 'achat') AND (`vs`.`etat_versement` = 1)) GROUP BY `ac`.`code_achat` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_versement_vente`
--
DROP TABLE IF EXISTS `vue_versement_vente`;

DROP VIEW IF EXISTS `vue_versement_vente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_versement_vente`  AS SELECT `ve`.`client_id` AS `client_id`, `ve`.`code_vente` AS `code_vente`, `ve`.`entrepot_id` AS `entrepot_id`, `ve`.`created_at` AS `created_at`, `ve`.`date_echeance` AS `date_echeance`, coalesce(sum(`vs`.`montant_versement`),0) AS `montant_total` FROM (`versement` `vs` join `vente` `ve` on(((`ve`.`code_vente` = `vs`.`transaction_code`) and (`ve`.`statut_vente` in ('valide','encaisse'))))) WHERE ((`vs`.`type_versement` = 'vente') AND (`vs`.`etat_versement` = 1)) GROUP BY `ve`.`code_vente` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
