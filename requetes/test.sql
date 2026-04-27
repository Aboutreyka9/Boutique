select `ea`.`entrepot_id` AS `entrepot_id`,`e`.`libelle_entrepot` AS `libelle_entrepot`,`a`.`ID_article` AS `article_id`,`a`.`libelle_article` AS `libelle_article`,

(coalesce(`c2588565c_boutique`.`vdi`.`quantite_inv`,0) +

coalesce((select sum((case when (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) then `m`.`quantite` when (`m`.`type_mouvement` in ('RETOUR_FOURNISSEUR')) then -(`m`.`quantite`) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)

-- + coalesce((select sum(`m`.`quantite`) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)
) 
AS `qte_approvisionnement`,


(coalesce((`c2588565c_boutique`.`vdi`.`quantite_inv` * `ea`.`prix_achat`),0) +

coalesce((select sum((case when (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) then (`m`.`quantite` * `ea`.`prix_achat`) when (`m`.`type_mouvement` in ('RETOUR_FOURNISSEUR')) then -(`m`.`quantite` * `ea`.`prix_achat`) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)

--  coalesce((select sum((`m`.`quantite` * `ea`.`prix_achat`)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)

) AS `cout_achat`,

coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then `m`.`quantite` when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -(`m`.`quantite`) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `qte_vendue`,

coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * `m`.`prix_vente`) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * `m`.`prix_vente`)) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `montant_vendu`,

coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`)) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`))) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `benefice`,

coalesce(`c2588565c_boutique`.`vs`.`quantite_disponible`,0) AS `qte_restante`,

(coalesce(`c2588565c_boutique`.`vs`.`quantite_disponible`,0) * `ea`.`prix_achat`) AS `montant_quantite_restant` 

from ((((`c2588565c_boutique`.`entrepot_article` `ea` join `c2588565c_boutique`.`article` `a` on((`ea`.`article_id` = `a`.`ID_article`))) join `c2588565c_boutique`.`entrepot` `e` on((`ea`.`entrepot_id` = `e`.`ID_entrepot`))) left join `c2588565c_boutique`.`vue_dernier_inventaire_entrepot` `vdi` on(((`a`.`ID_article` = `c2588565c_boutique`.`vdi`.`article_id`) and (`e`.`ID_entrepot` = `c2588565c_boutique`.`vdi`.`entrepot_id`)))) left join `c2588565c_boutique`.`vue_stock_produit` `vs` on(((`a`.`ID_article` = `c2588565c_boutique`.`vs`.`article_id`) and (`e`.`ID_entrepot` = `c2588565c_boutique`.`vs`.`entrepot_id`)))) order by `e`.`libelle_entrepot`,`a`.`libelle_article`













--------------------------------------------------------------------
--------------------------------------------------------------------

select `ea`.`entrepot_id` AS `entrepot_id`,`e`.`libelle_entrepot` AS `libelle_entrepot`,`a`.`ID_article` AS `article_id`,`a`.`libelle_article` AS `libelle_article`,(coalesce(`c2588565c_boutique`.`vdi`.`quantite_inv`,0) + coalesce((select sum((case when (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) then `m`.`quantite` when (`m`.`type_mouvement` = 'RETOUR_FOURNISSEUR') then -(`m`.`quantite`) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)) AS `qte_approvisionnement`,(coalesce((`c2588565c_boutique`.`vdi`.`quantite_inv` * `ea`.`prix_achat`),0) + coalesce((select sum((case when (`m`.`type_mouvement` in ('ENTREE','TRANSFERT_IN','AJUSTEMENT_POSITIF')) then (`m`.`quantite` * `ea`.`prix_achat`) when (`m`.`type_mouvement` = 'RETOUR_FOURNISSEUR') then -((`m`.`quantite` * `ea`.`prix_achat`)) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0)) AS `cout_achat`,coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then `m`.`quantite` when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -(`m`.`quantite`) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `qte_vendue`,coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * `m`.`prix_vente`) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * `m`.`prix_vente`)) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `montant_vendu`,coalesce((select sum((case when (`m`.`type_mouvement` = 'SORTIE') then (`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`)) when (`m`.`type_mouvement` = 'RETOUR_CLIENT') then -((`m`.`quantite` * (`m`.`prix_vente` - `ea`.`prix_achat`))) else 0 end)) from `c2588565c_boutique`.`mouvement_stock` `m` where ((`m`.`article_id` = `a`.`ID_article`) and (`m`.`entrepot_id` = `ea`.`entrepot_id`) and (`m`.`ID_mouvement_stock` > `c2588565c_boutique`.`vdi`.`last_inv_id`))),0) AS `benefice`,coalesce(`c2588565c_boutique`.`vs`.`quantite_disponible`,0) AS `qte_restante`,(coalesce(`c2588565c_boutique`.`vs`.`quantite_disponible`,0) * `ea`.`prix_achat`) AS `montant_quantite_restant` from ((((`c2588565c_boutique`.`entrepot_article` `ea` join `c2588565c_boutique`.`article` `a` on((`ea`.`article_id` = `a`.`ID_article`))) join `c2588565c_boutique`.`entrepot` `e` on((`ea`.`entrepot_id` = `e`.`ID_entrepot`))) left join `c2588565c_boutique`.`vue_dernier_inventaire_entrepot` `vdi` on(((`a`.`ID_article` = `c2588565c_boutique`.`vdi`.`article_id`) and (`e`.`ID_entrepot` = `c2588565c_boutique`.`vdi`.`entrepot_id`)))) left join `c2588565c_boutique`.`vue_stock_produit` `vs` on(((`a`.`ID_article` = `c2588565c_boutique`.`vs`.`article_id`) and (`e`.`ID_entrepot` = `c2588565c_boutique`.`vs`.`entrepot_id`)))) 
GROUP BY 
order by `e`.`libelle_entrepot`,`a`.`libelle_article`;