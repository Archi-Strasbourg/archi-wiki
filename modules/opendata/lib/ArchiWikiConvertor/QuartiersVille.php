<?php
class QuartiersVille implements Strategy{
	public function execute(){
		$c = new Convertor();
		$c->connect('localhost', 'archiwiki', 'archi-dev', 'archi_v2');

		//Requesting all the streets
		$requestVille = "
				SELECT idVille , nom
				FROM ville
				WHERE nom != \"\"
				GROUP BY idVille
				ORDER BY idVille
				";

		$res = $c->execute($requestVille);
		$infoVille = array();
		while ($fetch = mysql_fetch_assoc($res)){
			$infoVille[] = $fetch;
		}
		$quartiersByVille = array();
		$i = 0;
		foreach ($infoVille as $info){
			$ville = array();
			$ville['ville'] = $info['nom'];
			$request = "
					SELECT q.nom
					FROM quartier q
					WHERE q.idVille = ".$info['idVille']."
							ORDER BY q.idVille
							";
			$resProcess = $c->execute($request);
			$quartierArray = array();
			$j=0;
			while($fetchQuartier = mysql_fetch_assoc($resProcess)){
				$labelQuartier = 'quartier'.$j++;
				$quartierArray[$labelQuartier]=$fetchQuartier;
			}
			$ville['quartiers']=$quartierArray;
			$labelVille = 'ville'.$i++;
			$quartiersByVille[$labelVille]=$ville;
		}
		$c->complexArrayToXML($quartiersByVille,'xml/quartiersVille.xml','quartiersVille','quartier');
		$c->complexArrayToCSV($quartiersByVille,"csv/quartiersVille.csv",'quartiersVille','quartier');
		
	}
}