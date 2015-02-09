<?php
class RuesQuartier extends Strategy{
	public function execute(){
		$c = new Convertor();
		$c->connect($this->config->getServer(),$this->config->getUser(),$this->config->getPassword(),$this->config->getDBName());
		
		//Requesting all the streets
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
					WHERE ha.idQuartier = ".$quartierInfo['idQuartier']."
							GROUP BY ha.idRue
							ORDER BY ha.idRue
							";
			$resProcess = $c->processRequest($request,'rue');
			$quartier['rues'] = $resProcess;
			$label  = 'quartier'.$i++;
			$ruesByQuartier[$label]=$quartier;
		}
		$c->complexArrayToXML($ruesByQuartier,"xml/ruesQuartier.xml",'ruesQuartier','rue');
		$c->complexArrayToCSV($ruesByQuartier,"csv/ruesQuartier.csv",'ruesQuartier','rue');
	}
}
?>