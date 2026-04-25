CREATE OR REPLACE VIEW vue_etat_paiements AS
SELECT 
    'VENTE' AS nature,
    v.entrepot_id AS entrepot,
    v.code_vente AS code_transaction,
    IFNULL(ver.pay_mode, '...') AS pay_mode,
    v.created_at AS date_facture,
    v.statut_vente,
    vmt.montant_total AS montant_facture,
    COALESCE(SUM(ver.montant_versement), 0) AS total_paye,
    (vmt.montant_total - COALESCE(SUM(ver.montant_versement), 0)) AS reste_a_payer,
    CASE 
        WHEN COALESCE(SUM(ver.montant_versement), 0) <= 0 THEN 'Non payé'
        WHEN COALESCE(SUM(ver.montant_versement), 0) < vmt.montant_total THEN 'Partiel'
        ELSE 'Soldé'
    END AS statut_paiement
FROM vente v
JOIN vue_montant_ventes vmt ON vmt.code_vente = v.code_vente
JOIN sortie so ON so.vente_id = v.code_vente
LEFT JOIN versement ver ON v.code_vente = ver.transaction_code AND ver.type_versement = 'vente' and ver.etat_versement = 1   WHERE  v.statut_vente  IN('valide','encaisse')
GROUP BY v.ID_vente

UNION ALL

SELECT 
    ver. AS nature,
    a.entrepot_id AS entrepot,
    a.code_achat AS code_transaction,
    ver.pay_mode,
    a.created_at AS date_facture,
    a.statut_achat,
    vma.montant_total AS montant_facture,
    COALESCE(SUM(ver.montant_versement), 0) AS total_paye,
    (vma.montant_total - COALESCE(SUM(ver.montant_versement), 0)) AS reste_a_payer,
    CASE 
        WHEN COALESCE(SUM(ver.montant_versement), 0) <= 0 THEN 'Non payé'
        WHEN COALESCE(SUM(ver.montant_versement), 0) < vma.montant_total THEN 'Partiel'
        ELSE 'Soldé'
    END AS statut_paiement
FROM achat a
JOIN vue_montant_achats vma ON vma.code_achat = a.code_achat
JOIN entree en ON en.achat_id = a.code_achat
LEFT JOIN versement ver ON a.code_achat = ver.transaction_code AND ver.type_versement = 'achat' AND ver.etat_versement = 1 
 WHERE a.statut_achat IN('valide','encaisse')
GROUP BY a.ID_achat;