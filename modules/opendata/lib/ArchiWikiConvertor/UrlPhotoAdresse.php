<?php
class UrlPhotosAdresse extends Strategy{
	public function execute(){
		$utils = new Utils();
		$c = new Convertor();
		$c->connect($this->config->getServer(),$this->config->getUser(),$this->config->getPassword(),$this->config->getDBName());
				
		//Requesting all the borough
		$requestRue = "
				SELECT idRue ,nom , prefixe
				FROM rue
				WHERE nom != ''
				GROUP BY idRue
				ORDER BY idRue
				";
		
		$res = $c->execute($requestRue);
		$listeQuartier = array();
		$ruesByQuartier = array();
		$i=0;
		while ($fetch = mysql_fetch_assoc($res)){
			$rue =array();
			$rue['prefixe'] = $fetch['prefixe'];
			$rue['nom'] = $fetch['nom'];
			
			
			$requeteNumero = "
					SELECT numero
					FROM historiqueAdresse
					WHERE idRue = 
					".$fetch['idRue'];
			$resultNumero = $c->processRequest($requeteNumero,'numero');
			$rue['numero'] = $resultNumero;
			
			$request = "
					SELECT hi.idHistoriqueImage, hi.dateUpload
					FROM _evenementImage ei
					LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = ei.idEvenement
					LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee.idEvenement
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
					LEFT JOIN historiqueImage hi on hi.idImage = ei.idImage
					WHERE ha.idRue =  ".$fetch['idRue']."
							";
			$resProcess = $c->processRequest($request,'url');
			$j=0;
			$urlImage = array();
			foreach ($resProcess as $infoImage){
				$indice = 'url'.$j++;
				$urlImage[$indice] = $utils->createArchiWikiPhotoUrl($infoImage['idHistoriqueImage'], $infoImage['dateUpload'],'http://archi-strasbourg.org','grand');
			}
			$resultNumero['url'] = $urlImage;

			debug($resultNumero);
			
			$rue['numero'] = $resultNumero;
			$label  = 'rue'.$i++;
			$ruesByQuartier[$label]=$rue;
		}

		$c->complexArrayToXML($ruesByQuartier,"xml/urlPhotosRue.xml",'urlPhotosRue','urlPhoto');
		$c->complexArrayToCSV($ruesByQuartier,"csv/urlPhotosRue.csv",'urlPhotosRue','urlPhoto');
	}
}
?>