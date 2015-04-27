-- Author : Antoine Rota Graziosi / InPeople
--
--
--
-- Resetting process is done in cascade, using fields linked from other tables
-- This modification goes with PHP modification done on oct. 16th 2014 which is setting mutliple ids
-- (idSousQuartier, idQuartier, idVille, idPays) to the correct value, depending on idRue value
-- This allow more flexible data access and might be avoiding useless LEFT join in certain case


-- Resetting idSousQuartier using "idRue" and its relation with "idsousQuartier" in "rue" table
UPDATE historiqueAdresse
SET idSousQuartier = (SELECT rue.idSousQuartier
            FROM rue
            WHERE rue.idRue = historiqueAdresse.idRue)
WHERE EXISTS (SELECT rue.idRue
              FROM rue
              WHERE rue.idRue = historiqueAdresse.idRue
              AND rue.idRue!=0);
;


-- Resetting idQuartier
UPDATE historiqueAdresse
SET idQuartier = (SELECT sousQuartier.idQuartier
            FROM sousQuartier
            WHERE sousQuartier.idSousQuartier = historiqueAdresse.idSousQuartier)
WHERE EXISTS (SELECT sousQuartier.idSousQuartier
              FROM sousQuartier
              WHERE sousQuartier.idSousQuartier = historiqueAdresse.idSousQuartier
              AND sousQuartier.idSousQuartier!=0);
;


-- Resetting idVille
UPDATE historiqueAdresse
SET idVille = (SELECT quartier.idVille
            FROM quartier
            WHERE quartier.idQuartier = historiqueAdresse.idQuartier)
WHERE EXISTS (SELECT quartier.idVille
              FROM quartier
              WHERE quartier.idQuartier = historiqueAdresse.idQuartier
              AND quartier.idVille != 0);
;


-- Resetting idPays
UPDATE historiqueAdresse
SET idPays = (SELECT ville.idPays
            FROM ville
            WHERE ville.idVille = historiqueAdresse.idVille)
WHERE EXISTS (SELECT ville.idPays
              FROM ville
              WHERE ville.idVille = historiqueAdresse.idVille
              AND ville.idPays != 0);
;
