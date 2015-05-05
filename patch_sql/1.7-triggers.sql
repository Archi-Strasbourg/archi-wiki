-- 1.7-triggers.sql 
-- Create triggers to auto-add value to recherche table when new data are inserted in other tables
-- Author : Antoine Rota Graziosi


-- Insert historiqueEvenement trigger
delimiter $$
create trigger recherche_historiqueEvenement_insert_trig after insert on _evenementEvenement
for each row
begin
    INSERT INTO recherche
	 SELECT  ee.idEvenement as idEvenementGA,
                r.nom as nomRue,
                sq.nom as nomSousQuartier,
                q.nom as nomQuartier,
                v.nom as nomVille,
                p.nom as nomPays,
                ha1.idRue, 
                r.prefixe as prefixeRue,
                r.idSousQuartier AS idSousQuartier,
                ha1.idQuartier AS idQuartier,
                ha1.idVille  AS idVille,
                ha1.idPays AS idPays,
				he1.description as description,
				he1.titre as titre,
				pers.nom as nomPersonne,
				pers.prenom as prenomPersonne,
                CONVERT( ha1.numero USING utf8 ) as numeroAdresse,
                ha1.idHistoriqueAdresse,
                ha1.idIndicatif as idIndicatif,
                ind.nom as nomIndicatif,
				ha1.latitude AS latitude,
                ha1.longitude AS longitude,
				he1.idTypeStructure as idTypeStructure,
				he1.idTypeEvenement as idTypeEvenement,
				he1.idSource as idSource,
				he1.dateDebut as dateDebut,
				he1.dateFin as dateFin,
				he1.ISMH as ISMH,
				he1.MH as MH,
				eca.idCourantArchitectural as idCourantArchitectural,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', ind.nom,  ' ',r.prefixe,  ' ',r.nom,  ' ',sq.nom,   ' ',q.nom,   ' ',v.nom,  ' ', p.nom) as concat1,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat2,
				CONCAT_WS('', he1.titre, CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat3,
				CONCAT_WS('', pers.nom,' ', pers.prenom) as concat4,
				CONCAT_WS('', pers.prenom,' ' , pers.nom) as concat5
				
			
				FROM historiqueAdresse ha1
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha1.idAdresse
				LEFT JOIN _evenementEvenement ee on ee.idEvenement = ae.idEvenement
				LEFT JOIN evenements he1 on he1.idEvenement = ee.idEvenementAssocie
				LEFT JOIN rue r         ON r.idRue = ha1.idRue
		        LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = ha1.idSousQuartier 
		        LEFT JOIN quartier q        ON q.idQuartier = ha1.idQuartier 
		        LEFT JOIN ville v        ON v.idVille = ha1.idVille 
		        LEFT JOIN pays p        ON p.idPays = ha1.idPays 
		        LEFT JOIN _evenementPersonne ep on ep.idEvenement = ee.idEvenementAssocie
		        LEFT JOIN  personne pers on pers.idPersonne = ep.idPersonne
		        LEFT JOIN indicatif ind on ind.idIndicatif = ha1.idIndicatif
        		LEFT JOIN _evenementCourantArchitectural eca on eca.idEvenement = ee.idEvenementAssocie

        		WHERE ee.idEvenementAssocie = NEW.idEvenementAssocie;
END$$
delimiter ;


delimiter $$
create trigger recherche_evenementEvenement_update_trig after UPDATE on _evenementEvenement
for each row
begin
    INSERT INTO recherche
	 SELECT  ee.idEvenement as idEvenementGA,
                r.nom as nomRue,
                sq.nom as nomSousQuartier,
                q.nom as nomQuartier,
                v.nom as nomVille,
                p.nom as nomPays,
                ha1.idRue, 
                r.prefixe as prefixeRue,
                r.idSousQuartier AS idSousQuartier,
                ha1.idQuartier AS idQuartier,
                ha1.idVille  AS idVille,
                ha1.idPays AS idPays,
				he1.description as description,
				he1.titre as titre,
				pers.nom as nomPersonne,
				pers.prenom as prenomPersonne,
                CONVERT( ha1.numero USING utf8 ) as numeroAdresse,
                ha1.idHistoriqueAdresse,
                ha1.idIndicatif as idIndicatif,
                ind.nom as nomIndicatif,
				ha1.latitude AS latitude,
                ha1.longitude AS longitude,
				he1.idTypeStructure as idTypeStructure,
				he1.idTypeEvenement as idTypeEvenement,
				he1.idSource as idSource,
				he1.dateDebut as dateDebut,
				he1.dateFin as dateFin,
				he1.ISMH as ISMH,
				he1.MH as MH,
				eca.idCourantArchitectural as idCourantArchitectural,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', ind.nom,  ' ',r.prefixe,  ' ',r.nom,  ' ',sq.nom,   ' ',q.nom,   ' ',v.nom,  ' ', p.nom) as concat1,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat2,
				CONCAT_WS('', he1.titre, CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat3,
				CONCAT_WS('', pers.nom,' ', pers.prenom) as concat4,
				CONCAT_WS('', pers.prenom,' ' , pers.nom) as concat5
				
			
				FROM historiqueAdresse ha1
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha1.idAdresse
				LEFT JOIN _evenementEvenement ee on ee.idEvenement = ae.idEvenement
				LEFT JOIN evenements he1 on he1.idEvenement = ee.idEvenementAssocie
				LEFT JOIN rue r         ON r.idRue = ha1.idRue
		        LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = ha1.idSousQuartier 
		        LEFT JOIN quartier q        ON q.idQuartier = ha1.idQuartier 
		        LEFT JOIN ville v        ON v.idVille = ha1.idVille 
		        LEFT JOIN pays p        ON p.idPays = ha1.idPays 
		        LEFT JOIN _evenementPersonne ep on ep.idEvenement = ee.idEvenementAssocie
		        LEFT JOIN  personne pers on pers.idPersonne = ep.idPersonne
		        LEFT JOIN indicatif ind on ind.idIndicatif = ha1.idIndicatif
        		LEFT JOIN _evenementCourantArchitectural eca on eca.idEvenement = ee.idEvenementAssocie

        		WHERE  ee.idEvenementAssocie = NEW.idEvenementAssocie;
END$$
delimiter ;






delimiter $$
create trigger recherche_evenementEvenement_delete_trig after DELETE on _evenementEvenement
for each row
begin

	DELETE from recherche where idEvenementGA = old.idEvenement;
    INSERT INTO recherche
	 SELECT  ee.idEvenement as idEvenementGA,
                r.nom as nomRue,
                sq.nom as nomSousQuartier,
                q.nom as nomQuartier,
                v.nom as nomVille,
                p.nom as nomPays,
                ha1.idRue, 
                r.prefixe as prefixeRue,
                r.idSousQuartier AS idSousQuartier,
                ha1.idQuartier AS idQuartier,
                ha1.idVille  AS idVille,
                ha1.idPays AS idPays,
				he1.description as description,
				he1.titre as titre,
				pers.nom as nomPersonne,
				pers.prenom as prenomPersonne,
                CONVERT( ha1.numero USING utf8 ) as numeroAdresse,
                ha1.idHistoriqueAdresse,
                ha1.idIndicatif as idIndicatif,
                ind.nom as nomIndicatif,
				ha1.latitude AS latitude,
                ha1.longitude AS longitude,
				he1.idTypeStructure as idTypeStructure,
				he1.idTypeEvenement as idTypeEvenement,
				he1.idSource as idSource,
				he1.dateDebut as dateDebut,
				he1.dateFin as dateFin,
				he1.ISMH as ISMH,
				he1.MH as MH,
				eca.idCourantArchitectural as idCourantArchitectural,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', ind.nom,  ' ',r.prefixe,  ' ',r.nom,  ' ',sq.nom,   ' ',q.nom,   ' ',v.nom,  ' ', p.nom) as concat1,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat2,
				CONCAT_WS('', he1.titre, CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat3,
				CONCAT_WS('', pers.nom,' ', pers.prenom) as concat4,
				CONCAT_WS('', pers.prenom,' ' , pers.nom) as concat5
				
			
				FROM historiqueAdresse ha1
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha1.idAdresse
				LEFT JOIN _evenementEvenement ee on ee.idEvenement = ae.idEvenement
				LEFT JOIN evenements he1 on he1.idEvenement = ee.idEvenementAssocie
				LEFT JOIN rue r         ON r.idRue = ha1.idRue
		        LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = ha1.idSousQuartier 
		        LEFT JOIN quartier q        ON q.idQuartier = ha1.idQuartier 
		        LEFT JOIN ville v        ON v.idVille = ha1.idVille 
		        LEFT JOIN pays p        ON p.idPays = ha1.idPays 
		        LEFT JOIN _evenementPersonne ep on ep.idEvenement = ee.idEvenementAssocie
		        LEFT JOIN  personne pers on pers.idPersonne = ep.idPersonne
		        LEFT JOIN indicatif ind on ind.idIndicatif = ha1.idIndicatif
        		LEFT JOIN _evenementCourantArchitectural eca on eca.idEvenement = ee.idEvenementAssocie

        		WHERE ee.idEvenement = old.idEvenement;
END$$
delimiter ;





-- Update historiqueEvenement trigger
delimiter $$
create trigger recherche_historiqueEvenement_update_trig after UPDATE on evenements
for each row
begin
	
	
	
	DELETE from recherche where idEvenementGA in (select idEvenement FROM _evenementEvenement where idEvenementAssocie =old.idEvenement);
    INSERT INTO recherche
	 SELECT  ee.idEvenement as idEvenementGA,
                r.nom as nomRue,
                sq.nom as nomSousQuartier,
                q.nom as nomQuartier,
                v.nom as nomVille,
                p.nom as nomPays,
                ha1.idRue, 
                r.prefixe as prefixeRue,
                r.idSousQuartier AS idSousQuartier,
                ha1.idQuartier AS idQuartier,
                ha1.idVille  AS idVille,
                ha1.idPays AS idPays,
				he1.description as description,
				he1.titre as titre,
				pers.nom as nomPersonne,
				pers.prenom as prenomPersonne,
                CONVERT( ha1.numero USING utf8 ) as numeroAdresse,
                ha1.idHistoriqueAdresse,
                ha1.idIndicatif as idIndicatif,
                ind.nom as nomIndicatif,
				ha1.latitude AS latitude,
                ha1.longitude AS longitude,
				he1.idTypeStructure as idTypeStructure,
				he1.idTypeEvenement as idTypeEvenement,
				he1.idSource as idSource,
				he1.dateDebut as dateDebut,
				he1.dateFin as dateFin,
				he1.ISMH as ISMH,
				he1.MH as MH,
				eca.idCourantArchitectural as idCourantArchitectural,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', ind.nom,  ' ',r.prefixe,  ' ',r.nom,  ' ',sq.nom,   ' ',q.nom,   ' ',v.nom,  ' ', p.nom) as concat1,
				CONCAT_WS('', CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat2,
				CONCAT_WS('', he1.titre, CONVERT(ha1.numero USING utf8), ' ', r.prefixe, ' ', r.nom)as concat3,
				CONCAT_WS('', pers.nom,' ', pers.prenom) as concat4,
				CONCAT_WS('', pers.prenom,' ' , pers.nom) as concat5
				
			
				FROM historiqueAdresse ha1
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha1.idAdresse
				LEFT JOIN _evenementEvenement ee on ee.idEvenement = ae.idEvenement
				LEFT JOIN evenements he1 on he1.idEvenement = ee.idEvenementAssocie
				LEFT JOIN rue r         ON r.idRue = ha1.idRue
		        LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = ha1.idSousQuartier 
		        LEFT JOIN quartier q        ON q.idQuartier = ha1.idQuartier 
		        LEFT JOIN ville v        ON v.idVille = ha1.idVille 
		        LEFT JOIN pays p        ON p.idPays = ha1.idPays 
		        LEFT JOIN _evenementPersonne ep on ep.idEvenement = ee.idEvenementAssocie
		        LEFT JOIN  personne pers on pers.idPersonne = ep.idPersonne
		        LEFT JOIN indicatif ind on ind.idIndicatif = ha1.idIndicatif
        		LEFT JOIN _evenementCourantArchitectural eca on eca.idEvenement = ee.idEvenementAssocie

        		WHERE he1.idEvenement = NEW.idEvenement;

END$$
delimiter ;


-- Delete historiqueEvenement trigger
delimiter $$
create trigger recherche_historiqueEvenement_delete_trig after DELETE on evenements
for each row
begin
	
	delete from recherche 
	WHERE idEvenementGA in  old.idEvenement; 
END$$
delimiter ;





-- Update personne trigger
delimiter $$
create trigger recherche_personne_update_trig after UPDATE on personne
for each row
begin
	
	UPDATE recherche 
	SET
	nomPersonne=new.nom,
	prenomPersonne = new.prenom
	WHERE nomPersonne = old.nom
	or  prenomPersonne = old.prenom; 

END$$

delimiter ;







-- Update personne trigger
delimiter $$
create trigger recherche_adresse_update_trig after UPDATE on historiqueAdresse
for each row
begin
	
	UPDATE recherche 
	SET
	numeroAdresse=new.numero
	WHERE numeroAdresse = old.numero
	; 
END$$
delimiter ;




-- Update pays trigger
delimiter $$
create trigger recherche_pays_update_trig after UPDATE on pays
for each row
begin
	
	UPDATE recherche 
	SET
	nomPays=new.nom
	WHERE nomPays = old.nom
	; 
END$$
delimiter ;


-- Update ville trigger
delimiter $$
create trigger recherche_ville_update_trig after UPDATE on ville
for each row
begin
	
	UPDATE recherche 
	SET
	nomVille = new.nom
	WHERE nomVille = old.nom
	; 
END$$
delimiter ;


-- Update quartier trigger
delimiter $$
create trigger recherche_quartier_update_trig after UPDATE on quartier
for each row
begin
	UPDATE recherche 
	SET
	nomQuartier=new.nom
	WHERE nomQuartier = old.nom
	; 
END$$
delimiter ;


-- Update sous quartier trigger
delimiter $$
create trigger recherche_sousquartier_update_trig after UPDATE on sousQuartier
for each row
begin
	
	UPDATE recherche 
	SET
	nomSousQuartier=new.nom
	WHERE nomSousQuartier = old.nom
	; 
END$$
delimiter ;



-- Update rue trigger
delimiter $$
create trigger recherche_rue_update_trig after UPDATE on rue
for each row
begin
	
	UPDATE recherche 
	SET
	nomRue=new.nom,
	prefixeRue = new.prefixe
	WHERE nomRue = old.nom
	; 
END$$
delimiter ;




-- Update indicatif trigger
delimiter $$
create trigger recherche_indicatif_update_trig after UPDATE on indicatif
for each row
begin
	
	UPDATE recherche 
	SET
	nomRue=new.nom
	WHERE nomRue = old.nom
	; 
END$$
delimiter ;



-- Update historiqueImage for image search
delimiter $$
create trigger recherche_image_historique_image after INSERT on historiqueImage
for each row
begin
	
	INSERT INTO rechercheImage
	SELECT * FROM (
    SELECT DISTINCT
historiqueImage.idImage, 
historiqueImage.idHistoriqueImage,
historiqueImage.licence,
historiqueImage.tags, 
historiqueImage.description as descriptionImage,
historiqueAdresse.idAdresse,
historiqueAdresse.nom as nomAdresse,
evenements.idEvenement, 
historiqueImage.dateUpload,
evenements.titre as titreEvenement,
evenements.description as descriptionEvenement,
quartier.nom as nomQuartier
    FROM historiqueImage
    LEFT JOIN _evenementImage ON historiqueImage.idImage = _evenementImage.idImage
    LEFT JOIN evenements ON evenements.idEvenement = _evenementImage.idEvenement
    LEFT JOIN  _evenementEvenement ON  _evenementEvenement.idEvenementAssocie = evenements.idEvenement
    LEFT JOIN _adresseEvenement ON _adresseEvenement.idEvenement = _evenementEvenement.idEvenement
    LEFT JOIN historiqueAdresse ON historiqueAdresse.idAdresse = _adresseEvenement.idAdresse
    LEFT JOIN quartier ON quartier.idQuartier = historiqueAdresse.idQuartier
    WHERE (NOT ISNULL(evenements.description))
    AND (NOT ISNULL(historiqueAdresse.idAdresse))
   
    AND historiqueImage.idHistoriqueImage = NEW.idHistoriqueImage
    ) results
    GROUP BY results.idImage
	
	; 
END$$
delimiter ;


