CREATE OR REPLACE VIEW vue_bilan_articles AS SELECT 
    ea.entrepot_id,
    e.libelle_entrepot,
    a.ID_article AS article_id,
    a.libelle_article,
    
    -- 1. QUANTITÉ APPROVISIONNEMENT (Dernier Inventaire + Entrées nettes)
    -- Note : On ne met pas le RETOUR_CLIENT ici car il annule une vente, il n'est pas un nouvel achat.
    (COALESCE(vdi.quantite_inv, 0) + 
     COALESCE((SELECT SUM(m.quantite) FROM mouvement_stock m 
               WHERE m.article_id = a.ID_article AND m.entrepot_id = ea.entrepot_id 
               AND m.type_mouvement IN ('ENTREE', 'TRANSFERT_IN', 'AJUSTEMENT_POSITIF')
               AND m.ID_mouvement_stock > vdi.last_inv_id), 0)
    ) AS qte_approvisionnement,

    -- 2. COÛT D'ACHAT
    (COALESCE(vdi.quantite_inv * ea.prix_achat, 0) + 
     COALESCE((SELECT SUM(m.quantite * ea.prix_achat) FROM mouvement_stock m 
               WHERE m.article_id = a.ID_article AND m.entrepot_id = ea.entrepot_id 
               AND m.type_mouvement IN ('ENTREE', 'TRANSFERT_IN', 'AJUSTEMENT_POSITIF')
               AND m.ID_mouvement_stock > vdi.last_inv_id), 0)
    ) AS cout_achat,
   
    -- 3. QUANTITÉ VENDUE (Sorties - Retours Clients)
    -- C'est ici que l'annulation se fait : (Ventes) - (Retours)
    COALESCE((SELECT SUM(
                CASE 
                    WHEN m.type_mouvement = 'SORTIE' THEN m.quantite 
                    WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -m.quantite 
                    ELSE 0 
                END) 
              FROM mouvement_stock m 
              WHERE m.article_id = a.ID_article AND m.entrepot_id = ea.entrepot_id 
              AND m.ID_mouvement_stock > vdi.last_inv_id), 0) AS qte_vendue,

    -- 4. MONTANT VENDU (Chiffre d'affaires net)
    COALESCE((SELECT SUM(
                CASE 
                    WHEN m.type_mouvement = 'SORTIE' THEN (m.quantite * m.prix_vente)
                    WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -(m.quantite * m.prix_vente)
                    ELSE 0 
                END) 
              FROM mouvement_stock m 
              WHERE m.article_id = a.ID_article AND m.entrepot_id = ea.entrepot_id 
              AND m.ID_mouvement_stock > vdi.last_inv_id), 0) AS montant_vendu,

    -- 5. BÉNÉFICE (Marge nette sur les ventes après retours)
    (
        COALESCE((SELECT SUM(
            CASE 
                WHEN m.type_mouvement = 'SORTIE' THEN m.quantite * (m.prix_vente - m.prix_achat)
                WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -(m.quantite * (m.prix_vente - m.prix_achat))
                ELSE 0 
            END) 
        FROM mouvement_stock m 
        WHERE m.article_id = a.ID_article AND m.entrepot_id = ea.entrepot_id 
        AND m.ID_mouvement_stock > vdi.last_inv_id), 0)
    ) AS benefice,

    -- 6. QUANTITÉ RESTANTE (Doit être 50 dans ton cas)
    COALESCE(vs.quantite_disponible, 0) AS qte_restante,

    -- 7. VALEUR DU STOCK RESTANT
    (COALESCE(vs.quantite_disponible, 0) * ea.prix_achat) AS montant_quantite_restant

FROM entrepot_article ea
JOIN article a ON ea.article_id = a.ID_article
JOIN entrepot e ON ea.entrepot_id = e.ID_entrepot
LEFT JOIN vue_dernier_inventaire_entrepot vdi ON (a.ID_article = vdi.article_id AND e.ID_entrepot = vdi.entrepot_id)
LEFT JOIN view_stock_produit vs ON (a.ID_article = vs.ID_article AND e.ID_entrepot = vs.ID_entrepot)
ORDER BY e.libelle_entrepot, a.libelle_article;