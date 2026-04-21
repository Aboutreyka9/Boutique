ajout de :
- type_versement in versement table
- transaction_code in versement table
- pay_mode in achat table
- entrepot_id in achat table
change type de statut_vente en enum() => default en attente

- ALTER TABLE `employe` ADD `email_employe` VARCHAR(100) NULL DEFAULT NULL AFTER `telephone_employe`;


<!-- 18/10/2025 à 15h12 -->
ALTER TABLE `depense` CHANGE `statut_depense` `statut_depense` ENUM('en attente','approuvé','annulé','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'en attente';


removed client_id & fournisseur_id in table versement