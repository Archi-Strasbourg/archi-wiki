<?php
abstract class Strategy{
	var $config;
	public function __construct($c=NULL){
		if($c != NULL){
			$this->config= new Config(c);
		}
	}
	
	public abstract function execute();
}
?>