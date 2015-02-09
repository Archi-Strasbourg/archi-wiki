<?php
class AdressesRue extends Strategy{

	public function execute(){
		$c = new Convertor();
		$c->connect($this->config->getServer(),$this->config->getUser(),$this->config->getPassword(),$this->config->getDBName());
		
		//Requesting all the streets
		$requestStreets = "
				SELECT r.prefixe as prefixe,ha.idRue as idRue ,r.nom as nom
				FROM historiqueAdresse ha
				LEFT JOIN rue r on r.idRue = ha.idRue
				WHERE r.nom != ''
				GROUP BY ha.idRue
				ORDER BY ha.idRue
				";

		$res = $c->execute($requestStreets);
		$adressesByRue = array();
		$i=0;
		while ($fetch = mysql_fetch_array($res)){
			$rueArray = array();
			$rueArray['prefixe'] = $fetch['prefixe']; 
			$rueArray['nom'] = $fetch['nom'];
			$rue = array('prefixe' => $fetch['prefixe'] , 'nom' => $fetch['nom'] , 'idRue' => $fetch['idRue']);
			$prefixe = $fetch['prefixe'];
			$nom = $fetch['nom'];
				

				

			$reqTitre = "
					SELECT he1.titre as titre
					FROM historiqueAdresse ha
					LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
					LEFT JOIN evenements he1 ON he1.idEvenement = ae.idEvenement
					WHERE he1.titre!=''
					AND ha.idRue =". $rue['idRue']."
							AND he1.idTypeEvenement <>'6'
							GROUP BY he1.idEvenement
							ORDER BY he1.dateDebut
							LIMIT 1";
			$resTitre = $c->processRequest($reqTitre);
			if(isset($resTitre['titre'])){
					
				$fetchTitre = $resTitre;
				$titre = stripslashes($fetchTitre['titre']);
				if(trim($fetchTitre['titre'])==''){
					$noTitreDetected=true;
					$titre='';
				}
			}
			else{
				$titre="";
			}
				
				
				
			$reqidAdresse=
			"
					SELECT idAdresse, numero
					FROM historiqueAdresse
					WHERE idRue = ".$rue['idRue']."
							";
			$resIdArray = $c->execute($reqidAdresse);
			$adresseArray=array();
			$indice='';
			while($fetchAdresse = mysql_fetch_assoc($resIdArray)){
				$idAdresse = $fetchAdresse['idAdresse'];
				$adresseArray['numero'] = $fetchAdresse['numero'];
				
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
			$rueArray['adresses'] = $adresseArray;
			$indice = 'rue'.$i++;
			$adressesByRue[$indice]	=$rueArray;
		}
		$c->complexArrayToXML($adressesByRue,"xml/adressesRue.xml",'AdresseRue','adresse');
		$c->complexArrayToCSV($adressesByRue,"csv/adressesRue.csv",'AdresseRue','adresse');
	}
}