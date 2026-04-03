
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Base de données : boutique
--
CREATE DATABASE IF NOT EXISTS magasin DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE magasin;

-- --------------------------------------------------------

--
-- Structure de la table achat
--

CREATE TABLE IF NOT EXISTS achat (
  ID_achat int(11) NOT NULL AUTO_INCREMENT,
  code_achat varchar(50) NOT NULL,
  employe_id int(11) NOT NULL,
  fournisseur_id int(11) NOT NULL,
  etat_achat int(1) DEFAULT '1',
  created_at date NOT NULL,
  PRIMARY KEY (ID_achat),
  KEY employe_id (employe_id),
  KEY fournisseur_id (fournisseur_id)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table article
--

CREATE TABLE IF NOT EXISTS article (
  ID_article int(11) NOT NULL AUTO_INCREMENT,
  libelle_article varchar(100) NOT NULL,
  prix_article int(11) NOT NULL,
  famille_id int(11) NOT NULL,
  mark_id int(11) NOT NULL,
  unite_id int(11) NOT NULL DEFAULT '1',
  etat_article int(1) NOT NULL,
  created_at date NOT NULL,
  slug varchar(50) NOT NULL,
  stock_alert int(11) NOT NULL,
  garantie_article int(11) NOT NULL,
  PRIMARY KEY (ID_article),
  KEY famille_article (famille_id),
  KEY mark_id (mark_id),
  KEY unite_id (unite_id)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table categorie
--

CREATE TABLE IF NOT EXISTS categorie (
  ID_categorie int(11) NOT NULL AUTO_INCREMENT,
  libelle_categorie varchar(100) NOT NULL,
  etat_categorie int(1) NOT NULL,
  created_at date NOT NULL,
  PRIMARY KEY (ID_categorie)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table client
--

CREATE TABLE IF NOT EXISTS `client` (
  ID_client int(11) NOT NULL AUTO_INCREMENT,
  nom_client varchar(50) NOT NULL,
  prenom_client varchar(50) NOT NULL,
  telephone_client varchar(15) NOT NULL,
  code_client varchar(50) NOT NULL,
  solde_client int(11) NOT NULL DEFAULT '0',
  created_at date NOT NULL,
  etat_client int(1) NOT NULL,
  employe_id int(11) NOT NULL,
  updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_client),
  KEY employe_id (employe_id)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table client
--

INSERT INTO client (ID_client, nom_client, prenom_client, telephone_client, code_client, solde_client, created_at, etat_client, employe_id, updated_at) VALUES
(1, 'client', '001', '0000000000', 'CL00000', 000, '2020-01-01', 1, 1, '2022-01-01 00:00:00');


-- --------------------------------------------------------

--

CREATE TABLE IF NOT EXISTS config (
  ID_config int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(100) NOT NULL,
  adresse text NOT NULL,
  contact1 varchar(20) NOT NULL,
  contact2 varchar(20) NOT NULL,
  email varchar(50) NOT NULL,
  image varchar(100) NOT NULL,
  crreated_at date DEFAULT NULL,
  client int(11) DEFAULT NULL,
  fournisseur int(11) DEFAULT NULL,
  supprimer int(11) DEFAULT NULL,
  PRIMARY KEY (ID_config)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table config
--

INSERT INTO config (ID_config, nom, adresse, contact1, contact2, email, image, crreated_at, client, fournisseur, supprimer) VALUES
(1, 'NOM BOUTIQUEPP', '', '00000000', '00000000', 'exemple@nom.com', 'http://shop.ivoire-ticket.com/assets/images/default.png', '2020-01-01', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table employe
--

CREATE TABLE IF NOT EXISTS employe (
  ID_employe int(11) NOT NULL AUTO_INCREMENT,
  code_employe varchar(50) NOT NULL,
  nom_employe varchar(50) NOT NULL,
  prenom_employe varchar(50) NOT NULL,
  telephone_employe varchar(15) NOT NULL,
  password_employe varchar(100) NOT NULL,
  etat_employe int(1) NOT NULL,
  role_id int(11) NOT NULL,
  login datetime DEFAULT NULL,
  PRIMARY KEY (ID_employe),
  KEY role_id (role_id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table employe
--

INSERT INTO employe (ID_employe, code_employe, nom_employe, prenom_employe, telephone_employe, password_employe, etat_employe, role_id, login) VALUES
(1, 'EM00000', 'Admin', 'Admin', '0102030405', '53e6086284353cb73d4979f08537d950', 1, 1, '2020-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table entree
--

CREATE TABLE IF NOT EXISTS entree (
  ID_entree int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  achat_id varchar(50) NOT NULL,
  etat_entree int(1) NOT NULL DEFAULT '1',
  prix_achat int(11) NOT NULL,
  qte int(11) NOT NULL,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_entree),
  KEY article_id (article_id)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table famille
--

CREATE TABLE IF NOT EXISTS famille (
  ID_famille int(11) NOT NULL AUTO_INCREMENT,
  libelle_famille varchar(100) NOT NULL,
  categorie_id int(11) NOT NULL,
  etat_famille int(1) NOT NULL,
  created_at date NOT NULL,
  PRIMARY KEY (ID_famille),
  KEY categorie_id (categorie_id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table fournisseur
--

CREATE TABLE IF NOT EXISTS fournisseur (
  ID_fournisseur int(11) NOT NULL AUTO_INCREMENT,
  code_fournisseur varchar(50) NOT NULL,
  nom_fournisseur varchar(100) NOT NULL,
  telephone_fournisseur varchar(20) NOT NULL,
  etat_fournisseur int(11) NOT NULL,
  created_at date NOT NULL,
  PRIMARY KEY (ID_fournisseur)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table fournisseur
--

INSERT INTO fournisseur (ID_fournisseur, code_fournisseur, nom_fournisseur, telephone_fournisseur, etat_fournisseur, created_at) VALUES
(1, 'FS0000', 'FOURNISSEUR 000', '00000000', 1, '2020-01-01');

-- --------------------------------------------------------

--
-- Structure de la table mark
--

CREATE TABLE IF NOT EXISTS mark (
  ID_mark int(11) NOT NULL AUTO_INCREMENT,
  libelle_mark varchar(100) NOT NULL,
  etat_mark int(1) NOT NULL,
  created_at date NOT NULL,
  PRIMARY KEY (ID_mark)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table role
--

CREATE TABLE IF NOT EXISTS role (
  ID_role int(11) NOT NULL AUTO_INCREMENT,
  libelle_role varchar(100) NOT NULL,
  etat_role int(1) NOT NULL,
  PRIMARY KEY (ID_role)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table role
--

INSERT INTO role (ID_role, libelle_role, etat_role) VALUES
(1, 'admin', 1),
(2, 'commercial', 1);

-- --------------------------------------------------------

--
-- Structure de la table sortie
--

CREATE TABLE IF NOT EXISTS sortie (
  ID_sortie int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  vente_id varchar(50) NOT NULL,
  prix_vente int(11) NOT NULL,
  qte int(11) NOT NULL,
  etat_sortie int(1) NOT NULL DEFAULT '1',
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_sortie),
  KEY article_id (article_id)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table unite
--

CREATE TABLE IF NOT EXISTS unite (
  ID_unite int(11) NOT NULL AUTO_INCREMENT,
  libelle_unite varchar(50) NOT NULL,
  slug_unite char(50) NOT NULL,
  description_unite text NOT NULL,
  etat_unite enum('0','1') NOT NULL,
  PRIMARY KEY (ID_unite)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table unite
--

INSERT INTO unite (ID_unite, libelle_unite, slug_unite, description_unite, etat_unite) VALUES
(1, 'UNITE', 'UNITE', '', '1');

-- --------------------------------------------------------

--
-- Structure de la table vente
--

CREATE TABLE IF NOT EXISTS vente (
  ID_vente int(11) NOT NULL AUTO_INCREMENT,
  code_vente varchar(50) NOT NULL,
  client_id int(11) NOT NULL,
  employe_id int(11) NOT NULL,
  etat_vente int(1) NOT NULL DEFAULT '1',
  created_at date NOT NULL,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_vente),
  KEY employe_id (employe_id),
  KEY client_id (client_id)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table versement
--

CREATE TABLE IF NOT EXISTS versement (
  ID_versement int(11) NOT NULL AUTO_INCREMENT,
  code_versement varchar(50) NOT NULL,
  montant_versement int(11) NOT NULL,
  client_id int(11) NOT NULL,
  employe_id int(11) NOT NULL,
  created_at date NOT NULL,
  etat_versement int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (ID_versement),
  KEY client_id (client_id),
  KEY employe_id (employe_id)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la vue bilan_entree
--
DROP TABLE IF EXISTS `bilan_entree`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW bilan_entree  AS SELECT ar.ID_article AS `ID_article`, ar.libelle_article AS `article`, sum(en.qte) AS `en_qte`, sum((en.prix_achat * en.qte)) AS `en_montant` FROM (article ar join entree en on((en.article_id = ar.ID_article))) WHERE (en.etat_entree = 1) GROUP BY ar.ID_article ;

-- --------------------------------------------------------

--
-- Structure de la vue bilan_sortie
--
DROP TABLE IF EXISTS `bilan_sortie`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW bilan_sortie  AS SELECT ar.ID_article AS `ID_article`, ar.libelle_article AS `article`, sum(so.qte) AS `so_qte`, sum((so.prix_vente * so.qte)) AS `so_montant` FROM (article ar join sortie so on((so.article_id = ar.ID_article))) WHERE (so.etat_sortie = 1) GROUP BY ar.ID_article ;

-- --------------------------------------------------------

--
-- Structure de la vue comptabilite
--
DROP TABLE IF EXISTS `comptabilite`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW comptabilite  AS SELECT be.ID_article AS `id_article`, be.article AS `article`, be.en_montant AS `depenses`, if(isnull(bs.so_montant),0,bs.so_montant) AS `ventes`, (be.en_qte - if(isnull(bs.so_qte),0,bs.so_qte)) AS `qte_reste`, ((be.en_qte - if(isnull(bs.so_qte),0,bs.so_qte)) * ar.prix_article) AS `mt_reste`, ((if(isnull(bs.so_montant),0,bs.so_montant) + ((be.en_qte - if(isnull(bs.so_qte),0,bs.so_qte)) * ar.prix_article)) - be.en_montant) AS `gain` FROM ((bilan_entree be left join bilan_sortie bs on((be.ID_article = bs.ID_article))) join article ar on((ar.ID_article = be.ID_article))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table achat
--
ALTER TABLE achat
  ADD CONSTRAINT achat_ibfk_1 FOREIGN KEY (employe_id) REFERENCES employe (ID_employe) ON DELETE CASCADE,
  ADD CONSTRAINT achat_ibfk_2 FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (ID_fournisseur) ON DELETE CASCADE;

--
-- Contraintes pour la table article
--
ALTER TABLE article
  ADD CONSTRAINT article_ibfk_1 FOREIGN KEY (famille_id) REFERENCES famille (ID_famille) ON DELETE CASCADE,
  ADD CONSTRAINT article_ibfk_2 FOREIGN KEY (mark_id) REFERENCES mark (ID_mark) ON DELETE CASCADE,
  ADD CONSTRAINT article_ibfk_3 FOREIGN KEY (unite_id) REFERENCES unite (ID_unite) ON DELETE CASCADE;

--
-- Contraintes pour la table client
--
ALTER TABLE client
  ADD CONSTRAINT client_ibfk_1 FOREIGN KEY (employe_id) REFERENCES employe (ID_employe) ON DELETE CASCADE;

--
-- Contraintes pour la table employe
--
ALTER TABLE employe
  ADD CONSTRAINT employe_ibfk_1 FOREIGN KEY (role_id) REFERENCES role (ID_role) ON DELETE CASCADE;

--
-- Contraintes pour la table entree
--
ALTER TABLE entree
  ADD CONSTRAINT entree_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (ID_article) ON DELETE CASCADE;

--
-- Contraintes pour la table famille
--
ALTER TABLE famille
  ADD CONSTRAINT famille_ibfk_1 FOREIGN KEY (categorie_id) REFERENCES categorie (ID_categorie) ON DELETE CASCADE;

--
-- Contraintes pour la table sortie
--
ALTER TABLE sortie
  ADD CONSTRAINT sortie_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (ID_article) ON DELETE CASCADE;

--
-- Contraintes pour la table vente
--
ALTER TABLE vente
  ADD CONSTRAINT vente_ibfk_1 FOREIGN KEY (employe_id) REFERENCES employe (ID_employe) ON DELETE CASCADE,
  ADD CONSTRAINT vente_ibfk_2 FOREIGN KEY (client_id) REFERENCES client (ID_client) ON DELETE CASCADE;

--
-- Contraintes pour la table versement
--
ALTER TABLE versement
  ADD CONSTRAINT versement_ibfk_1 FOREIGN KEY (client_id) REFERENCES client (ID_client) ON DELETE CASCADE,
  ADD CONSTRAINT versement_ibfk_2 FOREIGN KEY (employe_id) REFERENCES employe (ID_employe) ON DELETE CASCADE;
COMMIT;
