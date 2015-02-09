<?php
abstract class Strategy{
	var $config;
	public function __construct($c){
		if($c != NULL){
			$this->config= $c;
		}
	}
	
	public abstract function execute();
}
?>