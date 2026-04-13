-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 12 avr. 2026 à 23:41
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
  `pay_mode` enum('espèce','mobile money','credit','virement','chèque','autre') NOT NULL,
  `entrepot_id` int NOT NULL,
  `statut_achat` enum('en attente','validé','encaissé','retourné','annulé') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` date NOT NULL,
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
  `prix_article` int DEFAULT NULL,
  `famille_id` int DEFAULT NULL,
  `mark_id` int DEFAULT NULL,
  `unite_id` int DEFAULT NULL,
  `etat_article` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `code_article` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `stock_alert` int DEFAULT NULL,
  `date_peramption` date DEFAULT NULL,
  `garantie_article` int DEFAULT NULL,
  `prix_achat` int DEFAULT NULL,
  `prix_vente` int DEFAULT NULL,
  `entrepot_id` int DEFAULT NULL,
  PRIMARY KEY (`ID_article`),
  KEY `famille_article` (`famille_id`),
  KEY `mark_id` (`mark_id`),
  KEY `unite_id` (`unite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_article`, `libelle_article`, `prix_article`, `famille_id`, `mark_id`, `unite_id`, `etat_article`, `created_at`, `slug`, `code_article`, `stock_alert`, `date_peramption`, `garantie_article`, `prix_achat`, `prix_vente`, `entrepot_id`) VALUES
(1, 'BOîTE DE CLOUS 100G', NULL, 1, 1, 1, 1, NULL, 'Bt', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'INTERRUPTEUR SIMPLEFCDCD', NULL, 1, 1, 1, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'TOURNEVIS CRUCIFORME', NULL, 1, 2, 2, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_entree`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `bilan_entree`;
CREATE TABLE IF NOT EXISTS `bilan_entree` (
`article` varchar(100)
,`en_montant` decimal(42,0)
,`en_qte` decimal(32,0)
,`ID_article` int
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_sortie`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `bilan_sortie`;
CREATE TABLE IF NOT EXISTS `bilan_sortie` (
`article` varchar(100)
,`ID_article` int
,`so_montant` decimal(42,0)
,`so_qte` decimal(32,0)
);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID_client`, `nom_client`, `prenom_client`, `telephone_client`, `code_client`, `solde_client`, `created_at`, `etat_client`, `employe_id`, `updated_at`, `email_client`, `adresse_client`) VALUES
(1, 'CLIENT 3', 'Colman', '0102030405', 'CL2629365', 0, '2026-03-29', 1, 1, '2026-03-29 16:29:37', 'abasanogo9@gmail.com', ''),
(2, 'EAQUE ID AB AD DOLOR', '', '656565646', 'CL2630972', 0, '2026-03-30', 1, 1, '2026-03-30 01:11:45', 'pubat@mailinator.com', 'Molestiae '),
(3, 'CLIENT 9', '', '6565', 'CL2630584', 0, '2026-03-30', 1, 1, '2026-03-30 02:46:13', '', ''),
(4, 'KONE PATRICE', '', '0566015517', 'CL2608208', 0, '2026-04-08', 1, 1, '2026-04-08 09:35:58', 'lespros13131@gmail.com', 'Zone');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `comptabilite`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `comptabilite`;
CREATE TABLE IF NOT EXISTS `comptabilite` (
`article` varchar(100)
,`depenses` decimal(42,0)
,`gain` decimal(45,0)
,`id_article` int
,`mt_reste` decimal(43,0)
,`qte_reste` decimal(33,0)
,`ventes` decimal(42,0)
);

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
  PRIMARY KEY (`ID_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `config`
--

INSERT INTO `config` (`ID_config`, `nom`, `adresse`, `contact1`, `contact2`, `email`, `image`, `crreated_at`, `client`, `fournisseur`, `supprimer`) VALUES
(1, 'BOUTIQUE PROMAX', 'BOUAKE,ZONE TERMINUS', '0504030201', '0102030406', 'exemple@nom.com', 'https://boutique.kassanngroup.com/assets/images/1244890654.jpeg', '2020-01-01', 1, 1, 0);

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
  PRIMARY KEY (`ID_employe`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`ID_employe`, `code_employe`, `nom_employe`, `prenom_employe`, `telephone_employe`, `email_employe`, `password_employe`, `etat_employe`, `role_id`, `login`, `service`) VALUES
(1, 'EM00000', 'Admin', 'Admin', '0102030405', NULL, '202cb962ac59075b964b07152d234b70', 1, 1, '2026-04-12 01:59:26', 0),
(11, 'EM25051188', 'CAMARA', 'Georges', '0566015516', NULL, '202cb962ac59075b964b07152d234b70', 1, 2, '2026-03-28 08:23:41', 0),
(12, 'EM25093690', 'KOFFI', 'AndrÃ©', '0166749966', NULL, '6ac91f0ed946885e7573b4f2a2ee8075', 1, 1, NULL, 0),
(13, 'EM25095215', 'AYA', 'Sanogo', '0699331122', NULL, 'de4ea80ff5c195340cd6666d7223a3e7', 0, 2, NULL, 0),
(14, 'EM250979', 'CAMARA', 'Blaise', '0122334455', NULL, '720131d06307e753ba4f1cca86d66043', 0, 1, NULL, 0),
(15, 'EM26084111', 'KONE', 'Mariam', '0566015517', 'realitecrue13@gmail.com', '53e6086284353cb73d4979f08537d950', 1, 1, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entrepot`
--

INSERT INTO `entrepot` (`ID_entrepot`, `libelle_entrepot`, `ville_entrepot`, `adresse_entrepot`, `etat_entrepot`, `created_at_entrepot`) VALUES
(6, 'Magasin DAFI', 'Sequi expedita tempo', '', 0, '2026-03-31'),
(7, 'Ad natus Nam incidun', 'Sequi impedit cillu', '', 1, '2026-03-31');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `entrepot_article`
--

INSERT INTO `entrepot_article` (`ID_entrepot_article`, `code_entrepot_article`, `etat_article`, `created_at`, `stock_alert`, `date_peramption`, `garantie_article`, `prix_achat`, `prix_vente`, `entrepot_id`, `article_id`) VALUES
(1, '', 1, '2026-04-12', 569, NULL, 69, 239, 305, 7, '3'),
(2, '', 1, '2026-04-12', 5, NULL, 21, 71, 72, 6, '1'),
(3, '', 1, '2026-04-12', 28, NULL, 96, 68, 40, 7, '3'),
(4, '', 1, '2026-04-12', 50, NULL, 99, 80, 17, 7, '2'),
(5, '', 1, '2026-04-12', 7, NULL, 2, 12, 38, 7, '1'),
(6, '', 1, '2026-04-12', 47, NULL, 50, 26, 31, 7, 'DEFAULT');

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
  `type_mouvement` enum('ENTREE','RETOUR_CLIENT','INVENTAIRE','AJUSTEMENT_NEGATIF','DEF_CONSTATED','RETOUR_FOURNISSEUR','SORTIE') NOT NULL,
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
(1, 3, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 239, 305, 7),
(2, 1, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 71, 72, 6),
(3, 3, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 68, 40, 7),
(4, 2, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 80, 17, 7),
(5, 1, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 12, 38, 7),
(6, 0, 'INVENTAIRE', 0, '2026-04-12 00:00:00', NULL, 1, 26, 31, 7);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`ID_service`, `entrepot_id`, `employe_id`, `etat_service`, `created_at_service`, `responsable`) VALUES
(3, 6, 12, 0, '2026-03-31', 0),
(6, 6, 1, 0, '2026-03-31', 0),
(9, 6, 12, 0, '2026-03-31', 0),
(10, 7, 1, 0, '2026-03-31', 1),
(11, 6, 1, 0, '2026-03-31', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`ID_sortie`, `article_id`, `vente_id`, `prix_vente`, `qte`, `etat_sortie`, `updated_at`) VALUES
(1, 7, 'VT26027237', 1000, 5, 1, '2026-04-02 00:20:20'),
(2, 7, 'VT260236', 1000, 5, 1, '2026-04-02 01:41:11'),
(3, 1, 'VT260236', 500, 3, 1, '2026-04-02 01:41:11'),
(4, 1, 'VT26036330', 500, 3, 1, '2026-04-03 18:16:51'),
(5, 1, 'VT2604633', 500, 1, 1, '2026-04-04 01:29:48'),
(6, 2, 'VT26042438', 1000, 1, 1, '2026-04-04 02:57:47'),
(7, 1, 'VT26042438', 500, 2, 1, '2026-04-04 02:57:47'),
(8, 7, 'VT26046691', 1000, 1, 1, '2026-04-04 02:59:51'),
(9, 8, 'VT26046691', 20, 1, 1, '2026-04-04 02:59:51'),
(10, 1, 'VT26046691', 500, 1, 1, '2026-04-04 02:59:51'),
(11, 2, 'VT26046691', 1000, 1, 1, '2026-04-04 02:59:51'),
(12, 7, 'VT26064658', 1000, 1, 1, '2026-04-06 01:05:55'),
(13, 8, 'VT26064658', 20, 1, 1, '2026-04-06 01:05:55'),
(14, 7, 'VT26074316', 1000, 1, 1, '2026-04-07 00:01:39');

-- --------------------------------------------------------

--
-- Structure de la table `type_depense`
--

DROP TABLE IF EXISTS `type_depense`;
CREATE TABLE IF NOT EXISTS `type_depense` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `libelle_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_depense`
--

INSERT INTO `type_depense` (`id_type`, `libelle_type`) VALUES
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
  `statut_vente` enum('en attente','validé','encaissé','retourné','annulé') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'en attente',
  `pay_mode` varchar(100) DEFAULT NULL,
  `entrepot_id` int NOT NULL,
  `created_at` date NOT NULL,
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
  `transaction_code` varchar(50) NOT NULL,
  `client_id` int DEFAULT NULL,
  `fournisseur_id` int DEFAULT NULL,
  `employe_id` int DEFAULT NULL,
  `created_at` date NOT NULL,
  `etat_versement` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_versement`),
  KEY `client_id` (`client_id`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `versement`
--

INSERT INTO `versement` (`ID_versement`, `code_versement`, `montant_versement`, `type_versement`, `transaction_code`, `client_id`, `fournisseur_id`, `employe_id`, `created_at`, `etat_versement`) VALUES
(1, 'VT26069072', 300, 'vente', 'VT26064658', 2, NULL, 1, '2026-04-06', 1),
(2, 'VT26066712', 300, 'vente', 'VT26064658', 2, NULL, 1, '2026-04-06', 1),
(3, 'VT26068000', 300, 'vente', 'VT26064658', 2, NULL, 1, '2026-04-06', 1),
(5, 'VT26064997', 100, 'vente', 'VT26064658', 2, NULL, 1, '2026-04-06', 1),
(7, 'VT26069495', 20, 'vente', 'VT26064658', 2, NULL, 1, '2026-04-06', 1),
(8, 'AC2606982', 1000, 'achat', 'AC260393', NULL, 4, 1, '2026-04-06', 1),
(9, 'VT26078786', 300, 'vente', 'VT26036330', 2, NULL, 1, '2026-04-07', 1),
(10, 'VT26079961', 300, 'vente', 'VT26036330', 2, NULL, 1, '2026-04-07', 1),
(11, 'VT26073537', 300, 'vente', 'VT26036330', 2, NULL, 1, '2026-04-07', 1),
(12, 'VT26075330', 300, 'vente', 'VT26036330', 2, NULL, 1, '2026-04-07', 1),
(13, 'VT260747', 300, 'vente', 'VT26036330', 2, NULL, 1, '2026-04-07', 1),
(14, 'VT2607853', 300, 'vente', 'VT26074316', 3, NULL, 1, '2026-04-07', 1),
(15, 'VT26079483', 700, 'vente', 'VT26074316', 3, NULL, 1, '2026-04-07', 1),
(16, 'AC2607429', 100, 'achat', 'AC260393', NULL, 4, 1, '2026-04-07', 1),
(17, 'VT26073667', 300, 'vente', 'VT260236', 2, NULL, 1, '2026-04-07', 1),
(18, 'AC2607807', 1000, 'achat', 'AC260393', NULL, 4, 1, '2026-04-07', 1);

-- --------------------------------------------------------

--
-- Structure de la vue `bilan_entree`
--
DROP TABLE IF EXISTS `bilan_entree`;

DROP VIEW IF EXISTS `bilan_entree`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bilan_entree`  AS SELECT `ar`.`ID_article` AS `ID_article`, `ar`.`libelle_article` AS `article`, sum(`en`.`qte`) AS `en_qte`, sum((`en`.`prix_achat` * `en`.`qte`)) AS `en_montant` FROM (`article` `ar` join `entree` `en` on((`en`.`article_id` = `ar`.`ID_article`))) WHERE (`en`.`etat_entree` = 1) GROUP BY `ar`.`ID_article` ;

-- --------------------------------------------------------

--
-- Structure de la vue `bilan_sortie`
--
DROP TABLE IF EXISTS `bilan_sortie`;

DROP VIEW IF EXISTS `bilan_sortie`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bilan_sortie`  AS SELECT `ar`.`ID_article` AS `ID_article`, `ar`.`libelle_article` AS `article`, sum(`so`.`qte`) AS `so_qte`, sum((`so`.`prix_vente` * `so`.`qte`)) AS `so_montant` FROM (`article` `ar` join `sortie` `so` on((`so`.`article_id` = `ar`.`ID_article`))) WHERE (`so`.`etat_sortie` = 1) GROUP BY `ar`.`ID_article` ;

-- --------------------------------------------------------

--
-- Structure de la vue `comptabilite`
--
DROP TABLE IF EXISTS `comptabilite`;

DROP VIEW IF EXISTS `comptabilite`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comptabilite`  AS SELECT `be`.`ID_article` AS `id_article`, `be`.`article` AS `article`, `be`.`en_montant` AS `depenses`, if((`bs`.`so_montant` is null),0,`bs`.`so_montant`) AS `ventes`, (`be`.`en_qte` - if((`bs`.`so_qte` is null),0,`bs`.`so_qte`)) AS `qte_reste`, ((`be`.`en_qte` - if((`bs`.`so_qte` is null),0,`bs`.`so_qte`)) * `ar`.`prix_article`) AS `mt_reste`, ((if((`bs`.`so_montant` is null),0,`bs`.`so_montant`) + ((`be`.`en_qte` - if((`bs`.`so_qte` is null),0,`bs`.`so_qte`)) * `ar`.`prix_article`)) - `be`.`en_montant`) AS `gain` FROM ((`bilan_entree` `be` left join `bilan_sortie` `bs` on((`be`.`ID_article` = `bs`.`ID_article`))) join `article` `ar` on((`ar`.`ID_article` = `be`.`ID_article`))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `achat_ibfk_1` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`) ON DELETE CASCADE,
  ADD CONSTRAINT `achat_ibfk_2` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`ID_fournisseur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`famille_id`) REFERENCES `famille` (`ID_famille`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`ID_mark`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`ID_unite`) ON DELETE CASCADE;

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`) ON DELETE CASCADE;

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_depense` (`id_type`),
  ADD CONSTRAINT `depense_ibfk_2` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`ID_role`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entree`
--
ALTER TABLE `entree`
  ADD CONSTRAINT `entree_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`ID_article`) ON DELETE CASCADE;

--
-- Contraintes pour la table `famille`
--
ALTER TABLE `famille`
  ADD CONSTRAINT `famille_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`ID_categorie`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `sortie_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`ID_article`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_ibfk_1` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `versement`
--
ALTER TABLE `versement`
  ADD CONSTRAINT `versement_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `versement_ibfk_2` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
