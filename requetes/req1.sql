
CREATE VIEW view_stock_produit AS SELECT 
    a.ID_article,
    a.libelle_article,
    en.entrepot_id,
    e.libelle_entrepot,
    -- 1. Calcul de la quantité disponible (Stock Réel)
    (
        SELECT 
            COALESCE(m_inv.quantite, 0) + 
            COALESCE(SUM(CASE 
                WHEN m.type_mouvement IN ('ENTREE', 'RETOUR_CLIENT', 'TRANSFERT_IN', 'AJUSTEMENT_POSITIF') THEN m.quantite 
                WHEN m.type_mouvement IN ('SORTIE', 'RETOUR_FOURNISSEUR', 'TRANSFERT_OUT', 'AJUSTEMENT_NEGATIF', 'CASSE') THEN -m.quantite 
                ELSE 0 
            END), 0)
        FROM (
            -- On identifie l'ID du dernier inventaire pour cet article
            SELECT MAX(ID_mouvement_stock) as last_inv_id, quantite
            FROM mouvement_stock 
            WHERE article_id = a.ID_article AND type_mouvement = 'INVENTAIRE'
            GROUP BY quantite 
            ORDER BY last_inv_id DESC LIMIT 1
        ) AS m_inv
        LEFT JOIN mouvement_stock m ON m.article_id = a.ID_article 
            AND m.ID_mouvement_stock > m_inv.last_inv_id
    ) AS quantite_disponible,

    -- 2. Valorisation du stock (Quantité * Dernier Prix d'Achat)
    (
        SELECT (quantite_disponible * COALESCE(prix_achat, 0))
        FROM mouvement_stock 
        WHERE article_id = a.ID_article AND prix_achat > 0
        ORDER BY date_mouvement DESC, ID_mouvement_stock DESC LIMIT 1
    ) AS montant_total_stock

FROM article a 
JOIN entrepot_article en ON en.article_id = a.ID_article JOIN entrepot e ON e.ID_entrepot = en.entrepot_id GROUP BY e.ID_entrepot,a.ID_article; 