
1. Calcul du Stock Actuel (Point de départ : Dernier Inventaire)
Cette requête cherche la quantité du dernier inventaire et y ajoute tous les mouvements qui ont eu lieu après cette date précise.

SELECT 
    a.libelle_article,
    (
        SELECT (m1.quantite + COALESCE(SUM(
            CASE 
                WHEN m2.type_mouvement IN ('ENTREE', 'RETOUR_CLIENT', 'TRANSFERT_IN', 'AJUSTEMENT_POSITIF') THEN m2.quantite 
                WHEN m2.type_mouvement IN ('SORTIE', 'AJUSTEMENT_NEGATIF', 'RETOUR_FOURNISSEUR', 'TRANSFERT_OUT') THEN -m2.quantite 
                ELSE 0 
            END
        ), 0))
        FROM mouvement_stock m1
        LEFT JOIN mouvement_stock m2 ON m1.article_id = m2.article_id 
            AND m2.date_mouvement > m1.date_mouvement
        WHERE m1.article_id = a.ID_article 
            AND m1.type_mouvement = 'INVENTAIRE'
        ORDER BY m1.date_mouvement DESC
        LIMIT 1
    ) AS stock_reel
FROM article a;

*********************---------*************
**************------------*******************-
2. Calcul du Bénéfice Net de Mars (Basé sur les mouvements)
Pour le bénéfice, on calcule la marge sur les ventes et on soustrait les pertes (vols/casse) et les charges fixes de ta table depense.

SELECT 
    -- 1. Marge Brute (Ventes - Coût d'achat)
    SUM(CASE WHEN m.type_mouvement = 'SORTIE' THEN (m.prix_vente - m.prix_achat) * m.quantite ELSE 0 END)
    -
    -- 2. Valeur des pertes (Ajustements négatifs / Casse)
    SUM(CASE WHEN m.type_mouvement = 'AJUSTEMENT_NEGATIF' THEN m.prix_achat * m.quantite ELSE 0 END)
    -
    -- 3. Total des dépenses opérationnelles (Loyer, Salaire, etc.)
    (SELECT COALESCE(SUM(montant), 0) FROM depense WHERE date_created BETWEEN '2026-03-01' AND '2026-03-31')
    AS benefice_net_mars
FROM mouvement_stock m
WHERE m.date_mouvement BETWEEN '2026-03-01' AND '2026-03-31';


//---------------****************
*********************----------------
Réapprovisionnements de Mars (Entrées Nettes)
Cette requête tient compte des cas de retours fournisseurs pour te donner le montant net investi.

SELECT 
    COUNT(CASE WHEN type_mouvement = 'ENTREE' THEN 1 END) AS nb_receptions,
    SUM(CASE WHEN type_mouvement = 'ENTREE' THEN (quantite * prix_achat) ELSE 0 END) AS montant_achats,
    SUM(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (quantite * prix_achat) ELSE 0 END) AS montant_retours_fourn,
    -- Montant net décaissé
    (SUM(CASE WHEN type_mouvement = 'ENTREE' THEN (quantite * prix_achat) ELSE 0 END) - 
     SUM(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (quantite * prix_achat) ELSE 0 END)) AS investissement_net_mars
FROM mouvement_stock
WHERE date_mouvement BETWEEN '2026-03-01' AND '2026-03-31';