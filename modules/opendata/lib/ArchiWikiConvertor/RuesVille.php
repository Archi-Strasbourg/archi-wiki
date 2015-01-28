<?php
class RuesVille implements Strategy{
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
					SELECT r.prefixe as prefixe, r.nom as nom
					FROM rue r
					LEFT JOIN sousQuartier sq on sq.idSousQuartier = r.idSousQuartier
					LEFT JOIN quartier q on q.idQuartier = sq.idQuartier
					LEFT JOIN ville v on v.idVille = q.idVille
					WHERE v.idVille = ".$info['idVille']."
							ORDER BY q.idVille
							";
			$resProcess = $c->execute($request);
			$quartierArray = array();
			$j=0;
			while($fetchQuartier = mysql_fetch_assoc($resProcess)){
				$labelQuartier = 'rues'.$j++;
				$quartierArray[$labelQuartier]=$fetchQuartier;
			}
			$ville['rues']=$quartierArray;
			$labelVille = 'ville'.$i++;
			$quartiersByVille[$labelVille]=$ville;
		}
		$c->complexArrayToXML($quartiersByVille,'xml/ruesVille.xml','ruesVille','rue');
		$c->complexArrayToCSV($quartiersByVille,"csv/ruesVille.csv",'ruesVille','rue');
	}
}
?>