<?php
class ConfigOD{
	private $user;
	private $password;
	private $db_name;
	private $server;
	
	public function __construct($u,$p,$db,$s){
		$this->setUser($u);
		$this->setPassword($p);
		$this->setDBName($db);
		$this->setServer($s);
	}

	
	/*
	 * Getter and setter
	 */
	public function getUser(){
		return $this->user;
	}
	public function setUser($u){
		$this->user = $u;
	}

	public function getPassword(){
		return $this->password;
	}
	public function setPassword($pwd){
		$this->password = $pwd;
	}

	public function getDBName(){
		return $this->db_name;
	}
	public function setDBName($db){
		$this->db_name = $db ;
	}

	public function getServer(){
		return $this->server;
	}
	public function setServer($s){
		$this->server = $s ;
	}
	
}
?>