<?php 
/**
 * Class archiInterest
 *
 * Responsible for the interests of a user
 *
 * @author Antoine Rota Graziosi / InPeople
 *
 */

class archiInterest extends config{
	protected $userId;

	function __construct(){
		$auth = new archiAuthentification();
		$this->userId = $auth->getIdUtilisateur();
		parent::__construct();
	}

	/**
	 * Displaying user interests
	 *
	 * @return string
	 */
	public function displayMyInterest(){
		$auth = new archiAuthentification();
		if($auth->estConnecte()){
			
		
			$html ="";
			$formulaire = new formGenerator();
			$utils = new archiUtils();
			$ajax = new ajaxObject();
			$html.=$ajax->getAjaxFunctions();
	
			$t = new Template($this->getCheminPhysique().$this->cheminTemplates."interest/");
			$t->set_filenames(array('myinterests'=>'myinterests.tpl'));
	
	
			$a = new archiAdresse();
	
			//Generate address form
			$formAddressAddInterest=$a->afficheChoixAdresse(array('afficheNombreResultat' => 1));
			//$formAddressAddInterest=$a->afficheChoixAdresse();
			
	
			$paramsFields= array();
			$paramsFields[] = array('table' => 'pays' ,'value' => 'idPays','title'=>'nom');
			$paramsFields[] = array('table' => 'ville' ,'value' => 'idVille','title'=>'nom');
			$paramsFields[] = array('table' => 'quartier' ,'value' => 'idQuartier','title'=>'nom');
			$paramsFields[] = array('table' => 'sousQuartier' ,'value' => 'idSousQuartier','title'=>'nom');
			$paramsFields[] = array('table' => 'rue' ,'value' => 'idRue','title'=>'nom');
	
	
	
			$formActionUrl = $this->creerUrl('','saveInterest',array());
	
			foreach ($paramsFields as $params){
				$options[] = $this->getAllField($params);
			}
	
	
			$paramsRequest[]=array('table'=> '_interetRue','field' =>'idRue' , 'associateTable' => 'rue');
			$paramsRequest[]=array('table'=> '_interetSousQuartier','field' =>'idSousQuartier', 'associateTable' => 'sousQuartier');
			$paramsRequest[]=array('table'=> '_interetQuartier','field' =>'idQuartier', 'associateTable' => 'quartier');
			$paramsRequest[]=array('table'=> '_interetVille','field' =>'idVille', 'associateTable' => 'ville');
			$paramsRequest[]=array('table'=> '_interetPays','field' =>'idPays', 'associateTable' => 'pays');
	
			$userInterest = $this->getAllInterest($paramsRequest);
			/*
			 * Array of EVERY interest  by categories : street country address etc..
			 */
			foreach ($userInterest as $interestByCat){
				if(!isset($interestByCat[0]['vide'])){
					$t->assign_block_vars('interestList',array('title'=>'Liste des '.$interestByCat[0]['titre'].' dans les centres d\'intérêt','CSSclass'=>'interestList'));
					/*
					 * Interest of each category
					 */
					foreach ($interestByCat as $interest){
						/*
						 * Process fields for delete link
						 */
						$table = $interest['table'];
						$fieldId = $interest['field'];
						$userId = $interest['idUtilisateur'];
						$interestId = $interest[$fieldId];
						
						
						$paramsDelete = array(
							$table,
							$fieldId,
							$userId,
							$interestId
						);
						
						$deleteUrl = $this->creerUrl('', 'deleteInterest', array('params' => $paramsDelete));
						switch ($interest['associateTable']){
							case 'personne':
								$t->assign_block_vars('interestList.interests',array(
								'name'=>$interest['nom']." ".$interest['prenom'],
								'deleteUrl' => $deleteUrl
								));
								break;
							default:
								$t->assign_block_vars('interestList.interests',array(
								'name'=>$interest['nom'],
								'deleteUrl' => $deleteUrl
								));
						}
					}
				}
				else{
					$t->assign_block_vars('interestList',array('vide'=>'Aucun résultat','title'=>'Liste des '.$interestByCat[0]['titre'].' dans les centres d\'intérêt','CSSclass'=>'interestList'));
				}
					
			}
	
			$t->assign_vars(array(
					'formAddInterest' => $formAddressAddInterest,
					'formActionUrl' => $formActionUrl,
					'nameForm'=>'saveInterest'
			));
	
			ob_start();
			$t->pparse('myinterests');
			$html .= ob_get_contents();
			ob_end_clean();
		return $html;
		}
		else{
			$this->messages->addError("Veuillez vous connecter pour personnaliser votre flux");
			$this->messages->display();
			$auth = new ArchiAuthentification();
			return $auth->afficheFormulaireAuthentification();
		}
	}


	/**
	 * This method save the interest with
	 */
	public function saveInterest(){
		$t = new Template($this->getCheminPhysique().$this->cheminTemplates."interest/");
		$t->set_filenames(array('confirm'=>'confirm.tpl'));
		
		$urlBack = $this->creerUrl('', 'mesInterets', array());
		$txtLink = "Revenir à la liste de mes intérêts";
		
		if(isset($this->variablesPost) && !empty($this->variablesPost)){
			$interets = $this->variablesPost;
		}
		elseif (isset($this->variablesGet) && !empty($this->variablesGet)){
			$interets = $this->variablesGet;
		}
		
		
		
		/*
		 * Initially, it was adding related nesting element in the interests of the user
		 * Client asked to add only the smallest element in interest (if neighborhood selected, don't add the city and the country)
		 * Little array handling to satified the client need, to revert, delete the two following loops 
		 */
		foreach ($interets as $key => $int){
			if($int== 0){
				unset($interets[$key]);
			}
		}
		while(count($interets)>1){
			array_shift($interets);
		}
		
		
		$requestParameters = array();
		if($interets['rue']!=0){
			$requestParameters[]=array('table'=>'_interetRue','fieldName1'=>'idUtilisateur','fieldName2'=>'idRue','idInteret'=>$interets['rue'],'userId'=>$this->userId);
		}
		if($interets['sousQuartier']!=0){
			$requestParameters[]=array('table'=>'_interetSousQuartier','fieldName1'=>'idUtilisateur','fieldName2'=>'idSousQuartier','idInteret'=>$interets['sousQuartier'],'userId'=>$this->userId);
		}
		if($interets['quartier']!=0){
			$requestParameters[]=array('table'=>'_interetQuartier','fieldName1'=>'idUtilisateur','fieldName2'=>'idQuartier','idInteret'=>$interets['quartier'],'userId'=>$this->userId);
		}
		if($interets['ville']!=0){
			$requestParameters[]=array('table'=>'_interetVille','fieldName1'=>'idUtilisateur','fieldName2'=>'idVille','idInteret'=>$interets['ville'],'userId'=>$this->userId);
		}
		if($interets['pays']!=0){
			$requestParameters[]=array('table'=>'_interetPays','fieldName1'=>'idUtilisateur','fieldName2'=>'idPays','idInteret'=>$interets['pays'],'userId'=>$this->userId);
		}
		if($interets['adresse']!=0){
			$idHistoriqueAdresse = $interets['adresse'];
			$requestParameters[]=array('table'=>'_interetAdresse','fieldName1'=>'idUtilisateur','fieldName2'=>'idHistoriqueAdresse','idInteret'=>$interets['adresse'],'userId'=>$this->userId);
			
			$requete = "
					SELECT ae.idEvenement as idEvenementGroupeAdresse, ae.idAdresse as idAdresse 
					FROM _adresseEvenement ae
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse 
					WHERE ha.idHistoriqueAdresse  = ".$idHistoriqueAdresse."
					";			
			$result = $this->connexionBdd->requete($requete);
			$fetch = mysql_fetch_array($result);
			$idAdresse = $fetch['idAdresse'];
			$idEvenementGroupeAdresse = $fetch['idEvenementGroupeAdresse'];
			
			$evenement = new archiEvenement();
			$titreAdresse = $evenement->getIntituleAdresseFrom($idAdresse,'idAdresse');
			
			$urlBack = $this->creerUrl('','',array('archiAffichage'=>'adresseDetail','archiIdAdresse'=>$idAdresse,'archiIdEvenementGroupeAdresse'=>$idEvenementGroupeAdresse));
			$txtLink="Aller à l'adresse " . $titreAdresse;
		}
		if($interets['personne']){
			$requestParameters[]=array('table'=>'_interetPersonne','fieldName1'=>'idUtilisateur','fieldName2'=>'idPersonne','idInteret'=>$interets['personne'],'userId'=>$this->userId);
			$urlBack = $this->creerUrl('', 'evenementListe', array('selection' => 'personne', 'id' => $interets['personne']));
			$txtLink = "Retour à la fiche de la personne";
		}

		$nbEltInserted=0;
		foreach ($requestParameters as $rp){
			//Insert if not exists
			$requete= "
					INSERT INTO ".$rp['table']." (".$rp['fieldName1'].",".$rp['fieldName2'].",created)
					SELECT '".$this->userId."', '".$rp['idInteret']."' , now()
					FROM DUAL
					WHERE NOT EXISTS (SELECT * FROM `".$rp['table']."`
					WHERE ".$rp['fieldName1']."='".$this->userId."' AND ".$rp['fieldName2']."='".$rp['idInteret']."')
					LIMIT 1
					";
			$res = $this->connexionBdd->requete($requete,false);
		}
		$this->messages->addConfirmation('Intérêt(s) sauvegardé(s) avec succès !');
		$t->assign_vars(array(
				'message' =>  $this->messages->display(),
				'textLink' => $txtLink,
				'urlBack'=> $urlBack
		)); 
		ob_start();
		$t->pparse('confirm');
		$html .= ob_get_contents();
		ob_end_clean();
		return $html;
	}

	
	
	public function deleteInterest(){
		$t = new Template($this->getCheminPhysique().$this->cheminTemplates."interest/");
		$t->set_filenames(array('confirminterests'=>'confirm.tpl'));
		
		/*
		 * Process the params field to get the proper information for the SQL request 
		 */
		$table = $this->variablesGet['params'][0];
		$fieldId = $this->variablesGet['params'][1];
		$userId = $this->variablesGet['params'][2];
		$interestId = $this->variablesGet['params'][3];
		
		$requete= "
				SELECT count(*) as nb
				FROM ".$table."
				WHERE idUtilisateur = ".$userId."
				AND ".$fieldId." = ".$interestId
					;
		$res = $this->connexionBdd->requete($requete,false);
		$fetch = mysql_fetch_assoc($res);
		if($fetch['nb']==1){
			$requeteDelete = "
					DELETE FROM ".$table." WHERE ".$fieldId." = ".$interestId. " AND idUtilisateur = " . $userId
					;
			$resDelete = $this->connexionBdd->requete($requeteDelete);
			if ($resDelete) {
				$this->messages->addConfirmation("Intérêt(s) supprimé(s) !");
			} else {
				$this->messages->addError("Problème dans la suppression de l'interest !");
			}
		}
		else {
			$this->messages->addError("Aucun intérêt spécifié !");
		}
		
		$t->assign_vars(array(
				'message' => $this->messages->display(),
				'urlBack'=> $this->creerUrl('', 'mesInterets', array()),
				'textLink' => _("Revenir à la page précédante")
		));

		ob_start();
		$t->pparse('confirminterests');
		$html .= ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	/**
	 * Get an array of idEvenementGroupeAdresse of the latest modification of the user
	 * 
	 * @param number of element to display
	 * @return array of idEvenementGroupeAdresse
	 */
	public function getFavorisIdEvenementGroupeAdresse($nbElts=8){
		if($nbElts > 0){
			$limit = "LIMIT ".$nbElts;
		}
		
		$a = new ArchiAuthentification();
		if($a->estConnecte()){
			$this->userId = $a->getIdUtilisateur();
			/*
			 * Adresse
			*/
			$requete ="
				SELECT ae.idEvenement
				FROM _interetAdresse ia
				LEFT JOIN historiqueAdresse ha on ha.idHistoriqueAdresse = ia.idHistoriqueAdresse
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE ia.idUtilisateur = ".$this->userId."
				$limit
							";
			$resultAdresse = $this->connexionBdd->requete($requete);
			while($rowAdresse = mysql_fetch_assoc($resultAdresse)){
				if(isset($rowAdresse['idEvenement'] ) && $rowAdresse['idEvenement']!=''){
					$idEvenementArray[] = $rowAdresse['idEvenement'];
				}
			}
			
			/*
			 * Rue
			*/
			$requete ="
				SELECT ae.idEvenement
				FROM _interetRue i
				LEFT JOIN historiqueAdresse ha on ha.idRue = i.idRue
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE i.idUtilisateur = ".$this->userId."
				$limit
							";
			$result = $this->connexionBdd->requete($requete);
			while($row = mysql_fetch_assoc($result)){
				if(isset($row['idEvenement'] ) && $row['idEvenement']!=''){
					$idEvenementArray[] = $row['idEvenement'];
				}
			}
			
			
			/*
			 * Sous quartier
			*/
			$requete ="
				SELECT ae.idEvenement
				FROM _interetSousQuartier i
				LEFT JOIN historiqueAdresse ha on ha.idSousQuartier = i.idSousQuartier
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE i.idUtilisateur = ".$this->userId."
				$limit
							";
			$result = $this->connexionBdd->requete($requete);
			while($row = mysql_fetch_assoc($result)){
				if(isset($row['idEvenement'] ) && $row['idEvenement']!=''){
					$idEvenementArray[] = $row['idEvenement'];
				}
			}
			
			
			/*
			 * Personne
			*/
			$requete ="
				SELECT ep.idEvenement
				FROM _interetPersonne i
				LEFT JOIN _evenementPersonne ep on ep.idPersonne = i.idPersonne
				WHERE i.idUtilisateur = ".$this->userId."
				$limit
							";
			$result = $this->connexionBdd->requete($requete);
			while($row = mysql_fetch_assoc($result)){
				if(isset($row['idEvenement'] ) && $row['idEvenement']!=''){
					$idEvenementArray[] = $row['idEvenement'];
				}
			}
			
			
			/*
			 * Quartier
			*/
			$requete ="
				SELECT ae.idEvenement
				FROM _interetQuartier i
				LEFT JOIN historiqueAdresse ha on ha.idQuartier = i.idQuartier
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE i.idUtilisateur = ".$this->userId."
				$limit
							";
			$result = $this->connexionBdd->requete($requete);
			while($row = mysql_fetch_assoc($result)){
				if(isset($row['idEvenement'] ) && $row['idEvenement']!=''){
					$idEvenementArray[] = $row['idEvenement'];
				}
			}
			
			
			
			/*
			 * Ville
			*/
			$requete ="
				SELECT ae.idEvenement
				FROM _interetVille i
				LEFT JOIN historiqueAdresse ha on ha.idVille = i.idVille
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE i.idUtilisateur = ".$this->userId."
				$limit
							";
			$result = $this->connexionBdd->requete($requete);
			while($row = mysql_fetch_assoc($result)){
				if(isset($row['idEvenement'] ) && $row['idEvenement']!=''){
					$idEvenementArray[] = $row['idEvenement'];
				}
			}
			
			
			/*
			 * Pays
			*/
			$requetePays ="
				SELECT ae.idEvenement
				FROM _interetPays ip
				LEFT JOIN historiqueAdresse ha on ha.idPays = ip.idPays
				LEFT JOIN _adresseEvenement ae on ae.idAdresse = ha.idAdresse
				WHERE ip.idUtilisateur = ".$this->userId."
							LIMIT $nbElts
							";
			$resultPays = $this->connexionBdd->requete($requetePays);
			while($rowPays = mysql_fetch_assoc($resultPays)){
				if($rowPays['idEvenement'] != "" && isset($rowPays['idEvenement'])){
					$idEvenementArray[] = $rowPays['idEvenement'];
				}
			}
			
		}
		
		
		//Array_unique enable to remove double value get from multiple select
		$idEvenementGA = array_unique($idEvenementArray);
		$array_in = '('.implode(',', $idEvenementGA).')';
		
		$array_return = array();
		foreach ($idEvenementGA as $idEvt){
			$requete = "
			SELECT DISTINCT ae.idAdresse,
			evt.idEvenement ,
			DATE_FORMAT(evt.dateCreationEvenement, '%Y%m%d%H%i%s') as DateTri,
			evt.titre,
			evt.description
			
			FROM evenements evt
			LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = evt.idEvenement
			LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee.idEvenement
			WHERE ee.idEvenement = $idEvt
			ORDER BY DateTri DESC
			LIMIT 1
			";
			$result=$this->connexionBdd->requete($requete);
			$row = mysql_fetch_assoc($result);
			$array_return[]=$row['idEvenement'];
		}

		return array_unique($array_return);
	}
	
	
	/*
	 * Private functions
	*/


	/**
	 * Get the list of the countries in the interest list of the user
	 *
	 * @return multitype:String array of the countries name
	 */
	private function getCountryInterest(){
		$countriesList = array();
		$requete = "
				SELECT p.idPays , p.nom , i.idPays
				FROM pays p
				LEFT JOIN _interetPays i on i.idPays = p.idPays
				WHERE i.idUtilisateur  = ".$this->userId."
						";

		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$countriesList[]=$fetch['nom'];
		}
		return $countriesList;
	}

	/**
	 * Get the list of the cities in the interest list of the user
	 *
	 * @return multitype:String array of the cities name
	 */
	private function getCityInterest(){
		$citiesList = array();
		$requete = "
				SELECT v.idVille , v.nom , i.idVille
				FROM ville v
				LEFT JOIN _interetVille i on i.idVille = v.idVille
				WHERE i.idUtilisateur  = ".$this->userId."
						";

		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$citiesList []=$fetch['nom'];
		}
		return $citiesList;
	}

	/**
	 * Get the list of the neighborhood in the interest list if the user
	 *
	 * @return multitype: array of neighborhood
	 */
	private function getSubNeighborhoodInterest(){
		$sneighborhood = array();
		$requete ="
				SELECT sq.idSousQuartier , sq.nom , i.idSousQuartier
				FROM sousQuartier sq
				LEFT JOIN _interetSousQuartier i on i.idSousQuartier = sq.idSousQuartier
				WHERE i.idUtilisateur  = ".$this->userId."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$sneighborhood []=$fetch['nom'];
		}
		return $sneighborhood;
	}

	private function getNeighborhoodInterest(){
		$neighborhood = array();
		$requete ="
				SELECT sq.idQuartier , sq.nom , i.idQuartier
				FROM quartier sq
				LEFT JOIN _interetQuartier i on i.idQuartier = sq.idQuartier
				WHERE i.idUtilisateur  = ".$this->userId."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$neighborhood []=$fetch['nom'];
		}
		return $neighborhood;
	}


	/**
	 * Get the list of the streets in the interest list if the user
	 *
	 * @return multitype: array of streets
	 */
	private function getStreetInterest(){
		$street = array();
		$requete ="
				SELECT r.idRue , r.nom , i.idRue
				FROM rue r
				LEFT JOIN _interetRue i on i.idRue = r.idSousQuartier
				WHERE i.idUtilisateur  = ".$this->userId."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$street[]=$fetch['nom'];
		}
		return $street;
	}


	/**
	 * Get the list of the addresses in the interest list if the user
	 *
	 * @return multitype: array of addresses
	 */
	private function getAddressInterest(){
		$address = array();
		$requete ="
				SELECT a.idHistoriqueAdresse , a.nom , i.idHistoriqueAdresse
				FROM historiqueAdresse a
				LEFT JOIN _interetAdresse i on i.idHistoriqueAdresse = a.idHistoriqueAdresse
				WHERE i.idUtilisateur  = ".$this->userId."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$address[]=$fetch['nom'];
		}
		return $address;
	}


	/**
	 * Get the list of the person in the interest list if the user
	 *
	 * @return multitype: array of persons
	 */
	private function getPersonInterest(){
		$person = array();
		$requete ="
				SELECT p.idPersonne , p.nom ,p.prenom, i.idRue
				FROM personne p
				LEFT JOIN _interetRue i on i.idUtilisateur = p.idPersonne
				WHERE i.idUtilisateur  = ".$this->userId."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			$person[]=$fetch['nom']." " . $fetch['prenom'];
		}
		return $person;
	}



	/**
	 * Generate a form for selecting interest
	 *
	 * @param unknown $paramsForm : parameters of the form
	 * @return html of the form to insert
	 */
	private function generateFormInterest($paramsForm){
		$html='';
		if(!isset($paramsForm)){
			$this->erreurs->ajouter("Erreur dans la génération du formulaire, aucuns paramètres n'as été spécifié");
			$this->erreurs->afficher();
			return null;
		}
		else{
			$t = new Template($this->getCheminPhysique().$this->cheminTemplates);
			$t->set_filenames(array('form'=>'interestForm.tpl'));
				
			$t->assign_vars(array(
					'idField' => $paramsForm['idField'],
					'nom' => $paramsForm['nom'],
					'submitValue' => $paramsForm['submitValue']
			));
				
			foreach ($paramsForm['option'] as $option){
				$t->assign_block_vars('option',array(
						'value'=>$option['value'],
						'title'=> $option['title']
				));
			}

			ob_start();
			$t->pparse('form');
			$html .= ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}


	/**
	 * Get all field to process  the select option (unused now)
	 *
	 * @param unknown $params :
	 * @return multitype:multitype:unknown  multitype:string Ambigous <>
	 */
	private function getAllField($params){
		$result = array();
		$requete = "
				SELECT *
				FROM ".$params['table']."
						";
		$res = $this->connexionBdd->requete($requete);
		while ($fetch = mysql_fetch_assoc($res)) {
			if($params['table'] !='personne'){
				$temp = array('value'=>$fetch[$params['value']] , 'title' =>$fetch[$params['title']]);
				$result[]=$temp;
			}
			else{
				$result[]=array('value'=>$fetch[$params['value']] , 'title' =>$fetch['nom'] . " ". $fetch['prenom']);
			}
		}
		return $result;
	}


	/**
	 * Get all the interest of current user
	 *
	 * @param unknown $params : array with tables name
	 * @return multitype:multitype:unknown  multitype:string Ambigous <> array('value'=> res , 'title' => res)
	 */
	private function getAllInterest($arrayParams = array()){
		foreach ($arrayParams as $params){
			$subArray = array();
			if($params['associateTable'] != "efefhistoriqueAdresse"){
				$requete = "
						SELECT t.idUtilisateur,at.idHistoriqueAdresse,t.created, at.idAdresse ,at.idVille,at.idPays,at.date,at.nom,at.description,at.numero,at.idIndicatif,at.latitude,at.longitude,at.coordonneesVerrouillees
						FROM _interetAdresse t
						LEFT JOIN historiqueAdresse at on at.idHistoriqueAdresse= t.idHistoriqueAdresse
						WHERE t.idUtilisateur = ".$this->userId."
						";
				$requete = "
						SELECT *
						FROM ".$params['table']." t
						LEFT JOIN ".$params['associateTable']." at on at.".$params['field']."= t.".$params['field']."
						WHERE t.idUtilisateur = ".$this->userId."
						";
			}
			else{
							$requete = "
						SELECT *
						FROM ".$params['table']." t
						LEFT JOIN ".$params['associateTable']." at on at.".$params['field']."= t.".$params['field']."
						WHERE t.idUtilisateur = ".$this->userId."
						";				
			}
			$res = $this->connexionBdd->requete($requete);
			if(mysql_num_rows($res)==0){
				$titre='';
				if($params['associateTable']=='sousQuartier'){
					$titre = 'sous quartier';
				}
				elseif($params['associateTable']=='historiqueAdresse'){
					$titre ='adresse' ;
				}
				else{
					$titre=$params['associateTable'] ;
				}
				//Ajout de "s" si plusieurs resultats
				if($params['associateTable']!='pays'){
					$titre.="s";
				}
				$subArray=array(array_merge(array('vide'=>true,'titre'=>$titre),$params));
				
			}
			while ($fetch = mysql_fetch_assoc($res)) {
				$temp = array_merge($fetch,$params);
				if($temp['associateTable']=='sousQuartier'){
					$temp = array_merge($temp,array('titre' =>'sous quartier' ));
				}
				elseif($temp['associateTable']=='historiqueAdresse'){
					$temp = array_merge($temp,array('titre' =>'adresse' ));
										
				}
				else{
					$temp = array_merge($temp,array('titre' =>$temp['associateTable'] ));
				}
				
				//Ajout de "s" si plusieurs resultats
				if($temp['associateTable']!='pays'){
					$temp['titre'].="s";
				}
				$associateCity = $this->getCityName($temp[$temp['field']], $temp['associateTable']);
				if($associateCity && $associateCity!=''){
					$nom = $temp['nom']. ' ('.$associateCity.')';
					$temp['nom']=$nom;
				}
				$subArray[]=$temp;
			}
			if(!empty($subArray)){
				$result[] = $subArray;
			}
		}
		return $result;
	}
	
	
	/**
	 * Get the city name with an id and a type of input 
	 * 
	 * Type must be 'rue' , 'sousQuartier' or 'quartier'
	 * otherwise it wille return false
	 * 
	 * @param unknown $id if the table
	 * @param unknown $type of the table
	 * @return false or the street name
	 */
	private function getCityName($id,$type){
		switch($type){
			case 'quartier':
				$requete = "
						SELECT v.nom
						FROM ville v
						LEFT JOIN quartier q on q.idVille = v.idVille
						WHERE q.idQuartier = $id 
						";
				break;
			case 'sousQuartier':
				$requete = "
						SELECT v.nom
						FROM ville v
						LEFT JOIN quartier q on q.idVille = v.idVille
						LEFT JOIN sousQuartier sq on sq.idQuartier = q.idQuartier
						WHERE sq.idSousQuartier = $id
						";
				break;
			case 'rue':
				$requete = "
						SELECT v.nom
						FROM ville v
						LEFT JOIN quartier q on q.idVille = v.idVille
						LEFT JOIN sousQuartier sq on sq.idQuartier = q.idQuartier
						LEFT JOIN rue r on r.idSousQuartier = sq.idSousQuartier
						WHERE r.idRue = $id
						";
				break;
			default:
				return false;
		}
		$result = $this->connexionBdd->requete($requete);
		$row = mysql_fetch_assoc($result);
		return $row['nom'];
	}
}
?>
