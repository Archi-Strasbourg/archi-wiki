<?php
class UrlPhotosQuartier implements Strategy{
	public function execute(){
		$utils = new Utils();
		$c = new Convertor();
		$c->connect('localhost', 'archiwiki', 'archi-dev', 'archi_v2');
		
		//Requesting all the borough
		$requestQuartier = "
				SELECT idQuartier ,nom
				FROM quartier
				WHERE nom != ''
				GROUP BY idQuartier
				ORDER BY idQuartier
				";

		$res = $c->execute($requestQuartier);
		$idQuartierArray = array();
		$listeQuartier = array();
		$ruesByQuartier = array();
		$i=0;
		while ($fetch = mysql_fetch_assoc($res)){
			$listeQuartier[]=$fetch;
			$idQuartier = $fetch['idQuartier'];
			$nomQuartier = $fetch['nom'];
						
			$quartier =array();
			$quartier['nom'] = $nomQuartier;
			$request = "
					SELECT hi.idHistoriqueImage, hi.dateUpload
					FROM _evenementImage ei
					LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = ei.idEvenement
					LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee.idEvenement
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
					LEFT JOIN historiqueImage hi on hi.idImage = ei.idImage
					WHERE ha.idQuartier =  ".$idQuartier."
							";
			$resProcess = $c->processRequest($request,'url');
			$j=0;
			foreach ($resProcess as $infoImage){
				$indice = 'url'.$j++;
				$urlImage[$indice] = $utils->createArchiWikiPhotoUrl($infoImage['idHistoriqueImage'], $infoImage['dateUpload'],'http://archi-strasbourg.org','grand');
			}
			$quartier['urls'] = $urlImage;
			$label  = 'quartier'.$i++;
			$ruesByQuartier[$label]=$quartier;
		}
		$c->complexArrayToXML($ruesByQuartier,"xml/urlPhotosQuartier.xml",'urlPhotosQuartier','urlPhoto');
		$c->complexArrayToCSV($ruesByQuartier,"csv/urlPhotosQuartier.csv",'urlPhotosQuartier','urlPhoto');
	}
}