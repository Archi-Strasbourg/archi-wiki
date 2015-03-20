<?php

/**
 *
 * @author Antoine Rota Graziosi/InPeople 2014
 *
 */
class Convertor{

	/*
	 * database : array
	* Fields :
	* server
	* user
	* pass
	* database
	*/
	var $database_info;
	public function __construct($connection_params=array()){
		if(!empty($connection_params)){
			$this->database_info = $connection_params;
		}
	}
	/**
	 * Connect to the database, using credentials
	 * Credentiel input in constructor have priority
	 *
	 * @param unknown $server
	 * @param unknown $user
	 * @param unknown $password
	 * @param unknown $database
	 */
	public function connect($server,$user,$password,$database){
		if(empty($this->database_info['server']) || $this->database_info['server']==''){
			$this->database_info['server'] = $server;
		}
		if(empty($this->database_info['user']) || $this->database_info['user']==''){
			$this->database_info['user'] = $user;
		}
		if(empty($this->database_info['pass']) || $this->database_info['pass']==''){
			$this->database_info['pass'] = $password;
		}
		if(empty($this->database_info['database']) || $this->database_info['database']==''){
			$this->database_info['database'] = $database;
		}

		mysql_connect(
		$this->database_info['server'],
		$this->database_info['user'],
		$this->database_info['pass']
		);
		@mysql_select_db($this->database_info['database']) or die("Unable to connect to ".$this->database_info['database']." database.");
	}

	/**
	 * Executing the request in parameter
	 *
	 * @param unknown $request
	 * @param string $silencieux
	 * @return resource
	 */
	function execute($request,$silencieux=false){
		if ($silencieux==false) {
			$res = mysql_query($request)
			or
			die($request.' -- '.mysql_error().' -- <br/> Request in file : <b>'.debug_backtrace()[0]['file'].'</b><br/> on line <b>'.debug_backtrace()[0]['line']).'</b>';
		}
		else {
			$res = mysql_query($request);
		}
		return $res;
	}

	/**
	 * Execute a request and return the result as an array
	 *
	 * @param unknown $request
	 * @return multitype:multitype:
	 */
	public function processRequest($request,$rowIndex ='row'){
		$requestResult = array();
		$result = $this->execute($request);
		$i=0;
		while($row = mysql_fetch_assoc($result)){
			$index = $rowIndex.$i++;
			$requestResult[$index] = $row;
		}
		return $requestResult;
	}


	public function arrayToXML($input = array(),$output = 'output.xml',$startingNode='result' , $row = 'row' ){
		$writer = new XMLWriter();
		
		$writer->openURI($output);
		
		//$writer->openURI('php://output');
		$writer->startDocument('1.0','UTF-8');
		$writer->setIndent(4);
		$writer->startElement($startingNode);
		foreach ($input as $balise => $data){
			$writer->startElement($row);
			foreach($data as $key => $value) {
				$writer->writeElement($key,$value);
			}
			$writer->endElement();//end of the row tag
		}
		$writer->endElement();//End of the result tag
		$writer->endDocument();//end of the document
		$writer->flush();
	}

	public function complexArrayToXML($input = array(),$output = 'output.xml',$startingNode='result' , $row = 'row'){
		$writer = new XMLWriter();
		$writer->openURI($output);
		//$writer->openURI('php://output');
		$writer->startDocument('1.0','UTF-8');
		$writer->setIndent(4);
		//$writer->startElement($startingNode);
		$this->aToX($writer, $input,$startingNode);
		//$writer->endElement();
		$writer->endDocument();//end of the document
		$writer->flush();
	}

	private function aToX(XMLWriter $writer,$array,$startElement='result'){
		if(is_array($array)){
			$writer->startElement($startElement);
			foreach ($array as $key => $value){
				$this->aToX($writer,$value,$key);
			}
			$writer->endElement();
		}
		else{
			$writer->writeElement($startElement,utf8_encode($array));
		}
	}

	/**
	 * Test method
	 */
	public function simpleXML(){
		$writer = new XMLWriter();
		$writer->openURI('test.xml');
		//$writer->openURI('php://output');
		$writer->startDocument('1.0','UTF-8');
		$writer->setIndent(4);

		$writer->startElement('test');
		$writer->writeElement('blop','blupblup');
		$writer->endElement();
		$writer->endDocument();
		$writer->flush();
	}
	
	
	public function complexArrayToCSV($input = array(),$output = 'output.csv',$startingNode='result' , $row = 'row'){
		$utils = new Utils();
		$simpleArray = $utils->flat($input);
		$file = fopen($output,"w");
		foreach ($simpleArray as $line){
			if(is_array($line)){
				foreach ($line as $k=>$v){
					$convertLine[$k] = iconv('Windows-1252', 'UTF-8//TRANSLIT', $v);
				}
				$line=$convertLine;
			}
			fputcsv($file,$line);
		}
		fclose($file);

	}
}
?>