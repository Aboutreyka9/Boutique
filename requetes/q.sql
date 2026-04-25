CREATE OR REPLACE VIEW vue_bilan_articles AS
SELECT 
    ea.entrepot_id,
    e.libelle_entrepot,
    a.ID_article,
    a.libelle_article,
    
    -- 1. QUANTITÉ APPROVISIONNEMENT (Dernier Inventaire + Entrées après celui-ci)
    (COALESCE((SELECT m1.quantite FROM mouvement_stock m1 
      WHERE m1.article_id = a.ID_article AND m1.entrepot_id = ea.entrepot_id AND m1.type_mouvement = 'INVENTAIRE' 
      ORDER BY m1.ID_mouvement_stock DESC LIMIT 1), 0) 
     + 
     COALESCE((SELECT SUM(m2.quantite) FROM mouvement_stock m2 
      WHERE m2.article_id = a.ID_article AND m2.entrepot_id = ea.entrepot_id 
      AND m2.type_mouvement IN ('ENTREE', 'RETOUR_CLIENT', 'TRANSFERT_IN', 'AJUSTEMENT_POSITIF')
      AND m2.ID_mouvement_stock > COALESCE((SELECT MAX(m3.ID_mouvement_stock) FROM mouvement_stock m3 
         WHERE m3.article_id = a.ID_article AND m3.entrepot_id = ea.entrepot_id AND m3.type_mouvement = 'INVENTAIRE'), 0)
     ), 0)
    ) AS qte_approvisionnement,

    -- 2. COÛT D'ACHAT (Basé sur le prix d'achat dans entrepot_article)
    (ea.prix_achat) AS prix_achat_unitaire,

    -- 3. QUANTITÉ VENDUE
    COALESCE((SELECT SUM(m4.quantite) FROM mouvement_stock m4 
     WHERE m4.article_id = a.ID_article AND m4.entrepot_id = ea.entrepot_id 
     AND m4.type_mouvement = 'SORTIE'
     AND m4.ID_mouvement_stock > COALESCE((SELECT MAX(m5.ID_mouvement_stock) FROM mouvement_stock m5 
         WHERE m5.article_id = a.ID_article AND m5.entrepot_id = ea.entrepot_id AND m5.type_mouvement = 'INVENTAIRE'), 0)
    ), 0) AS qte_vendue,

    -- 4. MONTANT VENDU (Chiffre d'affaires)
    COALESCE((SELECT SUM(m4.quantite * m4.prix_vente) FROM mouvement_stock m4 
     WHERE m4.article_id = a.ID_article AND m4.entrepot_id = ea.entrepot_id 
     AND m4.type_mouvement = 'SORTIE'
     AND m4.ID_mouvement_stock > COALESCE((SELECT MAX(m5.ID_mouvement_stock) FROM mouvement_stock m5 
         WHERE m5.article_id = a.ID_article AND m5.entrepot_id = ea.entrepot_id AND m5.type_mouvement = 'INVENTAIRE'), 0)
    ), 0) AS montant_vendu,

    -- 5. QUANTITÉ RESTANTE (Stock actuel)
    -- Récupérée directement depuis ta vue existante pour plus de cohérence
    COALESCE((SELECT vs.quantite_disponible FROM view_stock_produit vs 
     WHERE vs.ID_article = a.ID_article AND vs.ID_entrepot = ea.entrepot_id), 0) AS qte_restante

FROM entrepot_article ea
JOIN article a ON ea.article_id = a.ID_article
JOIN entrepot e ON ea.entrepot_id = e.ID_entrepot;



SELECT 
    libelle_entrepot,
    libelle_article,
    qte_approvisionnement,
    prix_achat_unitaire,
    qte_vendue,
    montant_vendu,
    -- BÉNÉFICE : (Quantité vendue * (Prix Vente Moyen - Prix Achat))
    -- On peut aussi le faire par : Montant Vendu - (Qte Vendue * Prix Achat)
    (montant_vendu - (qte_vendue * prix_achat_unitaire)) AS benefice,
    qte_restante,
    -- MONTANT QUANTITÉ RESTANT (Valorisation au prix d'achat)
    (qte_restante * prix_achat_unitaire) AS valeur_stock_restant
FROM vue_bilan_articles
ORDER BY libelle_entrepot, libelle_article;