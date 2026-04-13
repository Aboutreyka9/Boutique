-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 03 nov. 2025 à 17:32
-- Version du serveur : 10.11.14-MariaDB-cll-lve
-- Version de PHP : 8.3.23

SET SESSION sql_mode = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `achat` (
  `ID_achat` int(11) NOT NULL,
  `code_achat` varchar(50) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `fournisseur_id` int(11) NOT NULL,
  `etat_achat` int(11) DEFAULT 1,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`ID_achat`, `code_achat`, `employe_id`, `fournisseur_id`, `etat_achat`, `created_at`) VALUES
(1, 'AC252580', 1, 3, 1, '2025-09-25');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `ID_article` int(11) NOT NULL,
  `libelle_article` varchar(100) NOT NULL,
  `prix_article` int(11) NOT NULL,
  `famille_id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `unite_id` int(11) NOT NULL DEFAULT 1,
  `etat_article` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `slug` varchar(50) NOT NULL,
  `stock_alert` int(11) NOT NULL,
  `garantie_article` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_article`, `libelle_article`, `prix_article`, `famille_id`, `mark_id`, `unite_id`, `etat_article`, `created_at`, `slug`, `stock_alert`, `garantie_article`) VALUES
(1, 'VULCAN', 2500, 1, 1, 1, 1, '2025-09-10', 'Vul', 24, 0),
(2, 'VERRON', 3000, 2, 1, 1, 1, '2025-09-10', 'ver', 5, 0),
(3, 'VIDAG', 15000, 2, 1, 1, 1, '2025-09-23', 'VDG', 10, 1),
(4, 'GART', 7000, 2, 1, 1, 1, '2025-09-23', 'GART', 15, 0);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_entree`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `bilan_entree` (
`ID_article` int(11)
,`article` varchar(100)
,`en_qte` decimal(32,0)
,`en_montant` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `bilan_sortie`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `bilan_sortie` (
`ID_article` int(11)
,`article` varchar(100)
,`so_qte` decimal(32,0)
,`so_montant` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `ID_categorie` int(11) NOT NULL,
  `libelle_categorie` varchar(100) NOT NULL,
  `etat_categorie` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID_categorie`, `libelle_categorie`, `etat_categorie`, `created_at`) VALUES
(1, 'LUBRIFIANT', 1, '2025-09-10'),
(2, 'GRAISSE', 1, '2025-09-10');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `ID_client` int(11) NOT NULL,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `telephone_client` varchar(15) NOT NULL,
  `code_client` varchar(50) NOT NULL,
  `solde_client` int(11) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL,
  `etat_client` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID_client`, `nom_client`, `prenom_client`, `telephone_client`, `code_client`, `solde_client`, `created_at`, `etat_client`, `employe_id`, `updated_at`) VALUES
(1, 'KONE MARIAM', 'ASSOFIE', '0700000000', 'CL00000', 1500, '2020-01-01', 1, 1, '2022-01-01 00:00:00'),
(18, 'SANOGO ', 'Abou', '0102308002', 'CL2506383', 41900, '2025-08-06', 1, 1, '2025-08-06 18:50:38');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `comptabilite`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `comptabilite` (
`id_article` int(11)
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

CREATE TABLE `config` (
  `ID_config` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `contact1` varchar(20) NOT NULL,
  `contact2` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `crreated_at` date DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `fournisseur` int(11) DEFAULT NULL,
  `supprimer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `config`
--

INSERT INTO `config` (`ID_config`, `nom`, `adresse`, `contact1`, `contact2`, `email`, `image`, `crreated_at`, `client`, `fournisseur`, `supprimer`) VALUES
(1, 'BOUTIQUE PROMAX', 'BOUAKE,ZONE TERMINUS', '0504030201', '0102030406', 'exemple@nom.com', 'https://boutique.kassanngroup.com/assets/images/1244890654.jpeg', '2020-01-01', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE `depense` (
  `id_depense` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `montant` float NOT NULL,
  `description` text NOT NULL,
  `periode` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `etat_depense` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `ID_employe` int(11) NOT NULL,
  `code_employe` varchar(50) NOT NULL,
  `nom_employe` varchar(50) NOT NULL,
  `prenom_employe` varchar(50) NOT NULL,
  `telephone_employe` varchar(15) NOT NULL,
  `password_employe` varchar(100) NOT NULL,
  `etat_employe` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`ID_employe`, `code_employe`, `nom_employe`, `prenom_employe`, `telephone_employe`, `password_employe`, `etat_employe`, `role_id`, `login`) VALUES
(1, 'EM00000', 'Admin', 'Admin', '0102030405', '202cb962ac59075b964b07152d234b70', 1, 1, '2025-10-20 02:51:07'),
(11, 'EM25051188', 'CAMARA', 'Georges', '0566015516', '202cb962ac59075b964b07152d234b70', 1, 2, '2025-11-02 22:03:17'),
(12, 'EM25093690', 'KOFFI', 'AndrÃ©', '0166749966', '6ac91f0ed946885e7573b4f2a2ee8075', 1, 1, NULL),
(13, 'EM25095215', 'AYA', 'Sanogo', '0699331122', 'de4ea80ff5c195340cd6666d7223a3e7', 0, 2, NULL),
(14, 'EM250979', 'CAMARA', 'Blaise', '0122334455', '720131d06307e753ba4f1cca86d66043', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

CREATE TABLE `entree` (
  `ID_entree` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `achat_id` varchar(50) NOT NULL,
  `etat_entree` int(11) NOT NULL DEFAULT 1,
  `prix_achat` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `entree`
--

INSERT INTO `entree` (`ID_entree`, `article_id`, `achat_id`, `etat_entree`, `prix_achat`, `qte`, `updated_at`) VALUES
(1, 1, 'AC252580', 1, 2250, 120, '2025-09-25 10:59:42'),
(2, 4, 'AC252580', 1, 6000, 50, '2025-09-25 10:59:42');

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE `famille` (
  `ID_famille` int(11) NOT NULL,
  `libelle_famille` varchar(100) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `etat_famille` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `famille`
--

INSERT INTO `famille` (`ID_famille`, `libelle_famille`, `categorie_id`, `etat_famille`, `created_at`) VALUES
(1, 'DIESEL', 1, 1, '2025-09-10'),
(2, 'MP', 2, 1, '2025-09-10');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `ID_fournisseur` int(11) NOT NULL,
  `code_fournisseur` varchar(50) NOT NULL,
  `nom_fournisseur` varchar(100) NOT NULL,
  `telephone_fournisseur` varchar(20) NOT NULL,
  `etat_fournisseur` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`ID_fournisseur`, `code_fournisseur`, `nom_fournisseur`, `telephone_fournisseur`, `etat_fournisseur`, `created_at`) VALUES
(1, 'FS25206555', 'ABOUDRAMANE CISSÃ©', '0102020301', 1, '2025-08-20'),
(2, 'FS25206335', 'KOUSSI ALFRED', '0566332211', 1, '2025-08-20'),
(3, 'FS25068318', 'MARIAM KONATE', '0156336655', 1, '2025-09-06'),
(4, 'FS00004', 'Camara bon ', '0566012233', 0, '2025-09-09');

-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

CREATE TABLE `mark` (
  `ID_mark` int(11) NOT NULL,
  `libelle_mark` varchar(100) NOT NULL,
  `etat_mark` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `mark`
--

INSERT INTO `mark` (`ID_mark`, `libelle_mark`, `etat_mark`, `created_at`) VALUES
(1, 'ENOC', 1, '2025-09-10');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `ID_role` int(11) NOT NULL,
  `libelle_role` varchar(100) NOT NULL,
  `etat_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `sortie` (
  `ID_sortie` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `vente_id` varchar(50) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `etat_sortie` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`ID_sortie`, `article_id`, `vente_id`, `prix_vente`, `qte`, `etat_sortie`, `updated_at`) VALUES
(1, 2, 'VT2502833', 2500, 1, 1, '2025-11-02 20:59:35'),
(2, 1, 'VT2502833', 3000, 1, 1, '2025-11-02 20:59:35'),
(3, 3, 'VT25023105', 2000, 3, 1, '2025-11-02 21:04:30'),
(4, 2, 'VT25023105', 3000, 2, 1, '2025-11-02 21:04:30');

-- --------------------------------------------------------

--
-- Structure de la table `type_depense`
--

CREATE TABLE `type_depense` (
  `id_type` int(11) NOT NULL,
  `libelle_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `unite` (
  `ID_unite` int(11) NOT NULL,
  `libelle_unite` varchar(50) NOT NULL,
  `slug_unite` char(50) NOT NULL,
  `description_unite` text NOT NULL,
  `etat_unite` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `unite`
--

INSERT INTO `unite` (`ID_unite`, `libelle_unite`, `slug_unite`, `description_unite`, `etat_unite`) VALUES
(1, 'Unite', 'U', 'Nous vendons par unite', '1');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `ID_vente` int(11) NOT NULL,
  `code_vente` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `etat_vente` int(11) NOT NULL DEFAULT 1,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`ID_vente`, `code_vente`, `client_id`, `employe_id`, `etat_vente`, `created_at`, `updated_at`) VALUES
(1, 'VT2502833', 1, 1, 1, '2025-11-02', '2025-11-02 20:59:35'),
(2, 'VT25023105', 18, 1, 1, '2025-11-02', '2025-11-02 21:04:30');

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

CREATE TABLE `versement` (
  `ID_versement` int(11) NOT NULL,
  `code_versement` varchar(50) NOT NULL,
  `montant_versement` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `etat_versement` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`ID_achat`),
  ADD KEY `employe_id` (`employe_id`),
  ADD KEY `fournisseur_id` (`fournisseur_id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID_article`),
  ADD KEY `famille_article` (`famille_id`),
  ADD KEY `mark_id` (`mark_id`),
  ADD KEY `unite_id` (`unite_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID_categorie`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID_client`),
  ADD KEY `employe_id` (`employe_id`);

--
-- Index pour la table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`ID_config`);

--
-- Index pour la table `depense`
--
ALTER TABLE `depense`
  ADD PRIMARY KEY (`id_depense`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `employe_id` (`employe_id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`ID_employe`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `entree`
--
ALTER TABLE `entree`
  ADD PRIMARY KEY (`ID_entree`),
  ADD KEY `article_id` (`article_id`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
  ADD PRIMARY KEY (`ID_famille`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`ID_fournisseur`);

--
-- Index pour la table `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`ID_mark`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID_role`);

--
-- Index pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD PRIMARY KEY (`ID_sortie`),
  ADD KEY `article_id` (`article_id`);

--
-- Index pour la table `type_depense`
--
ALTER TABLE `type_depense`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `unite`
--
ALTER TABLE `unite`
  ADD PRIMARY KEY (`ID_unite`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`ID_vente`),
  ADD KEY `employe_id` (`employe_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `versement`
--
ALTER TABLE `versement`
  ADD PRIMARY KEY (`ID_versement`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `employe_id` (`employe_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `ID_achat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `ID_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `ID_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `config`
--
ALTER TABLE `config`
  MODIFY `ID_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `depense`
--
ALTER TABLE `depense`
  MODIFY `id_depense` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `ID_employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `entree`
--
ALTER TABLE `entree`
  MODIFY `ID_entree` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
  MODIFY `ID_famille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `ID_fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mark`
--
ALTER TABLE `mark`
  MODIFY `ID_mark` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `ID_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sortie`
--
ALTER TABLE `sortie`
  MODIFY `ID_sortie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_depense`
--
ALTER TABLE `type_depense`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `unite`
--
ALTER TABLE `unite`
  MODIFY `ID_unite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `ID_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `versement`
--
ALTER TABLE `versement`
  MODIFY `ID_versement` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure de la vue `bilan_entree`
--
DROP TABLE IF EXISTS `bilan_entree`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bilan_entree`  AS SELECT `ar`.`ID_article` AS `ID_article`, `ar`.`libelle_article` AS `article`, sum(`en`.`qte`) AS `en_qte`, sum(`en`.`prix_achat` * `en`.`qte`) AS `en_montant` FROM (`article` `ar` join `entree` `en` on(`en`.`article_id` = `ar`.`ID_article`)) WHERE `en`.`etat_entree` = 1 GROUP BY `ar`.`ID_article` ;

-- --------------------------------------------------------

--
-- Structure de la vue `bilan_sortie`
--
DROP TABLE IF EXISTS `bilan_sortie`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bilan_sortie`  AS SELECT `ar`.`ID_article` AS `ID_article`, `ar`.`libelle_article` AS `article`, sum(`so`.`qte`) AS `so_qte`, sum(`so`.`prix_vente` * `so`.`qte`) AS `so_montant` FROM (`article` `ar` join `sortie` `so` on(`so`.`article_id` = `ar`.`ID_article`)) WHERE `so`.`etat_sortie` = 1 GROUP BY `ar`.`ID_article` ;

-- --------------------------------------------------------

--
-- Structure de la vue `comptabilite`
--
DROP TABLE IF EXISTS `comptabilite`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comptabilite`  AS SELECT `be`.`ID_article` AS `id_article`, `be`.`article` AS `article`, `be`.`en_montant` AS `depenses`, if(`bs`.`so_montant` is null,0,`bs`.`so_montant`) AS `ventes`, `be`.`en_qte`- if(`bs`.`so_qte` is null,0,`bs`.`so_qte`) AS `qte_reste`, (`be`.`en_qte` - if(`bs`.`so_qte` is null,0,`bs`.`so_qte`)) * `ar`.`prix_article` AS `mt_reste`, if(`bs`.`so_montant` is null,0,`bs`.`so_montant`) + (`be`.`en_qte` - if(`bs`.`so_qte` is null,0,`bs`.`so_qte`)) * `ar`.`prix_article` - `be`.`en_montant` AS `gain` FROM ((`bilan_entree` `be` left join `bilan_sortie` `bs` on(`be`.`ID_article` = `bs`.`ID_article`)) join `article` `ar` on(`ar`.`ID_article` = `be`.`ID_article`)) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_depense` (`id_type`),
  ADD CONSTRAINT `depense_ibfk_2` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`ID_employe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
