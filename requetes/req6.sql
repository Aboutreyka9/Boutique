
Code SQL : Calcul du Niveau de Stock (au 30 Avril)
Cette requête calcule le stock final en partant du dernier inventaire connu (celui du 31 mars) et en ajoutant/soustrayant tous les mouvements d'avril.

SELECT 
    p.libelle_produit,
    (
        -- A. Récupérer la base du dernier inventaire (31 Mars)
        COALESCE((
            SELECT m1.quantite 
            FROM Mouvements_stock m1 
            WHERE m1.produit_id = p.id_produit 
            AND m1.type_mouvement = 'INVENTAIRE' 
            AND m1.date_mouvement <= '2026-03-31 23:59:59'
            ORDER BY m1.date_mouvement DESC LIMIT 1
        ), 0) 
        + 
        -- B. Ajouter/Soustrayer les flux d'Avril
        COALESCE((
            SELECT SUM(
                CASE 
                    WHEN m2.type_mouvement IN ('ENTREE', 'RETOUR_CLIENT') THEN m2.quantite 
                    WHEN m2.type_mouvement IN ('VENTE', 'CASSE', 'AJUSTEMENT_NEGATIF') THEN -m2.quantite 
                    ELSE 0 
                END
            )
            FROM Mouvements_stock m2
            WHERE m2.produit_id = p.id_produit 
            AND m2.date_mouvement BETWEEN '2026-04-01 00:00:00' AND '2026-04-30 23:59:59'
        ), 0)
    ) AS stock_au_30_avril
FROM Produits p
WHERE p.id_produit IN (1, 2); -- 1 pour PC, 2 pour iPhone