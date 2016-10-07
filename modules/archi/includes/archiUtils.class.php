<?php

/**
 * Class archiUtils
 *
 * Utils function to reuse in several places
 *
 * @author Antoine Rota Graziosi / InPeople
 *
 */

class archiUtils extends ArchiConfig{

	function __construct(){
		parent::__construct();
	}
	
	public function afficheFormulaire($tabTravail = array(), $afficheTitreEtLiens = 1,$params = array())
	{
		$t=new Template('modules/archi/templates/');
		$t->set_filenames(array('rechercheSimple'=>'rechercheSimple.tpl'));
	
	
		$arrayModeAffichage = array();
		if(isset($this->variablesGet['noHeaderNoFooter']))
		{
			$t->assign_block_vars('noHeaderNoFooter',array());
			$arrayModeAffichage['noHeaderNoFooter']=1;
		}
	
	
		if(isset($this->variablesGet['modeAffichage']))
		{
			$t->assign_block_vars('modeAffichage',array('value'=>$this->variablesGet['modeAffichage']));
			$arrayModeAffichage['modeAffichage']=$this->variablesGet['modeAffichage'];
		}
	
		if(isset($params['isCheckBoxAfficheResultatSurCarteChecked']) && $params['isCheckBoxAfficheResultatSurCarteChecked']==true)
		{
			$t->assign_vars(array('checkBoxAfficheResultatsSurCarte'=>'checked'));
		}
	
		$idEvenementADeplacer=0;
		// parametre idEvenementADeplacer dans le cas d'un mode d'affichage 'popupDeplacerEvenementVersGroupeAdresse'
		if(isset($this->variablesGet['idEvenementADeplacer']))
		{
			$idEvenementADeplacer=$this->variablesGet['idEvenementADeplacer'];
		}
	
		if(isset($this->variablesPost['idEvenementADeplacer']))
		{
			$idEvenementADeplacer=$this->variablesPost['idEvenementADeplacer'];
		}
	
		if($idEvenementADeplacer!=0)
		{
			$t->assign_block_vars('parametres',array('nom'=>'idEvenementADeplacer','id'=>'idEvenementADeplacer','value'=>$idEvenementADeplacer));
		}
	
	
		$t->assign_vars(array('formAction'=>$this->creerUrl('','recherche')));
		$t->assign_vars(array('urlRechercheAvancee'=>$this->creerUrl('','rechercheAvancee')));
		//$t->assign_vars(array('rechercheAvEvenement'=>$this->creerUrl('','rechercheAvEvenement',$arrayModeAffichage)));
		//$t->assign_vars(array('rechercheAvAdresse'=>$this->creerUrl('','rechercheAvAdresse',$arrayModeAffichage)));
		//$t->assign_vars(array('rechercheParCarte'=>$this->creerUrl('','rechercheParCarte',$arrayModeAffichage)));
		/**************
		**  Affichage des Erreurs et valeurs
		**/
		if (count($tabTravail) > 0)
		{
			foreach($tabTravail AS $name => $value)
			{
				$t->assign_vars(array($name => stripslashes(htmlspecialchars($value["value"]))));
				if($value["error"]!='')
				{
					$t->assign_vars(array($name."-error" => $value["error"]));
				}
			}
		}
	
		if ($afficheTitreEtLiens === 1)
		{
			$t->assign_block_vars('titreEtLiens', array());
			$t->assign_vars(array("motCleStyle"=>"width:300px;"));
		}
	
		if(!isset($params['noDisplayRechercheAvancee']) || $params['noDisplayRechercheAvancee']==false)
		{
			$t->assign_block_vars('displayRechercheAvancee',array());
		}
	
		if(!isset($params['noDisplayCheckBoxResultatsCarte']) || $params['noDisplayCheckBoxResultatsCarte']==false)
		{
			$t->assign_block_vars('displayCheckBoxResultatsCarte',array());
		}
	
		ob_start();
		$t->pparse('rechercheSimple');
		$html = ob_get_contents();
		ob_end_clean();
	
		return $html;
	}
	
	
	public function afficheFormulaireAdresse($tabTravail = array(),$modeAffichage='', $params = array())
	{
		$t=new Template('modules/archi/templates/');
		$t->set_filenames((array('rechercheFormulaire'=>'rechercheAvanceeAdresseFormulaire.tpl')));
	
		$adresse = new archiAdresse();
	
		switch($modeAffichage)
		{
			case 'calqueEvenement':
			case 'calqueImage':
			case 'calqueImageChampsMultiples':
			case 'calqueImageChampsMultiplesRetourSimple':
				$t->assign_block_vars('isCalque',array());
				$t->assign_vars(array('modeAffichage'=>$modeAffichage));
				break;
			case 'popupRechercheAdressePrisDepuis':
				// cas de la popup sur le lien prisDepuis sur le formulaire de modif d'une photo
				$t->assign_block_vars('modeAffichage',array('value'=>'popupRechercheAdressePrisDepuis'));
				$t->assign_block_vars('archiAffichage',array('value'=>'rechercheAvAdresse'));
				break;
			case 'popupRechercheAdresseVueSur':
				// cas de la popup sur le lien prisDepuis sur le formulaire de modif d'une photo
				$t->assign_block_vars('modeAffichage',array('value'=>'popupRechercheAdresseVueSur'));
				$t->assign_block_vars('archiAffichage',array('value'=>'rechercheAvAdresse'));
				break;
			case 'popupDeplacerEvenementVersGroupeAdresse':
				$t->assign_block_vars('modeAffichage',array('value'=>'popupDeplacerEvenementVersGroupeAdresse'));
				break;
			case 'rechercheAvancee':
				//$t->assign_block_vars('archiAffichage',array('value'=>'resultatsRechercheAvancee'));
				$t->assign_block_vars('archiAffichage',array('value'=>'advancedSearch'));
				break;
			case 'ajouterInteret':
				//$t->assign_block_vars('archiAffichage',array('value'=>'advancedSearch'));
				break;
			default:
				$t->assign_block_vars('noCalque',array());
				break;
		}
	
	
	
		if(isset($params['titre']) && $params['titre']!='')
		{
			$t->assign_vars(array('titre'=>$params['titre']));
		} else {
			$t->assign_vars(array('titre'=>"Recherche Adresse"));
		}
	
		if(!isset($params['noRechercheParMotCle']) || $params['noRechercheParMotCle'] == false)
		{
			$t->assign_block_vars("afficheRechercheMotCle",array());
		}
	
		if(isset($this->variablesGet['noHeaderNoFooter']))
		{
			$t->assign_block_vars('noHeaderNoFooter',array());
		}
	
		if(isset($this->variablesGet['idEvenementADeplacer']))
		{
			echo $this->variablesGet['idEvenementADeplacer'];
		}
	
		if(!isset($params['noFormElement']) || $params['noFormElement']==false)
		{
			$t->assign_block_vars('useFormElements',array());
		}
		if($modeAffichage == 'ajouterInteret'){
			$t->assign_vars(array(
					'formulaireChoixAdresse' => $adresse->afficheChoixAdresse()));
				
		}
		else{
			$t->assign_vars(array(
					'formAction' => $this->creerUrl('','rechercheAvAdresse'),
					'formulaireChoixAdresse' => $adresse->afficheChoixAdresse()));
		}
		foreach($tabTravail as $name => $value)
		{
			$t->assign_vars(array($name=>$value["value"]));
			if($value["error"]!='')
			{
				$t->assign_vars(array($name."-error" => $value["error"]));
			}
		}
	
		ob_start();
		$t->pparse('rechercheFormulaire');
		$html = ob_get_contents();
		ob_end_clean();
	
		return $html;
	}
	public function get_decorated_diff($old, $new){
		$from_start = strspn($old ^ $new, "\0");
		$from_end = strspn(strrev($old) ^ strrev($new), "\0");
	
		$old_end = strlen($old) - $from_end;
		$new_end = strlen($new) - $from_end;
	
		$start = substr($new, 0, $from_start);
		$end = substr($new, $new_end);
		$new_diff = substr($new, $from_start, $new_end - $from_start);
		$old_diff = substr($old, $from_start, $old_end - $from_start);
	
		$new = "$start<ins style='background-color:#ccffcc'>$new_diff</ins>$end";
		$old = "$start<del style='background-color:#ffcccc'>$old_diff</del>$end";
		//return array("old"=>$old, "new"=>$new);
		
		debug(array('start'=>$start, 'new_diff'=> $new_diff , 'old_diff' => $old_diff , 'end' => $end));
		
		$t = new Template('modules/archi/templates/');
		$t->set_filenames(array('diff' => "utils/diff.tpl"));
		
		$t->assign_vars(array("old"=>$old, "new"=>$new));
		
		ob_start();
		$t->pparse('diff');
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
	
	
	public function multilineDiff($old,$new){
		
		$tmp1 = str_replace("\r", '', $old);
		$tmp2 = str_replace("\r", '', $new);
		
		
		$oldArray = explode(PHP_EOL,$tmp1);
		$newArray =  explode(PHP_EOL,$tmp2);
		
		
		/*
		$oldArray = preg_split('/[\r\n]+/', $old);
		$newArray = preg_split('/[\r\n]+/', $new);
		*/
		
		$inter = array_intersect($oldArray, $newArray);
		debug(array('intersect'=>$inter));
		/*
		$del = array_diff(array_merge($oldArray, $newArray), array_intersect($oldArray, $newArray)); 
		$ins = array_diff(array_merge($newArray,$oldArray), array_intersect($newArray,$oldArray));
		*/

		$del = array_diff($oldArray,$newArray);
		$ins = array_diff($newArray,$oldArray);
				//array_diff(array_merge($left, $right), array_intersect($left, $right));
		

		
		
		debug(array('oldArray'=>$oldArray, 'newArray'=>$newArray));
		debug(array('del'=>$del, 'ins'=>$ins, 'intersec' => $inter));
	}
	
	
	public function monDiff($old,$new){
		//Split strings in array
		$tmpOld = str_replace("\r", '', $old);
		$tmpNew = str_replace("\r", '', $new);
		$tmpOld = str_replace("\n", ' ', $tmpOld);
		$tmpNew = str_replace("\n", ' ', $tmpNew);
		
		debug(array(
			'old'=>$old,
			'new'=>$new
		));
		
		
		$oldArray = explode(' ',$old);
		$newArray =  explode(' ',$new);
		
		$tmpOldArray = explode(' ',$tmpOld);
		$tmpNewArray =  explode(' ',$tmpNew);
		
		
		/*
		debug(array(
		'oldArray'=>$oldArray,
		'tmpOldArray'=>$tmpOldArray,
		'newArray'=>$newArray,
		'tmpNewArray'=>$tmpNewArray
		));
		*/
		
		
		//Get difference between 2 texts
		$del = array_diff($tmpOldArray, $tmpNewArray);
		$ins= array_diff($tmpNewArray,$tmpOldArray);

		//debug(array('old'=> $oldArray, 'new'=> $newArray,'del'=>$del , 'ins'=>$ins));
		debug(array('del'=>$del , 'ins'=>$ins));
		
		/*
		 * Ocurrence process 
		 * 
		 * Still need to process  the duplicate value also present in the other string
		 */
		$occurOld = array_count_values($tmpOldArray);
		$occurNew = array_count_values($tmpNewArray);
		
		
		//Remove the values already tagged in del
		foreach($del as $delWord){
			if(array_key_exists($delWord, $occurOld)){
				unset($occurOld[$delWord]);
			}
		}
		
		//Remove the values already tagged in ins
		foreach ($ins as $insElement){
			if(array_key_exists($insElement, $occurNew)){
				unset($occurNew[$insElement]);
			}
		}
		
		
		$additionalDel=array();
		$additionalIns=array();
		if(count($occurNew) == count($occurOld)){
			foreach ($occurOld as $word => $occurence){
				//If the nb of word present in each string is different ...
				if($occurOld[$word] > $occurNew[$word]){ //If there are more occurence in old string, those words has been deleted from oldString
					for($i=0;$i<$occurOld[$word]-$occurNew[$word];$i++){
						$additionalDel[]=$word;
					}
				}
				elseif($occurOld[$word] < $occurNew[$word]){ //Else those words has been add
					for($i=0;$i<$occurNew[$word]-$occurOld[$word];$i++){
						$additionalIns[]=$word;
					}
				}
			}
		}
		

		foreach ($additionalDel as $word){
			$test = $this->findAdditionnalDelIndex($oldArray, $newArray, $del, $word);
			$del[$test]=$word;
		}
		
		foreach ($additionalIns as $word){
			$test = $this->findAdditionnalDelIndex($newArray,$oldArray, $ins, $word);
			$ins[$test]=$word;
		}

		//Sort insertion and delete array
		ksort($del);
		ksort($ins);

		debug(array('del'=>$del , 'ins'=>$ins));
		
		
		
		$tagOpen = 0;
		
		//Add tag for insertion/suppression
		foreach ($del as $key => $value){
			$temp='';
			if(!$tagOpen){
				$temp = "<del>";
				$tagOpen = 1;
			}
			$temp.=$value;
			if(!array_key_exists($key+1, $del)&& $tagOpen){
				$tagOpen=0;
				$temp.="</del>";
			}
			
			$del[$key]=$temp;
		}
		
		$tagOpen=0;
		foreach ($ins as $key => $value){
			$temp="";
			if(!$tagOpen){
				$temp = "<ins>";
				$tagOpen = 1;
			}
			$temp.=$value;
			if(!((bool)array_key_exists($key+1, $ins))&& $tagOpen){
				$tagOpen=0;
				$temp.="</ins>";
			}
			$ins[$key]=$temp;
		}
		
		
		//Merge two arrays
		$decoratedOld = $del + $oldArray;
		$decoratedNew= $ins + $newArray;
		
		
		//Sort array by index
		ksort($decoratedOld);
		ksort($decoratedNew);
		
		
		$decoratedOldString = implode(" ", $decoratedOld);
		$decoratedNewString = implode(" ", $decoratedNew);
		

		//debug(array('del'=> $del , 'ins'=>$ins,'old' => $decoratedOldString,'new'=>$decoratedNewString ));
		return array('old' => $decoratedOldString,'new'=>$decoratedNewString);
	}
	
	private function findAdditionnalDelIndex($old,$new,$del,$word){
			//debug(array($old,$new,$del,$word));
			if(count($old)>0 || count($new)>0){
			$temp = array_keys($old);
			$keyOld = $temp[0];
			$temp = array_keys($new);
			$keyNew = $temp[0];
			
			if($old[$keyOld] == $new[$keyNew]){
				unset($old[$keyOld]);
				unset($new[$keyNew]);
				return $this->findAdditionnalDelIndex($old, $new, $del, $word);
			}
			else if($del[$keyOld] == $old[$keyOld]){
				unset($old[$keyOld]);
				return $this->findAdditionnalDelIndex($old, $new, $del, $word);
			}
			else{
				if($old[$keyOld] == $word){
					return $keyOld;
				}
			}
		}
		else{
			return -1;
		}
	}
	
	
	
	
	public function yoloDiff($t1,$t2){
		include 'includes/framework/frameworkClasses/finediff.php';

		$opcodes = FineDiff::getDiffOpcodes($t1, $t2 , FineDiff::$wordGranularity );
		
		
		debug(array(
		'HTML'=>FineDiff::renderDiffToHTMLFromOpcodes($t1, $opcodes),
		'text' =>FineDiff::renderToTextFromOpcodes($t1, $opcodes),
		));
		return FineDiff::renderDiffToHTMLFromOpcodes($t1, $opcodes);
	}
	
}
?>