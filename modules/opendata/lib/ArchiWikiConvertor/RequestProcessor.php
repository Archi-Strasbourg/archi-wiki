<?php
class RequestProcessor{
	var $strategy=NULL;

	public function __construct($strat=NULL){
		if($strat!=NULL){
			$this->strategy=$strat;
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
				$this->strategy=new AdressesRue();
				break;
			case 'ruesQuartier':
				$this->strategy=new RuesQuartier();
				break;
			case 'ruesSousQuartier':
				$this->strategy=new RuesSousQuartier();
				break;
			case 'quartiersVille':
				$this->strategy=new QuartiersVille();
				break;
			case 'adressesArchitecte':
				$this->strategy=new AdressesArchitecte();
				break;
			case 'urlPhotosRue':
				$this->strategy=new UrlPhotosRue();
				break;
			case 'urlPhotosQuartier':
				$this->strategy=new UrlPhotosQuartier();
				break;
			case 'ruesVille':
				$this->strategy=new RuesVille();
				break;
			case 'adressesQuartier':
				$this->strategy=new AdressesQuartier();
				break;
			default:
				$this->strategy=new AdressesRue();
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