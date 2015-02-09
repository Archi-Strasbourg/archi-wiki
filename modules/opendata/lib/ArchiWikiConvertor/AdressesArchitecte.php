<?php
class AdressesArchitecte extends Strategy{
	public function execute(){
		$c = new Convertor();
		$c->connect($this->config->getServer(),$this->config->getUser(),$this->config->getPassword(),$this->config->getDBName());
		
		//Requesting all the architects
		$requeteArchitecte= "
				SELECT p.idPersonne, p.nom, p.prenom,p.description,p.dateNaissance,p.dateDeces,p.idMetier
				FROM personne p
				LEFT JOIN metier m ON m.idMetier = p.idMetier
				WHERE m.nom = 'architecte'
				GROUP BY p.idPersonne
				ORDER BY p.idPersonne
				";
		
		
		$res = $c->execute($requeteArchitecte);
		$adressesByArchitecte = array();
		$i=0;
		while ($fetch = mysql_fetch_array($res)){
			$architecteArray = array(
					'nom' => $fetch['nom'],
					'prenom'=>$fetch['prenom'],
					'description'=>$fetch['description'],
					'dateNaissance'=>$fetch['dateNaissance'],
					'dateDeces'=>$fetch['dateDeces']
			);
				
			$reqidAdresse=
			"
					SELECT ha.idAdresse,
					ha.numero, 
					r.prefixe,
					r.nom as nomRue, 
					sq.nom as nomSousQuartier,
					q.nom as nomQuartier,
					v.nom as nomVille,
					pa.nom as nomPays
					FROM evenements e1
					LEFT JOIN _evenementPersonne ep ON ep.idEvenement = e1.idEvenement
					LEFT JOIN personne p ON p.idPersonne = ep.idPersonne
					LEFT JOIN metier m ON m.idMetier = p.idMetier
					LEFT JOIN _evenementEvenement ee ON ee.idEvenementAssocie = e1.idEvenement
					LEFT JOIN evenements e2 on e2.idEvenement = ee.idEvenement
					LEFT JOIN _adresseEvenement ae on ae.idEvenement = e2.idEvenement
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
					LEFT JOIN rue r on r.idRue = ha.idRue
					LEFT JOIN sousQuartier sq on sq.idSousQuartier = ha.idSousQuartier
					LEFT JOIN quartier q on q.idQuartier = ha.idQuartier
					LEFT JOIN ville v on v.idVille = ha.idVille
					LEFT JOIN pays pa on pa.idPays = ha.idPays
					WHERE m.nom = 'architecte'
					AND ha.idAdresse is not null
					AND p.idPersonne =".$fetch['idPersonne']."
							";
			$resIdArray = $c->execute($reqidAdresse);
			$adresseArray=array();
			$indice='';
			while($fetchAdresse = mysql_fetch_assoc($resIdArray)){
				$idAdresse = $fetchAdresse['idAdresse'];
				$adresseArray['numero'] = $fetchAdresse['numero'];
				$adresseArray['prefixe'] = $fetchAdresse['prefixe'];
				$adresseArray['nomRue'] = $fetchAdresse['nomRue'];
				$adresseArray['nomSousQuartier'] = $fetchAdresse['nomSousQuartier'];
				$adresseArray['nomQuartier'] = $fetchAdresse['nomQuartier'];
				$adresseArray['nomVille'] = $fetchAdresse['nomVille'];
				$adresseArray['nomPays'] = $fetchAdresse['nomPays'];
				
				$requeteEvenements = '
						SELECT
						hE.idEvenement,
						hE.titre,
						hE.idSource,
						hE.idTypeStructure,
						hE.idTypeEvenement,
						hE.description,
						hE.dateDebut,
						hE.dateFin,
						tE.nom AS nomTypeEvenement,
						tS.nom AS nomTypeStructure,
						s.nom AS nomSource,
						tE.groupe,
						hE.ISMH ,
						hE.MH,
						date_format(hE.dateCreationEvenement,"'._("%e/%m/%Y - %kh%i").'") as dateCreationEvenement,
						hE.isDateDebutEnviron as isDateDebutEnviron,
						hE.numeroArchive as numeroArchive,
						ae.idAdresse,
						ha.idVille
						FROM evenements he2
						LEFT JOIN _adresseEvenement ae on ae.idEvenement = he2.idEvenement
						LEFT JOIN _evenementEvenement ee on ee.idEvenement = ae.idEvenement
						LEFT JOIN evenements hE on hE.idEvenement = ee.idEvenementAssocie
						LEFT JOIN source s      ON s.idSource = hE.idSource
						LEFT JOIN typeStructure tS  ON tS.idTypeStructure = hE.idTypeStructure
						LEFT JOIN typeEvenement tE  ON tE.idTypeEvenement = hE.idTypeEvenement
						LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
						WHERE  ha.idAdresse='.$idAdresse.'
						ORDER BY hE.idEvenement DESC
								';
				$resEvenements = $c->execute($requeteEvenements);
				$evenementArray = array();
				$k=0;
				while($fetchEvenement = mysql_fetch_assoc($resEvenements)){
					$labelEvenement = 'evenement'.$k++;
					$evenementArray[$labelEvenement] = array(
							'titre' => $fetchEvenement['titre'],
							'source'=> $fetchEvenement['nomSource'],
							'dateDebut'=>$fetchEvenement['dateDebut'],
							'dateFin' => $fetchEvenement['dateFin'],
							'nomTypeEvenement'=>$fetchEvenement['nomTypeEvenement'],
							'nomTypeStructure'=>$fetchEvenement['nomTypeStructure'],
							'ISMH'=> $fetchEvenement['ISMH'],
							'MH'=>$fetchEvenement['MH'],
							'dateCreationEvenement' => $fetchEvenement['dateCreationEvenement']
							
												
					);
				}
				$adresseArray['evenements'] =$evenementArray ;
				
			}
			$architecteArray['adresses'] = $adresseArray;
			$indice = 'architecte'.$i++;
			$adressesByArchitecte[$indice]	=$architecteArray;
		}
		$c->complexArrayToXML($adressesByArchitecte,"xml/adressesArchitecte.xml",'adresseArchitecte','architecte');
		$c->complexArrayToCSV($adressesByArchitecte,"csv/adressesArchitecte.csv",'adresseArchitecte','architecte');
	}

}
?>