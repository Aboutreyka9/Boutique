-- CREATE VIEW SOMMEVENTE 
CREATE View sommevente as SELECT ve.*, SUM(so.prix_vente * qte) somme FROM sortie so INNER JOIN vente ve ON ve.code_vente = so.vente_id GROUP BY so.vente_id;




SELECT CASE MONTH('1999-07-07')
         WHEN 1 THEN 'janvier'
         WHEN 2 THEN 'février'
         WHEN 3 THEN 'mars'
         WHEN 4 THEN 'avril'
         WHEN 5 THEN 'mai'
         WHEN 6 THEN 'juin'
         WHEN 7 THEN 'juillet'
         WHEN 8 THEN 'août'
         WHEN 9 THEN 'septembre'
         WHEN 10 THEN 'octobre'
         WHEN 11 THEN 'novembre'
         ELSE 'décembre'
END;