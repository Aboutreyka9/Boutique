
2. Code SQL : Calcul du Bénéfice d'Avril
Pour obtenir le bénéfice net, nous calculons la Marge des ventes (en incluant les retours clients qui annulent la marge) et nous soustrayons la Valeur d'achat des pertes.

SELECT 
    p.libelle_produit,
    -- 1. Chiffre d'Affaires d'Avril (Ventes - Retours)
    SUM(CASE 
        WHEN m.type_mouvement = 'VENTE' THEN m.quantite * m.prix_vente 
        WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -(m.quantite * m.prix_vente)
        ELSE 0 END) AS CA_Avril,

    -- 2. Marge Brute (Marge Ventes - Marge Retours)
    SUM(CASE 
        WHEN m.type_mouvement = 'VENTE' THEN m.quantite * (m.prix_vente - m.prix_achat)
        WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -(m.quantite * (m.prix_vente - m.prix_achat))
        ELSE 0 END) AS Marge_Brute,

    -- 3. Valeur des pertes (Casse + Manquants)
    SUM(CASE 
        WHEN m.type_mouvement IN ('CASSE', 'AJUSTEMENT_NEGATIF') THEN m.quantite * m.prix_achat 
        ELSE 0 END) AS Valeur_Pertes,

    -- 4. Bénéfice Net final
    (
        SUM(CASE 
            WHEN m.type_mouvement = 'VENTE' THEN m.quantite * (m.prix_vente - m.prix_achat)
            WHEN m.type_mouvement = 'RETOUR_CLIENT' THEN -(m.quantite * (m.prix_vente - m.prix_achat))
            ELSE 0 END) 
        - 
        SUM(CASE 
            WHEN m.type_mouvement IN ('CASSE', 'AJUSTEMENT_NEGATIF') THEN m.quantite * m.prix_achat 
            ELSE 0 END)
    ) AS Benefice_Net_Avril

FROM Produits p
JOIN Mouvements_stock m ON p.id_produit = m.produit_id
WHERE m.date_mouvement BETWEEN '2026-04-01 00:00:00' AND '2026-04-30 23:59:59'
GROUP BY p.id_produit;