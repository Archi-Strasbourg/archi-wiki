<?php
class RuesSousQuartier implements Strategy{
	public function execute(){
		$c = new Convertor();
		$c->connect('localhost', 'archiwiki', 'archi-dev', 'archi_v2');

		//Requesting all the streets
		$requestQuartier = "
				SELECT idSousQuartier ,nom
				FROM sousQuartier
				WHERE nom != ''
				GROUP BY idSousQuartier
				ORDER BY idSousQuartier
				";

		$res = $c->execute($requestQuartier);
		$idQuartierArray = array();
		$listeQuartier = array();
		while ($fetch = mysql_fetch_assoc($res)){
			$listeQuartier[]=$fetch;
		}
		$ruesByQuartier = array();
		$i=0;
		foreach ($listeQuartier as $quartierInfo){
			$quartier =array();
			$quartier['nom'] = $quartierInfo['nom'];
			$request = "
					SELECT r.prefixe , r.nom
					FROM historiqueAdresse ha
					LEFT JOIN rue r on r.idRue = ha.idRue
					WHERE ha.idSousQuartier = ".$quartierInfo['idSousQuartier']."
							GROUP BY ha.idRue
							ORDER BY ha.idRue
							";
			$resProcess = $c->processRequest($request,'rue');
			$quartier['rues'] = $resProcess;
			$label  = 'sousQuartier'.$i++;
			$ruesByQuartier[$label]=$quartier;
		}
		$c->complexArrayToXML($ruesByQuartier,"xml/ruesSousQuartier.xml",'ruesSousQuartier','rue');
		$c->complexArrayToCSV($ruesByQuartier,"csv/ruesSousQuartier.csv",'ruesSousQuartier','rue');
	}
}