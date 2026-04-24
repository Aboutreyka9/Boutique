
Calcul du Bénéfice de Mars (Le Rapport Final)
Pour ton dashboard, voici la requête qui calcule le bénéfice net de mars en tenant compte des ventes et des pertes (casse + écarts d'inventaire).

-- La Requête SQL de Profitabilité :

SELECT 
    p.libelle_produit,
    -- Chiffre d'Affaires
    SUM(CASE WHEN m.type_mouvement = 'VENTE' THEN m.quantite * m.prix_vente ELSE 0 END) AS CA,
    -- Bénéfice Brut (Marge sur ce qui est vendu)
    SUM(CASE WHEN m.type_mouvement = 'VENTE' THEN m.quantite * (m.prix_vente - m.prix_achat) ELSE 0 END) AS Marge_Brute,
    -- Valeur des pertes (Casse + Ajustements négatifs)
    SUM(CASE WHEN m.type_mouvement IN ('CASSE', 'AJUSTEMENT_NEGATIF') THEN m.quantite * m.prix_achat ELSE 0 END) AS Pertes,
    -- Bénéfice Net
    (SUM(CASE WHEN m.type_mouvement = 'VENTE' THEN m.quantite * (m.prix_vente - m.prix_achat) ELSE 0 END) 
     - SUM(CASE WHEN m.type_mouvement IN ('CASSE', 'AJUSTEMENT_NEGATIF') THEN m.quantite * m.prix_achat ELSE 0 END)) AS Benefice_Net
FROM Produits p
JOIN Mouvements_stock m ON p.id_produit = m.produit_id
WHERE m.date_mouvement BETWEEN '2026-03-01' AND '2026-03-31 23:59:59'
GROUP BY p.id_produit;