-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 18 août 2025 à 15:41
-- Version du serveur : 8.3.0
-- Version de PHP : 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
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
  `prix_article` int NOT NULL,
  `famille_id` int NOT NULL,
  `mark_id` int NOT NULL,
  `unite_id` int NOT NULL DEFAULT '1',
  `etat_article` int NOT NULL,
  `created_at` date NOT NULL,
  `slug` varchar(50) NOT NULL,
  `stock_alert` int NOT NULL,
  `garantie_article` int NOT NULL,
  PRIMARY KEY (`ID_article`),
  KEY `famille_article` (`famille_id`),
  KEY `mark_id` (`mark_id`),
  KEY `unite_id` (`unite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_entree`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `bilan_entree`;
CREATE TABLE IF NOT EXISTS `bilan_entree` (
`ID_article` int
,`article` varchar(100)
,`en_qte` decimal(32,0)
,`en_montant` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_sortie`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `bilan_sortie`;
CREATE TABLE IF NOT EXISTS `bilan_sortie` (
`ID_article` int
,`article` varchar(100)
,`so_qte` decimal(32,0)
,`so_montant` decimal(42,0)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `ID_client` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `telephone_client` varchar(15) NOT NULL,
  `code_client` varchar(50) NOT NULL,
  `solde_client` int NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `etat_client` int NOT NULL,
  `employe_id` int NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_client`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID_client`, `nom_client`, `prenom_client`, `telephone_client`, `code_client`, `solde_client`, `created_at`, `etat_client`, `employe_id`, `updated_at`) VALUES
(1, 'KONE MARIAM', 'ASSOFIE', '0700000000', 'CL00000', 5000, '2020-01-01', 1, 1, '2022-01-01 00:00:00'),
(18, 'SANOGO ', 'Abou', '0102308002', 'CL2506383', 0, '2025-08-06', 1, 1, '2025-08-06 18:50:38');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `comptabilite`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `comptabilite`;
CREATE TABLE IF NOT EXISTS `comptabilite` (
`id_article` int
,`article` varchar(100)
,`depenses` decimal(42,0)
,`ventes` decimal(42,0)
,`qte_reste` decimal(33,0)
,`mt_reste` decimal(43,0)
,`gain` decimal(45,0)
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
(1, 'BOUTIQUE PROMAX', 'UNE BOUTIQUE MODERNE ', '00000000', '00000000', 'exemple@nom.com', 'http://localhost/boutique/assets/images/1163822783.png', '2020-01-01', 0, 0, 1);

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
  `password_employe` varchar(100) NOT NULL,
  `etat_employe` int NOT NULL,
  `role_id` int NOT NULL,
  `login` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_employe`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`ID_employe`, `code_employe`, `nom_employe`, `prenom_employe`, `telephone_employe`, `password_employe`, `etat_employe`, `role_id`, `login`) VALUES
(1, 'EM00000', 'Admin', 'Admin', '0102030405', '202cb962ac59075b964b07152d234b70', 1, 1, '2025-08-18 03:40:38'),
(11, 'EM25051188', 'CAMARA', 'Georges', '0566015516', '202cb962ac59075b964b07152d234b70', 1, 2, '2025-08-18 01:44:03');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  PRIMARY KEY (`ID_fournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`ID_role`, `libelle_role`, `etat_role`) VALUES
(1, 'admin', 1),
(2, 'commercial', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `client_id` int NOT NULL,
  `employe_id` int NOT NULL,
  `created_at` date NOT NULL,
  `etat_versement` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_versement`),
  KEY `client_id` (`client_id`),
  KEY `employe_id` (`employe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `versement`
--

INSERT INTO `versement` (`ID_versement`, `code_versement`, `montant_versement`, `client_id`, `employe_id`, `created_at`, `etat_versement`) VALUES
(29, 'VR2505765', 5000, 1, 1, '2025-08-05', 1);

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
