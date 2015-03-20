<?php
class RequestProcessor{
	var $strategy=NULL;
	var $config=NULL;

	public function __construct($strat=NULL,$config=NULL){
		if($strat!=NULL){
			$this->strategy=$strat;
		}
		if($config!=NULL){
			$this->config=$config;
		}
	}


	/**
	 * Execute a strategy with the given $input
	 *
	 * @param unknown $input Name of the strategy to use
	 */
	public function executeStrategy($input){
		switch ($input){
			case 'adressesRue':
				$this->strategy=new AdressesRue($this->config);
				break;
			case 'ruesQuartier':
				$this->strategy=new RuesQuartier($this->config);
				break;
			case 'ruesSousQuartier':
				$this->strategy=new RuesSousQuartier($this->config);
				break;
			case 'quartiersVille':
				$this->strategy=new QuartiersVille($this->config);
				break;
			case 'adressesArchitecte':
				$this->strategy=new AdressesArchitecte($this->config);
				break;
			case 'urlPhotosRue':
				$this->strategy=new UrlPhotosRue($this->config);
				break;
			case 'urlPhotosQuartier':
				$this->strategy=new UrlPhotosQuartier($this->config);
				break;
			case 'ruesVille':
				$this->strategy=new RuesVille($this->config);
				break;
			case 'adressesQuartier':
				$this->strategy=new AdressesQuartier($this->config);
				break;
			case 'urlPhotosAdresse':
				$this->strategy=new UrlPhotosAdresse($this->config);
				break;
			default:
				$this->strategy=new AdressesRue($this->config);
		}
		$this->strategy->execute();
	}

	public function setStrategy($strategy){
		$this->strategy = $strategy;
	}

	public function getStrategy(){
		return $this->strategy;
	}
	public function executeAllStrategies(){
		$strategies = array(
				'adressesRue',
				'ruesQuartier',
				'ruesSousQuartier',
				'quartiersVille',
				'adressesArchitecte',
				'urlPhotosRue',
				'urlPhotosQuartier',
				'ruesVille',
				'adressesQuartier'
		);
		foreach ($strategies as $strategy){
			$this->executeStrategy($strategy);
		}
	}
}
?>