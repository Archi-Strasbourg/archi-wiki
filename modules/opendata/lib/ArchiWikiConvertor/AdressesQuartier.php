<?php
class AdressesQuartier implements Strategy{

	public function execute(){
		$c = new Convertor();
		$c->connect('localhost', 'archiwiki', 'archi-dev', 'archi_v2');

		//Requesting all the neighborohood
		$requestNeigh = "
				SELECT q.codepostal as codepostal,
				ha.idQuartier as idQuartier ,
				q.nom as nomQuartier,
				v.nom as nomVille,
				p.nom as nomPays
				
				FROM historiqueAdresse ha
				LEFT JOIN rue r on r.idRue = ha.idRue
				LEFT JOIN quartier q on q.idQuartier = ha.idQuartier
				LEFT JOIN ville v on v.idVille = ha.idVille
				LEFT JOIN pays p on p.idPays = ha.idPays
				WHERE q.nom != ''
				GROUP BY ha.idQuartier
				ORDER BY ha.idQuartier
				";

		$res = $c->execute($requestNeigh);
		$adressesByQuartier = array();
		$i=0;
		while ($fetch = mysql_fetch_assoc($res)){
			$quartierArray = array();
			$quartierArray['nom'] = $fetch['nomQuartier'];
			$quartierArray['codepostal'] = $fetch['codepostal'];
			$quartierArray['ville'] = $fetch['nomVille'];
			$quartierArray['pays'] = $fetch['nomPays'];
			
			$reqidAdresse=
			"
					SELECT idAdresse, numero
					FROM historiqueAdresse
					WHERE idRue = ".$fetch['idQuartier']."
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
			$quartierArray['adresses'] = $adresseArray;
			$indice = 'quartier'.$i++;
			$adressesByQuartier[$indice]	=$quartierArray;
		}
		$util = new Utils();
		$c->complexArrayToXML($adressesByQuartier,"xml/adressesQuartier.xml",'AdresseQuartier','adresse');
		$c->complexArrayToCSV($adressesByQuartier,"csv/adressesQuartier.csv",'AdresseQuartier','adresse');
	}
}
?>