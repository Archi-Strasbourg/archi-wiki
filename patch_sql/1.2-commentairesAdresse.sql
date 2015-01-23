


CREATE TABLE IF NOT EXISTS `commentairesEvenement` (
  `idCommentairesEvenement` int(11) NOT NULL AUTO_INCREMENT,
  `idEvenement` int(10) unsigned NOT NULL,
  `pseudo` varchar(150) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `commentaire` longtext NOT NULL,
  `date` datetime NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL DEFAULT '0',
  `CommentaireValide` tinyint(4) NOT NULL DEFAULT '0',
  `uniqid` char(23) NOT NULL,
  PRIMARY KEY (`idCommentaireEvenement`),
  INDEX `fk_commentairesEvenement_historiqueEvenement1_idx` (`idEvenement` ASC),
  INDEX `fk_commentairesEvenement_utilisateur1_idx` (`idUtilisateur` ASC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6173 ;
ALTER TABLE `commentairesEvenement` ADD CONSTRAINT `commentairesEvenement_ibfk_1` FOREIGN KEY ( `idUtilisateur` ) REFERENCES `utilisateur` ( `idUtilisateur` ) ,
ADD CONSTRAINT `commentairesEvenement_ibfk_2` FOREIGN KEY ( `idEvenement` ) REFERENCES `evenements` ( `idEvenement` ) ;
