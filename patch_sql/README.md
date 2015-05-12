SQL Patch README

HOW TO PATCH : 

Execute those commands in the order of the number of the files name :

mysql -u user -ppassword database ARCHI_V2 < 1.0-update-histo-adresse.sql
mysql -u user -ppassword database ARCHI_V2 < 1.1-histoEvenementParent.sql
...
mysql -u user -ppassword database ARCHI_V2 < 1.9-evenementAdressePatching.sql

(You might have to change database name in those scripts (archi_v2 in ARCHI_V2))


**1.0-update-histo-adresse : 

Add missing id in 'rue', 'sous quartier' , 'quartier', 'ville','pays' tables and also in historiqueAdresse 
so adresse related field from thos tables are easily findable  


**1.1-historiqueEvenementParent :

Gestion des evenements sur 2 niveaux : 

Le champ "parent" a été ajouté a l'évenement pour différencier le niveau d'un événement
Si ce champ est égale à 0, l'événement est parent (niveau 1), sinon, s'il est enfant, 
le champ parent est égal à l'id de l'événement parent

Si l'événement n'est lié à aucun autre événement 
(orphelin ou autre, sans grand rapport avec d'autres) il est égale à -1


Added parent field to create two level events
Father has field "parent" set to 0 and children set to idEvenement of his parent
Orphan events (unlinked to any other events) have "parent" field set to -1


**1.3-historiqueEvenementSplit.sql

Séparation de l'historique evenement de l'evenement

Split of historiqueEvenement to regular event and historic of the event 

**1.4-Commentaires-adresse.sql :

Add comment table related to addresses


**1.5-recherche_fulltext.sql :

Create the table for the fulltext research with index creation and the engine switch (required for fulltext research)


**1.6-contraints.sql :

Add missing constraints
Might fail in some case so use phpmyadmin to modified it


**1.7-trigger.sql

Add trigger to paralelly add/delete/update data to research table and other tables

 
**1.8-interet.sql
 
 Create interests tables
 
 
**1.9.3-contraintesIntegrites.sql :

Add missing constraints
Might fail in some case so use phpmyadmin to modified it