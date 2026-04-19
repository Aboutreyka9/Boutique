
. La Requête SQL Globale
Cette requête compte le nombre de lignes dentrée (nombre de produits reçus) et fait la somme du produit quantité * prix_achat.

SELECT 
    COUNT(*) AS nombre_de_receptions,
    SUM(quantite * prix_achat) AS montant_total_investi
FROM Mouvements_stock
WHERE type_mouvement = 'ENTREE'
AND date_mouvement BETWEEN '2026-03-01 00:00:00' AND '2026-03-31 23:59:59';

**************************************-------------
----------**************************************

Version détaillée par Produit
Si tu veux voir le détail de ce que tu as dépensé par article pour mieux gérer ta trésorerie :

SQL

SELECT 
    p.libelle_produit,
    SUM(m.quantite) AS total_quantite_recue,
    SUM(m.quantite * m.prix_achat) AS total_depense
FROM Mouvements_stock m
JOIN Produits p ON m.product_id = p.id_produit
WHERE m.type_mouvement = 'ENTREE'
AND m.date_mouvement BETWEEN '2026-03-01' AND '2026-03-31'
GROUP BY p.id_produit;


--**************************************
********************************-----------

Code SQL : Calcul du Montant Net de Réapprovisionnement
Pour savoir ce que tu as réellement dépensé chez tes fournisseurs en mars, tu dois soustraire les retours des entrées.

SELECT 
    SUM(CASE WHEN type_mouvement = 'ENTREE' THEN (quantite * prix_achat) ELSE 0 END) AS montant_achats,
    SUM(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (quantite * prix_achat) ELSE 0 END) AS montant_retours,
    -- Le montant réel décaissé
    (SUM(CASE WHEN type_mouvement = 'ENTREE' THEN (quantite * prix_achat) ELSE 0 END) - 
     SUM(CASE WHEN type_mouvement = 'RETOUR_FOURNISSEUR' THEN (quantite * prix_achat) ELSE 0 END)) AS investissement_net_mars
FROM Mouvements_stock
WHERE date_mouvement BETWEEN '2026-03-01' AND '2026-03-31';