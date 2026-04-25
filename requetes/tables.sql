-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 25 avr. 2026 à 14:31
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
  `statut_achat` enum('en attente','valide','encaisse','retourne','annule') NOT NULL,
  `created_at` date NOT NULL,
  `date_echeance` date DEFAULT NULL,
  PRIMARY KEY (`ID_achat`),
  KEY `employe_id` (`employe_id`),
  KEY `fournisseur_id` (`fournisseur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`ID_achat`, `code_achat`, `employe_id`, `fournisseur_id`, `etat_achat`, `pay_mode`, `entrepot_id`, `statut_achat`, `created_at`, `date_echeance`) VALUES
(1, 'AC2625823', 15, 1, 1, 'espece', 1, 'valide', '2026-04-25', '2026-04-25'),
(2, 'AC2625600', 15, 1, 1, 'espece', 1, 'valide', '2026-04-25', '2026-04-25');

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
  `slug` varchar(50) DEFAULT NULL,
  `code_article` varchar(50) DEFAULT NULL,
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
(1, 'ARTICLE A', 1, 1, 1, 1, NULL, 'aaaaaaa', NULL, NULL),
(2, 'ARTICLE B', 2, 2, 3, 1, NULL, 'bbbbbbb', NULL, NULL),
(3, 'ARTICLE C', 2, 2, 4, 1, NULL, 'cccccc', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID_categorie`, `libelle_categorie`, `etat_categorie`, `created_at`) VALUES
(1, 'CATEGORIE A', 1, '2026-03-29'),
(2, 'Catégorie3', 1, '2026-03-29'),
(3, 'CATéGORIE1', 1, '2026-04-25'),
(4, 'CATéGORIE2', 1, '2026-04-25'),
(5, 'CATÉGORIE4', 1, '2026-04-25');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID_client`, `nom_client`, `prenom_client`, `telephone_client`, `code_client`, `solde_client`, `created_at`, `etat_client`, `employe_id`, `updated_at`, `email_client`, `adresse_client`) VALUES
(1, 'CLIENT 3 ', 'Colman', '0102030405', 'CL2629365', 0, '2026-03-29', 1, 1, '2026-03-29 16:29:37', 'abasanogo9@gmail.com', ''),
(2, 'EAQUE ID AB AD DOLOR', '', '656565646', 'CL2630972', 0, '2026-03-30', 1, 1, '2026-03-30 01:11:45', 'pubat@mailinator.com', 'Molestiae '),
(3, 'CLIENT 9', '', '6565', 'CL2630584', 0, '2026-03-30', 1, 1, '2026-03-30 02:46:13', '', ''),
(4, 'KONE PATRICE', '', '0566015517', 'CL2608208', 0, '2026-04-08', 1, 1, '2026-04-08 09:35:58', 'lespros13131@gmail.com', 'Zone'),
(5, 'ASSUMENDA QUO AB REP', '', '05040305', 'CL2619981', 0, '2026-04-19', 1, 1, '2026-04-19 13:09:04', 'wavylo@mailinator.com', 'At laborio'),
(6, 'KONE PATRICE', '', '0560229910', 'CL2625877', 0, '2026-04-25', 1, 15, '2026-04-25 12:12:42', 'lespros13131@gmail.com', 'Belle-vill');

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
(1, 'EM00000', 'Admin', 'Admin', '0102030405', NULL, '202cb962ac59075b964b07152d234b70', 1, 1, '2026-04-25 01:03:22', 0, 1),
(11, 'EM25051188', 'CAMARA', 'Georges', '0566015516', NULL, '202cb962ac59075b964b07152d234b70', 1, 2, '2026-03-28 08:23:41', 0, 1),
(12, 'EM25093690', 'KOFFI', 'André', '0166749966', NULL, '6ac91f0ed946885e7573b4f2a2ee8075', 1, 1, NULL, 0, 1),
(13, 'EM25095215', 'AYA', 'Sanogo', '0699331122', NULL, 'de4ea80ff5c195340cd6666d7223a3e7', 1, 2, NULL, 0, 1),
(14, 'EM250979', 'CAMARA', 'Blaise', '0122334455', NULL, '720131d06307e753ba4f1cca86d66043', 1, 2, NULL, 0, 1),
(15, 'EM26084111', 'KONE', 'Mariam', '0566015517', 'realitecrue13@gmail.com', '53e6086284353cb73d4979f08537d950', 1, 1, NULL, NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `entree`
--

INSERT INTO `entree` (`ID_entree`, `article_id`, `achat_id`, `etat_entree`, `prix_achat`, `qte`, `updated_at`) VALUES
(1, 3, 'AC2625823', 1, 1000, 20, '2026-04-25 11:24:16'),
(3, 2, 'AC2625600', 1, 2000, 20, '2026-04-25 12:34:39');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entrepot`
--

INSERT INTO `entrepot` (`ID_entrepot`, `libelle_entrepot`, `ville_entrepot`, `adresse_entrepot`, `etat_entrepot`, `created_at_entrepot`) VALUES
(1, 'entrepot 1', 'Bouake', '', 1, '2026-04-24');

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
  `article_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_entrepot_article`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `entrepot_article`
--

INSERT INTO `entrepot_article` (`ID_entrepot_article`, `code_entrepot_article`, `etat_article`, `created_at`, `stock_alert`, `date_peramption`, `garantie_article`, `prix_achat`, `prix_vente`, `entrepot_id`, `article_id`) VALUES
(1, '', 1, '2026-04-25', 2, NULL, 1, 2000, 2500, 1, '1'),
(2, '', 1, '2026-04-25', 2, NULL, 0, 2000, 3000, 1, '2'),
(3, '', 1, '2026-04-25', 2, NULL, 0, 1000, 1000, 1, '3');

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
  `type_mouvement` enum('ENTREE','RETOUR_CLIENT','INVENTAIRE','AJUSTEMENT_NEGATIF','RETOUR_FOURNISSEUR','SORTIE','TRANSFERT_IN','TRANSFERT_OUT','AJUSTEMENT_POSITIF') NOT NULL,
  `quantite` int DEFAULT NULL,
  `date_mouvement` datetime NOT NULL,
  `reference_document` varchar(100) DEFAULT NULL,
  `employe_id` int NOT NULL,
  `prix_achat` decimal(10,0) DEFAULT NULL,
  `prix_vente` decimal(10,0) DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  PRIMARY KEY (`ID_mouvement_stock`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mouvement_stock`
--

INSERT INTO `mouvement_stock` (`ID_mouvement_stock`, `article_id`, `type_mouvement`, `quantite`, `date_mouvement`, `reference_document`, `employe_id`, `prix_achat`, `prix_vente`, `entrepot_id`) VALUES
(1, 1, 'INVENTAIRE', 0, '2026-04-25 00:00:00', NULL, 15, 2000, 2500, 1),
(2, 2, 'INVENTAIRE', 0, '2026-04-25 00:00:00', NULL, 15, 2000, 3000, 1),
(3, 3, 'INVENTAIRE', 0, '2026-04-25 00:00:00', NULL, 15, 1000, 1000, 1),
(4, 3, 'ENTREE', 20, '2026-04-25 00:00:00', NULL, 15, 1000, NULL, 1),
(5, 3, 'SORTIE', 2, '2026-04-25 00:00:00', NULL, 15, NULL, 1000, 1),
(6, 2, 'ENTREE', 20, '2026-04-25 00:00:00', NULL, 15, 2000, NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`ID_service`, `entrepot_id`, `employe_id`, `etat_service`, `created_at_service`, `responsable`) VALUES
(1, 1, 1, 0, '2026-04-24', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`ID_sortie`, `article_id`, `vente_id`, `prix_vente`, `qte`, `etat_sortie`, `updated_at`) VALUES
(1, 3, 'VT26257350', 1000, 2, 1, '2026-04-25 11:25:48'),
(2, 3, 'VT26258672', 1000, 2, 1, '2026-04-25 11:28:52');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `statut_vente` enum('en attente','valide','encaisse','retourne','annule') DEFAULT 'en attente',
  `pay_mode` varchar(100) DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `date_echeance` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_vente`),
  KEY `employe_id` (`employe_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`ID_vente`, `code_vente`, `client_id`, `employe_id`, `etat_vente`, `statut_vente`, `pay_mode`, `entrepot_id`, `created_at`, `date_echeance`, `updated_at`) VALUES
(1, 'VT26257350', 1, 15, 1, 'valide', 'espece', 1, '2026-04-25 00:00:00', NULL, '2026-04-25 11:25:48'),
(2, 'VT26258672', 1, 15, 1, 'en attente', 'espece', 1, '2026-04-25 00:00:00', NULL, '2026-04-25 11:28:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `versement`
--

INSERT INTO `versement` (`ID_versement`, `code_versement`, `montant_versement`, `type_versement`, `pay_mode`, `transaction_code`, `client_id`, `fournisseur_id`, `employe_id`, `created_at`, `etat_versement`) VALUES
(1, 'VT26254179', 1000, 'vente', 'especes', 'VT26257350', NULL, NULL, 15, '2026-04-25', 1),
(2, 'VT26253610', 1500, 'vente', 'especes', 'VT26258672', NULL, NULL, 15, '2026-04-25', 1),
(3, 'AC2625276', 15000, 'achat', 'especes', 'AC2625823', NULL, NULL, 15, '2026-04-25', 1),
(4, 'AC2625394', 200, 'achat', 'especes', 'AC2625823', NULL, NULL, 15, '2026-04-25', 1);

-- --------------------------------------------------------




COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
