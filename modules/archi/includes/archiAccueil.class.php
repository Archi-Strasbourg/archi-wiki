<?php
/**
 * Classe ArchiAccueil
 *
 * PHP Version 5.3.3
 *
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 *
 * */

/**
 * Affiche la page d'accueil
 *
 * PHP Version 5.3.3
 *
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 *
 * */
class ArchiAccueil extends ArchiConfig
{

	/**
	 * Constructeur d'ArchiAccueil
	 *
	 * @return void
	 * */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Affichage de la page d'accueil
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	function afficheAccueil($params=array())
	{
		$t = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$t->set_filenames(array('accueil'=>'accueil.tpl'));
		$html = '';
		$infos = "";

		$calque = new calqueObject();
		$date = new dateObject();
		$auth = new archiAuthentification();

		
		
		if ($auth->estConnecte()) {
			$t->assign_block_vars('estConnecte', array());
		}

		$t->assign_vars(
				array(
						'urlAjoutAdresse'=>$this->creerUrl('', 'ajoutNouveauDossier')
				)
		);

		$adresses = new archiAdresse();

		if (isset($this->variablesGet['modeAffichage']) && $this->variablesGet['modeAffichage']!='') {
			$modeAffichage = $this->variablesGet['modeAffichage'];
		} else {
			$modeAffichage = '';
		}

		switch($modeAffichage) {
			// **********************************************************************************************************************************
			// PROFIL
			// **********************************************************************************************************************************
			case 'profil':

				$t->assign_block_vars('afficheProfil', array());

				$t->assign_vars(
						array(
								'onglet1'=>"<a href='".$this->creerUrl('', 'afficheAccueil', array('modeAffichage'=>''))."'><font color='#FFFFFF'>"._("Nouveautés")."</font></a>",
								'onglet2'=>_("Mon Profil"),
								'onglet3'=>"<a href='".$this->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'monArchi'))."'><font color='#FFFFFF'>"._("Mon Archi")."</font></a>"
						)
				);


				$u = new archiUtilisateur();
				$s = new objetSession();

				if ($s->isInSession('utilisateurConnecte'.$this->idSite)) {
					$profil = $u->afficher(array(), $s->getFromSession('utilisateurConnecte'.$this->idSite), 'utilisateurProfil');
				} else {
					//header('Location: ?archiAffichage=authentification&archiActionPrecedente=afficheProfil');
					$authentification = new ArchiAuthentification();
					echo $authentification->afficheFormulaireAuthentification();
				}


				$t->assign_vars(array('htmlProfil'=>$profil));
				break;
				//Mon Archi
			case 'monArchi':

				$t->assign_block_vars('afficheMonArchi', array());

				$t->assign_vars(
						array(
								'onglet1'=>"<a href='".$this->creerUrl('', 'afficheAccueil', array('modeAffichage'=>''))."'><font color='#FFFFFF'>"._("Nouveautés")."</font></a>",
								'onglet2'=>"<a href='".$this->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'profil'))."'><font color='#FFFFFF'>"._("Mon Profil")."</font></a>",
								'onglet3'=>_("Mon Archi")
						)
				);

				$utilisateur = new archiUtilisateur();
				$adresse = new archiAdresse();


				$arrayInfosConnexions = $utilisateur->getInfosConnexions($auth->getIdUtilisateur());

				$arrayInfosModifs = $utilisateur->getInfosModifsPerso($auth->getIdUtilisateur());

				$monArchi="<table border=''><tr><td width=500><h2>"._("Mon Archi")."</h2></td></tr></table>";
				if (mysql_fetch_assoc($this->connexionBdd->requete("SELECT idImage FROM historiqueImage WHERE idUtilisateur = '".$auth->getIdUtilisateur()."' AND licence = '3'"))) {
					$monArchi.= "<strong>"._("Certaines de vos images ne sont pas librement réutilisables !")."</strong>";
					$monArchi.="<br/>";
					$monArchi.=_("Cliquez")." <a href='".$this->creerUrl("",  "batchLicence")."'>"._("ici")."</a> "._("pour les publier sous licence libre.");
					$monArchi.="<br/><br/>";
				}
				$monArchi.="<div style='font-size:12px;'>
						<b>"._("En tant qu'utilisateur vous pouvez :")."</b><ul>
						<li> <a href='".$this->creerUrl('', 'ajoutNouveauDossier')."' onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("En ajoutant votre adresse vous contribuez au développement du site. Mais d\'abord qu\'entend t-on par \"votre adresse\" ? Et bien cela peut être l\'immeuble ou la maison que vous occupez. Un immeuble que vous aimez mais que vous ne trouvez pas sur le site. Avec le développement des appareils photo numériques,  il devient très simple de prendre une photo,  et de la copier sur l\'ordinateur. Ajouter une adresse dans www.archi-strasbourg.org ne prend pas plus de 20 secondes. Copier la photo 10 secondes de plus..."))."\" onmouseout='".$calque->getJSContextHelpOnMouseOut()."'>"._("ajouter des adresses")."</a></li>
						<li> <span onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("Vous pouvez ajouter des photos afin d'illustrer une adresse."))."\" onmouseout=\"".$calque->getJSContextHelpOnMouseOut()."\"> "._("ajouter des photos à une adresse")."</span></li>
						<li> <span onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("Vous pouvez ajouter des évènements sur toute adresse qu'un autre utilisateur a créée."))."\" onmouseout=\"".$calque->getJSContextHelpOnMouseOut()."\">"._("ajouter des évènements à une adresse")."</span></li>
						<li> <span onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("En activant votre alerte mail sur les adresses,  vous serez prevenu de toute modification sur une adresse dont vous êtes l'auteur"))."\" onmouseout=\"".$calque->getJSContextHelpOnMouseOut()."\">"._("être prévenu par mail d'une modification de vos participations")."</span></li>
						<li> <span onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("En acceptant de recevoir les mails concernant les nouvelles adresses,  vous serez prévenu de l'ajout d'une nouvelle adresse sur le site."))."\" onmouseout=\"".$calque->getJSContextHelpOnMouseOut()."\">"._("être averti des nouvelles adresses")."</span></li>
						<li> <span onmouseover=\"".$calque->getJsContextHelpOnMouseOver(_("Grâce à l'alerte par mail sur les commentaires,  vous pouvez débattre avec les autres utilisateurs."))."\" onmouseout=\"".$calque->getJSContextHelpOnMouseOut()."\">"._("être averti des nouveaux commentaires ajoutés sur une adresse que vous avez créée.")."</span></li></ul>";
				$monArchi.="<b>"._("Vos statistiques :")."</b><br>";
				$monArchi.=""._("Vous vous êtes connecté :")." ".$arrayInfosConnexions['nbConnexions']." fois<br>";
				$monArchi.="&nbsp;&nbsp;&nbsp;"._("Date de votre dernière connexion :")." ".$this->date->toFrench($arrayInfosConnexions['derniereConnexion'])."<br>";

				$monArchi.="<p>
						&nbsp;&nbsp;&nbsp;"._("Nombre d'images modifiées :")." ".$arrayInfosModifs['nbModifImage']."<br />
						&nbsp;&nbsp;&nbsp;"._("Nombre d'images ajoutées :")." ".$arrayInfosModifs['nbAjoutImage']."<br />
						&nbsp;&nbsp;&nbsp;"._("Nombre d'évènements modifiés :")." ".$arrayInfosModifs['nbModifEvenement']."<br />
						&nbsp;&nbsp;&nbsp;"._("Nombre d'évènements ajoutés :")." ".$arrayInfosModifs['nbAjoutEvenement']."</p>";
				// ******************************************************************************************************************************************
				// liste des evenements ajoutés ou modifiés par l'utilisateur
				// ******************************************************************************************************************************************
				$paginationEvenements = new paginationObject();

				// calcul du nombre d'evenements ajoutes ou modifies pour la pagination
				$req = "
						SELECT distinct ha1.idAdresse, he1.dateCreationEvenement as dateCreationEvenement

						FROM evenements he2,  evenements he1
						LEFT JOIN _evenementEvenement ee1 ON ee1.idEvenementAssocie = he1.idEvenement
						LEFT JOIN _adresseEvenement ae ON ae.idEvenement = ee1.idEvenement
						LEFT JOIN historiqueAdresse ha1 ON ha1.idAdresse = ae.idAdresse
						LEFT JOIN historiqueAdresse ha2 ON ha2.idAdresse = ha1.idAdresse

						WHERE he2.idEvenement = he1.idEvenement
						AND he1.idUtilisateur = '".$auth->getIdUtilisateur()."'
								GROUP BY he1.idEvenement,  ha1.idAdresse,  ha1.idHistoriqueAdresse
								HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
								";
				$res = $this->connexionBdd->requete($req);

				//$fetchNbEvenements = mysql_fetch_assoc($res);

				$nbEnregistrementTotaux = mysql_num_rows($res);


				$nbEnregistrementsParPage=5;

				$arrayPaginationEvenements=$paginationEvenements->pagination(
						array(
								'nomParamPageCourante'=>'archiMonArchiEvenementPage',
								'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
								'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
								'typeLiens'=>'noformulaire'
						)
				);



				$req = "
						SELECT distinct ha1.idAdresse as idAdresse, he1.dateCreationEvenement as dateCreationEvenement,  ha1.numero,  ha1.idRue,  ha1.idSousQuartier,  ha1.idQuartier,  ha1.idVille, ha1.idIndicatif,

						ha1.idAdresse as idAdresse,  ha1.numero,  ha1.idQuartier,  ha1.idVille, ind.nom,

						r.nom as nomRue,
						sq.nom as nomSousQuartier,
						q.nom as nomQuartier,
						v.nom as nomVille,
						p.nom as nomPays,
						ha1.numero as numeroAdresse,
						ha1.idRue,
						r.prefixe as prefixeRue,
						IF (ha1.idSousQuartier != 0,  ha1.idSousQuartier,  r.idSousQuartier) AS idSousQuartier,
						IF (ha1.idQuartier != 0,  ha1.idQuartier,  sq.idQuartier) AS idQuartier,
						IF (ha1.idVille != 0,  ha1.idVille,  q.idVille) AS idVille,
						IF (ha1.idPays != 0,  ha1.idPays,  v.idPays) AS idPays,

						ha1.numero as numero,
						ha1.idHistoriqueAdresse,
						ha1.idIndicatif as idIndicatif


						FROM evenements he2,  evenements he1
						LEFT JOIN _evenementEvenement ee1 ON ee1.idEvenementAssocie = he1.idEvenement
						LEFT JOIN _adresseEvenement ae ON ae.idEvenement = ee1.idEvenement
						LEFT JOIN historiqueAdresse ha1 ON ha1.idAdresse = ae.idAdresse
						LEFT JOIN historiqueAdresse ha2 ON ha2.idAdresse = ha1.idAdresse

						LEFT JOIN indicatif ind ON ind.idIndicatif = ha1.idIndicatif

						LEFT JOIN rue r         ON r.idRue = ha1.idRue
						LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = if (ha1.idRue='0' and ha1.idSousQuartier!='0' , ha1.idSousQuartier , r.idSousQuartier )
						LEFT JOIN quartier q        ON q.idQuartier = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier!='0' , ha1.idQuartier , sq.idQuartier )
						LEFT JOIN ville v        ON v.idVille = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille!='0' , ha1.idVille , q.idVille )
						LEFT JOIN pays p        ON p.idPays = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille='0' and ha1.idPays!='0' , ha1.idPays , v.idPays )


						WHERE he2.idEvenement = he1.idEvenement
						AND he1.idUtilisateur = '".$auth->getIdUtilisateur()."'
								GROUP BY he1.idEvenement,  ha1.idAdresse,  ha1.idHistoriqueAdresse
								HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
								ORDER BY he1.dateCreationEvenement DESC

								";

				$req = $paginationEvenements->addLimitToQuery($req);

				$res = $this->connexionBdd->requete($req);
				$monArchi.="<b>"._("Liste de vos derniers évènements créés :")."</b><br>";
				$monArchi.=$arrayPaginationEvenements['html'];
				$tableauEvenements = new tableau();
				if (mysql_num_rows($res)==0) {
					$monArchi.="<br>"._("Vous n'avez pas encore ajouté d'évènement.")."<br>";
				}
				while ($fetch = mysql_fetch_assoc($res)) {
					$tableauEvenements->addValue($date->toFrench($fetch['dateCreationEvenement']));
					$tableauEvenements->addValue("<a href='".$this->creerUrl('', 'adresseDetail', array('archiIdAdresse'=>$fetch['idAdresse']))."'>".stripslashes($adresse->getIntituleAdresse($fetch))."</a>");
				}

				$monArchi.= $tableauEvenements->createHtmlTableFromArray(2, "font-size:12px;");

				// ******************************************************************************************************************************************
				// liste des adresses ajoutés par l'utilisateur
				// ******************************************************************************************************************************************
				$paginationAdresses = new paginationObject();

				$nbEnregistrementsParPage=5;

				$req = "
						SELECT distinct ha1.idAdresse
						FROM historiqueAdresse ha2,  historiqueAdresse ha1
						LEFT JOIN indicatif ind ON ind.idIndicatif = ha1.idIndicatif
						WHERE ha2.idAdresse = ha1.idAdresse
						AND ha1.idUtilisateur = '".$auth->getIdUtilisateur()."'
								GROUP BY ha1.idAdresse ,  ha1.idHistoriqueAdresse
								HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
								ORDER BY ha1.date DESC
								";

				$res = $this->connexionBdd->requete($req);
				$nbEnregistrementTotaux=mysql_num_rows($res);
				$arrayPaginationAdresses=$paginationAdresses->pagination(
						array(
								'nomParamPageCourante'=>'archiMonArchiAdressesPage',
								'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
								'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
								'typeLiens'=>'noformulaire'
						)
				);

				$req = "
						SELECT distinct ha1.idAdresse as idAdresse, ha1.date as date,  ha1.numero,  ha1.idRue,  ha1.idSousQuartier,  ha1.idQuartier,  ha1.idVille, ha1.idIndicatif,

						ha1.idAdresse as idAdresse,  ha1.numero,  ha1.idQuartier,  ha1.idVille, ind.nom,

						r.nom as nomRue,
						sq.nom as nomSousQuartier,
						q.nom as nomQuartier,
						v.nom as nomVille,
						p.nom as nomPays,
						ha1.numero as numeroAdresse,
						ha1.idRue,
						r.prefixe as prefixeRue,
						IF (ha1.idSousQuartier != 0,  ha1.idSousQuartier,  r.idSousQuartier) AS idSousQuartier,
						IF (ha1.idQuartier != 0,  ha1.idQuartier,  sq.idQuartier) AS idQuartier,
						IF (ha1.idVille != 0,  ha1.idVille,  q.idVille) AS idVille,
						IF (ha1.idPays != 0,  ha1.idPays,  v.idPays) AS idPays,

						ha1.numero as numero,
						ha1.idHistoriqueAdresse,
						ha1.idIndicatif as idIndicatif


						FROM historiqueAdresse ha2,  historiqueAdresse ha1

						LEFT JOIN indicatif ind ON ind.idIndicatif = ha1.idIndicatif

						LEFT JOIN rue r         ON r.idRue = ha1.idRue
						LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = if (ha1.idRue='0' and ha1.idSousQuartier!='0' , ha1.idSousQuartier , r.idSousQuartier )
						LEFT JOIN quartier q        ON q.idQuartier = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier!='0' , ha1.idQuartier , sq.idQuartier )
						LEFT JOIN ville v        ON v.idVille = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille!='0' , ha1.idVille , q.idVille )
						LEFT JOIN pays p        ON p.idPays = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille='0' and ha1.idPays!='0' , ha1.idPays , v.idPays )
						WHERE ha2.idAdresse = ha1.idAdresse
						AND ha1.idUtilisateur = '".$auth->getIdUtilisateur()."'
								GROUP BY ha1.idAdresse ,  ha1.idHistoriqueAdresse
								HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
								ORDER BY ha1.date DESC
								";
				$req = $paginationAdresses->addLimitToQuery($req);

				$res = $this->connexionBdd->requete($req);
				$monArchi.="<br><b>"._("Liste de vos adresses :")." </b><br>";
				$monArchi.=$arrayPaginationAdresses['html'];
				$tableauAdresse = new tableau();

				if (mysql_num_rows($res)==0) {
					$monArchi.="<br>"._("Vous n'avez pas encore ajouté d'adresse.")."<br>";
				}

				while ($fetch = mysql_fetch_assoc($res)) {
					$tableauAdresse->addValue($date->toFrench($fetch['date']));
					$tableauAdresse->addValue("<a href='".$this->creerUrl('', 'adresseDetail', array('archiIdAdresse'=>$fetch['idAdresse']))."'>".stripslashes($adresse->getIntituleAdresse($fetch))."</a>");
				}

				$monArchi.=$tableauAdresse->createHtmlTableFromArray(2, "font-size:12px;");

				// ******************************************************************************************************************************************
				// liste des adresses ou l'utilisateur a ajouté un commentaire
				// ******************************************************************************************************************************************
				$paginationCommentaires = new paginationObject();
				$nbEnregistrementsParPage=5;
				$req = "

						SELECT c.idCommentaire
						FROM commentaires c
						LEFT JOIN _adresseEvenement ae ON ae.idEvenement = c.idEvenementGroupeAdresse
						LEFT JOIN historiqueAdresse ha1 ON ha1.idAdresse = ae.idAdresse
						LEFT JOIN historiqueAdresse ha2 ON ha2.idAdresse = ha1.idAdresse
						WHERE c.idUtilisateur = '".$auth->getIdUtilisateur()."' OR c.email='".$utilisateur->getMailUtilisateur($auth->getIdUtilisateur())."'
								AND CommentaireValide=1
								GROUP BY ha1.idAdresse,  ha1.idHistoriqueAdresse
								HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
								ORDER BY c.date DESC
								";
				$res = $this->connexionBdd->requete($req);
				$nbEnregistrementTotaux=mysql_num_rows($res);
				$arrayPaginationCommentaires=$paginationCommentaires->pagination(
						array(
								'nomParamPageCourante'=>'archiMonArchiAdressesPage',
								'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
								'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
								'typeLiens'=>'noformulaire'
						)
				);

				$req = "

						SELECT distinct ha1.idAdresse as idAdresse, c.date as dateCommentaire, ha1.date as date,  ha1.numero,  ha1.idRue,  ha1.idSousQuartier,  ha1.idQuartier,  ha1.idVille, ha1.idIndicatif,

						ha1.idAdresse as idAdresse,  ha1.numero,  ha1.idQuartier,  ha1.idVille, ind.nom,

						r.nom as nomRue,
						sq.nom as nomSousQuartier,
						q.nom as nomQuartier,
						v.nom as nomVille,
						p.nom as nomPays,
						ha1.numero as numeroAdresse,
						ha1.idRue,
						r.prefixe as prefixeRue,
						IF (ha1.idSousQuartier != 0,  ha1.idSousQuartier,  r.idSousQuartier) AS idSousQuartier,
						IF (ha1.idQuartier != 0,  ha1.idQuartier,  sq.idQuartier) AS idQuartier,
						IF (ha1.idVille != 0,  ha1.idVille,  q.idVille) AS idVille,
						IF (ha1.idPays != 0,  ha1.idPays,  v.idPays) AS idPays,

						ha1.numero as numero,
						ha1.idHistoriqueAdresse,
						ha1.idIndicatif as idIndicatif

						FROM commentaires c
						LEFT JOIN _adresseEvenement ae ON ae.idEvenement = c.idEvenementGroupeAdresse
						LEFT JOIN historiqueAdresse ha1 ON ha1.idAdresse = ae.idAdresse
						LEFT JOIN historiqueAdresse ha2 ON ha2.idAdresse = ha1.idAdresse

						LEFT JOIN indicatif ind ON ind.idIndicatif = ha1.idIndicatif

						LEFT JOIN rue r         ON r.idRue = ha1.idRue
						LEFT JOIN sousQuartier sq    ON sq.idSousQuartier = if (ha1.idRue='0' and ha1.idSousQuartier!='0' , ha1.idSousQuartier , r.idSousQuartier )
						LEFT JOIN quartier q        ON q.idQuartier = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier!='0' , ha1.idQuartier , sq.idQuartier )
						LEFT JOIN ville v        ON v.idVille = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille!='0' , ha1.idVille , q.idVille )
						LEFT JOIN pays p        ON p.idPays = if (ha1.idRue='0' and ha1.idSousQuartier='0' and ha1.idQuartier='0' and ha1.idVille='0' and ha1.idPays!='0' , ha1.idPays , v.idPays )

						WHERE c.idUtilisateur = '".$auth->getIdUtilisateur()."' OR c.email='".$utilisateur->getMailUtilisateur($auth->getIdUtilisateur())."'
						AND CommentaireValide=1
						GROUP BY ha1.idAdresse,  ha1.idHistoriqueAdresse
						HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
						ORDER BY c.date DESC
								";

				$req = $paginationCommentaires->addLimitToQuery($req);

				$res = $this->connexionBdd->requete($req);
				$monArchi.="<br><b>"._("Liste de vos derniers commentaires :")." </b><br>";
				$monArchi.=$arrayPaginationCommentaires['html'];
				$tableauCommentaires = new tableau();

				if (mysql_num_rows($res)==0) {
					$monArchi.="<br>"._("Vous n'avez pas encore ajouté de commentaire.")."<br>";
				}

				while ($fetch = mysql_fetch_assoc($res)) {
					$tableauCommentaires->addValue($date->toFrench($fetch['dateCommentaire']));
					$tableauCommentaires->addValue("<a href='".$this->creerUrl('', 'adresseDetail', array('archiIdAdresse'=>$fetch['idAdresse']))."'>".stripslashes($adresse->getIntituleAdresse($fetch))."</a>");
				}

				$monArchi.=$tableauCommentaires->createHtmlTableFromArray(2, "font-size:12px;");
				
				
				$monArchi.="<a href=".$this->creerUrl('', 'mesInterets', array()).">Afficher mes interets </a>";

			
				$t->assign_vars(array('htmlMonArchi'=>$monArchi));
				$t->assign_vars(array('calqueHelp'=>$calque->getHtmlDivContextualHelp()));

				break;
				// **********************************************************************************************************************************
				// ACCUEIL
				// **********************************************************************************************************************************
			default:
				$params=array();
				$s = new objetSession();
				if (isset($this->variablesGet['archiIdVilleGeneral']) && $this->variablesGet['archiIdVilleGeneral']!=0 && $this->variablesGet['archiIdVilleGeneral']!='') {
					$params['idVille'] = $this->variablesGet['archiIdVilleGeneral'];
					$s->addToSession('archiIdVilleGeneral', $params['idVille']);
				} elseif ($s->isInSession('archiIdVilleGeneral') && $s->getFromSession('archiIdVilleGeneral')) {
					$params['idVille'] = $s->getFromSession('archiIdVilleGeneral');
					$s->addToSession('archiIdVilleGeneral', $params['idVille']);
				}
				if (isset($this->variablesGet['archiNomVilleGeneral'])
				&& $this->variablesGet['archiNomVilleGeneral']!=''
						) {
					$a = new archiAdresse();

					$params['idVille'] = $a->getIdVilleFromNomVille($this->variablesGet['archiNomVilleGeneral']);

					$_GET['archiIdVilleGeneral'] = $params['idVille'];

					// on place la ville general dans la session ,  ca simplifiera pas mal de choses

					$s->addToSession('archiIdVilleGeneral', $params['idVille']);

				}

				$news = $this->getLatestNewsInfo(1);
					
				//Simple templates
				$t->set_filenames(array('news' => 'accueil/news.tpl'));
				$t->set_filenames(array('derniereModfis' => 'accueil/lastmodifs.tpl'));
				$t->set_filenames(array('commentaire' => 'accueil/commentaire.tpl'));
				$t->set_filenames(array('favoris' => 'accueil/favoris.tpl'));
				$t->set_filenames(array('lastVisit' => 'accueil/lastVisit.tpl'));


				$news['titreCategory'] = 'Actualité de l\'association';
				$news['urlNewsList'] = $this->creerUrl('', 'toutesLesActualites', array());
				$t->assign_block_vars('newsAccueil', $news);
					

				//Gestion pour les commentaires
				$latestComments = $this->getLatestComments(2);
				$t->assign_vars(array(
						'commentaireSectionTitle'=>_("COMMENTAIRES RÉCENTS"),
						'urlListCommentaire' => $this->creerUrl('','tousLesCommentaires')
				));

				foreach ($latestComments as $com){
					$e = new archiEvenement();
					$commentaire = array(
							'date'=> $com['date'],
							'nom' =>  $com['nom'],
							'prenom' => $com['prenom'],
							'adresse' => $com['adresse'],
							'urlAdresse' => $com['urlAdresse'],
							'urlPersonne' => $com['urlPersonne'] ,
							'commentaire' => $com['commentaire']
					);
					$t->assign_block_vars('commentaire', $commentaire);
				}

				$lastModifs = $this->getLatestModification(8);
				foreach ( $lastModifs as $modif ) {
					if(isset($modif['idEvenement']) && $modif['idEvenement']){
						$idAdresse = $modif ['idAdresse'];
						$e = new archiEvenement ();
						$adresseArray = $e->getArrayAdresse ( $modif ['idEvenementGroupeAdresse'], 'idEvenementGroupeAdresse' );
						// Adresse
						$adresse = '';
						$adresse = $e->getAddressText ( $adresseArray );
						$infoImage = array ();
						// Image
						$a = new archiAdresse ();
						
						$reqImageEvtRelated = "				
							SELECT hi.idHistoriqueImage,hi.dateUpload,1 as priorite
							FROM historiqueImage hi
							LEFT JOIN _evenementImage ei on ei.idImage = hi.idImage
							WHERE ei.idEvenement = " . $modif ['idEvenement'] . "
					
									UNION
									
							SELECT hi.idHistoriqueImage,hi.dateUpload,2 as priorite
							FROM `evenements` evt
							LEFT JOIN _evenementEvenement ee ON ee.idEvenementAssocie = evt.idEvenement
							LEFT JOIN evenements evt2 ON evt2.idEvenement = ee.idEvenement
							LEFT JOIN historiqueImage hi on hi.idImage = evt2.idImagePrincipale
							LEFT JOIN _evenementImage ei ON ei.idImage = hi.idImage
							WHERE ee.idEvenement IS NOT NULL
							AND evt.idEvenement IS NOT NULL
							AND evt.idEvenement != 0
							AND ei.idEvenement =" . $modif ['idEvenement'] . "
							AND ee.idEvenement =" . $modif ['idEvenementGroupeAdresse'] . "
							
							ORDER BY priorite DESC
							LIMIT 1
							";
						$resImageEvtRelated = $this->connexionBdd->requete ( $reqImageEvtRelated );
						$arrayImage = mysql_fetch_assoc ( $resImageEvtRelated );
						if (isset ( $arrayImage ) && $arrayImage != '') {
							$infoImage = $arrayImage;
						} else {
							$reqImagePrincipale = "
						
							SELECT hi.idHistoriqueImage,hi.dateUpload
							FROM historiqueImage hi
							LEFT JOIN evenements evt on evt.idImagePrincipale = hi.idImage
							WHERE evt.idEvenement =" . $modif ['idEvenementGroupeAdresse'] . "
							LIMIT 1
							";
							$resImagePrincipale = $this->connexionBdd->requete ( $reqImagePrincipale );
							if (mysql_num_rows ( $reqImagePrincipale ) >= 1) {
								$infoImage = mysql_fetch_assoc ( $resImagePrincipale );
							} else {
								
								$reqOtherImage = "SELECT hi.idHistoriqueImage,hi.dateUpload
							FROM historiqueImage hi
							LEFT JOIN _evenementImage ei ON ei.idImage = hi.idImage
							LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = ei.idEvenement
							WHERE ee.idEvenement IS NOT NULL
							AND ee.idEvenement =" . $modif ['idEvenementGroupeAdresse'] . "
							
							LIMIT 1
							";
								$resOtherImage = $this->connexionBdd->requete ( $reqOtherImage );
								if (mysql_num_rows ( $resOtherImage ) >= 1) {
									$infoImage = mysql_fetch_assoc ( $resOtherImage );
								}
							}
						}
						$urlImage = "";
						$urlEvenement = "";
						// Url Evenement
						$idEvenementGroupeAdresses = $e->getIdGroupeEvenement ( $modif ['idEvenement'] );
						if ($modif ['type'] == 'adresse') {
							$urlEvenement = $this->creerUrl ( '', '', array (
									'archiAffichage' => 'adresseDetail',
									'archiIdAdresse' => $idAdresse,
									'archiIdEvenementGroupeAdresse' => $idEvenementGroupeAdresses 
							) );
							// $urlImage = "resizeImage.php?id=".$infoImage['idHistoriqueImage']."&height=200&width=200";
							
							if (isset ( $infoImage ['dateUpload'] ) && isset ( $infoImage ['idHistoriqueImage'] ) && $infoImage ['idHistoriqueImage'] != '' && $infoImage ['dateUpload'] != '') {
								$urlImage = "images/grand/" . $infoImage ['dateUpload'] . "/" . $infoImage ['idHistoriqueImage'] . ".jpg";
							} else {
								$urlImage = "images/placeholder.jpg";
							}
						} else {
							$urlEvenement = $this->creerUrl ( '', '', array (
									'archiAffichage' => 'evenementListe',
									'selection' => "personne",
									'id' => $modif ['idPersonne'] 
							) );
							$urlImage = ArchiPersonne::getImage ( $modif ['idPersonne'], 'resized' );
						}
						
						// Description
						$so = new StringObject ();
						$bbcode = new bbCodeObject ();
						$description = $bbcode->stripBBCode ( $modif ['description'] );
						$description = $so->truncateStringToWord ( $description, 130, ' ', '...' );
						
						$t->assign_block_vars ( 'lastModif', array (
								'miniatureLabelLeft' => $modif ['typeEvenement'],
								'miniatureLabelRight' => $modif ['dateCreationEvenement'],
								'adresse' => ucfirst ( $adresse ),
								'ville' => ucfirst ( $adresseArray [0] ['nomVille'] ),
								'urlMiniature' => $urlImage,
								'urlEvenement' => $urlEvenement,
								'description' => $description,
								'titre' => $modif ['titre'] 
						) );
					}
					else{
						
					}
				}

				 

				//Gestion des dernieres visites
				$t->assign_vars(array('lastVisitTitle' => _("Dernières visites")));
				$lastVisitArray=$_SESSION['lastVisited'];
				if(empty($lastVisitArray)){
					$visite = array('content' => _("Vous n'avez visité aucune adresse pour le moment"));
					$t->assign_block_vars('lastVisitMessage', $visite);
				}
				else{
					foreach ($lastVisitArray as $lastVisit){
						$titre="";
						if($lastVisit['idAdresse'] != '' && $lastVisit['idEvenementGroupeAdresse']!=''){
							$idAdresse = $lastVisit['idAdresse'];
							$e = new archiEvenement();
							$adresseArray = $e->getArrayAdresse($lastVisit['idEvenementGroupeAdresse'], 'idEvenementGroupeAdresse');

							//Adresse
							$adresse = '';
							$adresse = $e->getAddressText($adresseArray);

							//Image
							$requeteImage = "
									SELECT hi.idHistoriqueImage ,hi.dateUpload, e.idEvenement
									FROM historiqueImage hi
									LEFT JOIN evenements e on e.idImagePrincipale = hi.idImage
									WHERE e.idEvenement = ".$lastVisit['idEvenementGroupeAdresse']."
									AND e.idImagePrincipale !=0 
									";
							$resultImage = $this->connexionBdd->requete($requeteImage);
							$array_image = mysql_fetch_assoc($resultImage);
							
								
							$a = new archiAdresse();
							if($array_image['idHistoriqueImage']==0 || !isset($array_image['idHistoriqueImage']) || $array_image['idHistoriqueImage']==''){
								$infoImage = $a->getUrlImageFromAdresse($idAdresse,'moyen');
								$image = new archiImage();
								$resImage = $image->getImagesEvenementsFromAdresse($idAdresse,  $lastVisit);
								$infoImage = mysql_fetch_assoc($resImage);
							}
							else{
								$infoImage=$array_image;
							}

							if(isset($infoImage['dateUpload']) && isset($infoImage['idHistoriqueImage'])&& $infoImage['idHistoriqueImage'] !='' && $infoImage['dateUpload'] !=''){
								$urlImage = "images/grand/".$infoImage['dateUpload']."/".$infoImage['idHistoriqueImage'].".jpg";
							}
							else{
								$urlImage="images/placeholder.jpg";
							}
								
							
							//Url Evenement
							$idEvenementGroupeAdresses = $lastVisit['idEvenementGroupeAdresse'];
							$urlEvenement = $this->creerUrl('', '', array('archiAffichage'=>'adresseDetail','archiIdAdresse'=>$idAdresse,'archiIdEvenementGroupeAdresse'=>$idEvenementGroupeAdresses));
								
								// Description
							$requeteDescription = "
									
									SELECT evt.description
									FROM evenements evt
									LEFT JOIN _evenementEvenement ee ON ee.idEvenementAssocie = evt.idEvenement
									LEFT JOIN positionsEvenements pe ON pe.idEvenementGroupeAdresse = ee.idEvenement
									WHERE ee.idEvenement =" . $lastVisit ['idEvenementGroupeAdresse'] . "
									ORDER BY pe.position
											";
							$resDescription = $this->connexionBdd->requete ( $requeteDescription );
							$arrayDescription = mysql_fetch_assoc($resDescription);
							$so = new StringObject();
							
							$description = $so->sansBalises($arrayDescription['description']);
							$description = stripslashes($description);
							$description = $so->truncateStringToWord($description, 80,' ','...');

							if(isset($lastVisit) && !empty($lastVisit) && isset($lastVisit['idEvenementGroupeAdresse'] )&& !empty($lastVisit['idEvenementGroupeAdresse']) && isset($lastVisit['idAdresse']) && !empty($lastVisit['idAdresse'])){
								//Titre
								$resTitre = $e->getIdEvenementTitre($lastVisit);
								$requeteTitre = "
										SELECT evt.titre
										FROM evenements evt
										WHERE evt.idEvenement = ".$resTitre."
												";
								$resTitre = $this->connexionBdd->requete($requeteTitre);
								$titreArray = mysql_fetch_array($resTitre);
								if($titreArray['titre'] != ''){
									//$titre = $adresse;
									$titre = $titreArray['titre'];
										
								}
								else{
								}
							}

							$visite = array(
									'adresse' => $adresse,
									'urlMiniature' => $urlImage,
									'urlEvenement' => $urlEvenement,
									'description' => $description,
									'titre' => $titre
							);
							$t->assign_block_vars('lastVisit', $visite);
						}
					}
				}


				$t->assign_vars(array(
						'lastModifTitle' => _("Dernières modifications"),
						'urlCustomNewsFeed'=>$this->creerUrl('', 'mesInterets', array())
				));


				//Associate template to the general template
				$t->assign_var_from_handle('news', 'news');
				$t->assign_var_from_handle('dernieresModifs', 'derniereModfis');
				$t->assign_var_from_handle('commentaires', 'commentaire');
				$t->assign_var_from_handle('lastVisits', 'lastVisit');
				
				break;
				

		}

		ob_start();
		$t->pparse('accueil');
		$html .= ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * Affiche les encarts a partir du tableau contenant
	 * les differentes informations necessaire,
	 * adresses par encart,  indice des adresses comportant des images
	 * et idHistoriqueImage + dateUpload de l'image
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function getEncarts($params = array())
	{
		$html = "";

		// ************************************************************
		//
		$tDemolitions = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tDemolitions->set_filenames(array('encartDemolitions'=>'encartAccueil.tpl'));
		$adresse = new archiAdresse();
		$evenement = new archiEvenement();
		$string = new stringObject();
		$image = new archiImage();
		$session = new objetSession();
		$bbCode = new bbCodeObject();
		$d = new dateObject();


		$archiIdPaysGeneral = array('archiIdPaysGeneral'=>1);
		$arrayIdVilleGeneral = array('archiIdVilleGeneral'=>1); // strasbourg par defaut
		if (isset($this->variablesGet['archiIdVilleGeneral']) && $this->variablesGet['archiIdVilleGeneral']!='' && isset($this->variablesGet['archiIdPaysGeneral']) && $this->variablesGet['archiIdPaysGeneral']!='') {
			$arrayIdVilleGeneral = array('archiIdVilleGeneral'=>$this->variablesGet['archiIdVilleGeneral']);
			$archiIdPaysGeneral = array('archiIdPaysGeneral'=>$this->variablesGet['archiIdPaysGeneral']);
		} elseif ($session->isInSession("archiIdVilleGeneral")) {
			$arrayIdVilleGeneral = array('archiIdVilleGeneral'=>$session->getFromSession("archiIdVilleGeneral"));
			$arrayInfosVille = $adresse->getInfosVille($session->getFromSession("archiIdVilleGeneral"), array("fieldList"=>"v.idPays as idPays"));
			$archiIdPaysGeneral = array('archiIdPaysGeneral'=>$arrayInfosVille['idPays']);
		}


		$format = "moyen";

		$tDemolitions->assign_vars(array('titre'=>_("Dernières démolitions"), "type"=>"demolitions"));



		if (count($params['demolitions'])>0) {
			$tDemolitions->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'toutesLesDemolitions', array_merge($arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Toutes les démolitions")."</a>"));
		} else {
			// il n'y a pas de demolitions,  on va donc envoyer l'affichage par defaut
			$tDemolitions->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'ajoutNouveauDossier', array_merge(array("archiOptionAjoutDossier"=>"nouvelleDemolition"), $arrayIdVilleGeneral, $archiIdPaysGeneral))."'>Ajouter une démolition</a>"));
			$tDemolitions->assign_block_vars("premiereAdresseAvecPhoto", array());
			$tDemolitions->assign_vars(
					array(
							'photoAdresse1'=>"",
							'descriptionAdresse1'=>"<div>"._("Il n'y a pas encore de démolitions pour cette localité")."</div>"
					)
			);

		}

		foreach ($params['demolitions'] as $indice => $value) {
			$intituleAdresse = $adresse->getIntituleAdresseAccueil($value, array('ifTitreAfficheTitreSeulement'=>true));
			$intituleAdresseAlt=strip_tags(str_replace("\"", "'", $intituleAdresse));
			if (isset($params['indiceEvenementsPremierePositions']['demolition']) && $indice == $params['indiceEvenementsPremierePositions']['demolition']) {
				$urlImage = $this->getUrlRacine().'resizeImage.php?id='.$params['imagesEvenementsPremieresPositions']['demolition']['idHistoriqueImage'];

				$tDemolitions->assign_block_vars("premiereAdresseAvecPhoto", array());

				$tDemolitions->assign_vars(
						array(
								'photoAdresse1'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."'><img style='margin-right:2px;float:left;' src='".$urlImage."' alt=\"".$intituleAdresseAlt."\" title=\"".$intituleAdresseAlt."\"></a>",
								'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($evenement->getDescription($value['idEvenement']), 20))))."</div>"
						)
				);
			} else {
				$tDemolitions->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'><span class='date'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).'</span> '.$intituleAdresse."</a>"));
			}
		}


		ob_start();
		$tDemolitions->pparse('encartDemolitions');
		$htmlDemolitions = ob_get_contents();
		ob_end_clean();


		// ************************************************************
		//
		$tTravaux = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tTravaux->set_filenames(array('encartTravaux'=>'encartAccueil.tpl'));

		$tTravaux->assign_vars(array('titre'=>_("Derniers travaux"), "type"=>"constructions"));

		if (count($params['constructions'])>0) {
			$tTravaux->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'tousLesTravaux', array_merge($arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Tous les travaux")."</a>"));
		} else {
			$tTravaux->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'ajoutNouveauDossier', array_merge(array("archiOptionAjoutDossier"=>"nouveauxTravaux"), $arrayIdVilleGeneral, $archiIdPaysGeneral))."'>Ajouter des travaux</a>"));
			$tTravaux->assign_block_vars("premiereAdresseAvecPhoto", array());
			$tTravaux->assign_vars(
					array(
							'photoAdresse1'=>"",
							'descriptionAdresse1'=>"<div>"._("Il n'y a pas encore de travaux pour cette localité")."</div>"
					)
			);

		}
		foreach ($params['constructions'] as $indice => $value) {
			$intituleAdresse = $adresse->getIntituleAdresseAccueil($value, array('ifTitreAfficheTitreSeulement'=>true));
			$intituleAdresseAlt=strip_tags(str_replace("\"", "'", $intituleAdresse));
			if (isset($params['indiceEvenementsPremierePositions']['construction']) && $indice == $params['indiceEvenementsPremierePositions']['construction']) {
				$urlImage = $this->getUrlRacine().'resizeImage.php?id='.$params['imagesEvenementsPremieresPositions']['construction']['idHistoriqueImage'];

				$tTravaux->assign_block_vars("premiereAdresseAvecPhoto", array());

				$tTravaux->assign_vars(
						array(
								'photoAdresse1'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."'><img style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' alt='".$intituleAdresseAlt."' title=\"".$intituleAdresseAlt."\"></a>",
								'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($evenement->getDescription($value['idEvenement']), 20))))."</div>"
						)
				);
			} else {
				$tTravaux->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'><span class='date'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).'</span> '.$intituleAdresse."</a>"));
			}
		}
		ob_start();
		$tTravaux->pparse('encartTravaux');
		$htmlTravaux = ob_get_contents();
		ob_end_clean();

		// ************************************************************
		//
		$tCulturel = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tCulturel->set_filenames(array('encartCulturel'=>'encartAccueil.tpl'));

		$tCulturel->assign_vars(array('titre'=>_("Derniers évènements culturels"), "type"=>"culture"));

		if (count($params['culture'])>0) {
			$tCulturel->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'tousLesEvenementsCulturels', array_merge($arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Tous les évènements culturels")."</a>"));
		} else {
			$tCulturel->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'ajoutNouveauDossier', array_merge(array("archiOptionAjoutDossier"=>"nouvelEvenementCulturel"), $arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Ajouter un évènement culturel")."</a>"));

			$tCulturel->assign_block_vars("premiereAdresseAvecPhoto", array());
			$tCulturel->assign_vars(
					array(
							'photoAdresse1'=>"",
							'descriptionAdresse1'=>"<div>"._("Il n'y a pas encore d'évènements culturels pour cette localité")."</div>"
					)
			);


		}

		foreach ($params['culture'] as $indice => $value) {
			$intituleAdresse = $adresse->getIntituleAdresseAccueil($value, array('ifTitreAfficheTitreSeulement'=>true));
			$intituleAdresseAlt=strip_tags(str_replace("\"", "'", $intituleAdresse));
			if (isset($params['indiceEvenementsPremierePositions']['culturel']) && $indice == $params['indiceEvenementsPremierePositions']['culturel']) {

				$urlImage = $this->getUrlRacine().'resizeImageuare.php?id='.$params['imagesEvenementsPremieresPositions']['culturel']['idHistoriqueImage'];

				$tCulturel->assign_block_vars("premiereAdresseAvecPhoto", array());

				$tCulturel->assign_vars(
						array(
								'photoAdresse1'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."'><img style='border:1px #000000 solid;margin-right:2px;float:left;'  src='".$urlImage."' alt='".$intituleAdresseAlt."' title='".$intituleAdresseAlt."'></a>",
								'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($evenement->getDescription($value['idEvenement']), 20))))."</div>"
						)
				);
			} else {
				$tCulturel->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."#".$value['positionEvenement']."' style='font-size:12px;'><span class='date'>".date('d/m/Y', strtotime($value['dateCreationEvenement'])).'</span> '.$intituleAdresse."</a>"));
			}
		}

		ob_start();
		$tCulturel->pparse('encartCulturel');
		$htmlCulturel = ob_get_contents();
		ob_end_clean();

		// ************************************************************
		//
		$tDernieresAdresses = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tDernieresAdresses->set_filenames(array('encartDernieresAdresses'=>'encartAccueil.tpl'));

		$tDernieresAdresses->assign_vars(array('titre'=>_("Nouvelles adresses"), "type"=>"dernieresAdresses"));

		if (count($params['dernieresAdresses'])>0) {
			$tDernieresAdresses->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'recherche', array_merge(array('motcle'=>'', 'submit'=>'Rechercher'), $arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Toutes les adresses")."</a>"));
		} else {
			// il n'y a pas de "dernieres adresses" affichées ,  on envoi donc l'affichage par defaut
			$tDernieresAdresses->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'ajoutNouveauDossier', array_merge($arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Ajouter une adresse")."</a>"));

			$tDernieresAdresses->assign_block_vars("premiereAdresseAvecPhoto", array());
			$tDernieresAdresses->assign_vars(
					array(
							'photoAdresse1'=>"",
							'descriptionAdresse1'=>"<div>"._("Il n'y a pas encore de nouvelles adresses pour cette localité")."</div>"
					)
			);
		}

		foreach ($params['dernieresAdresses'] as $indice => $value) {
			$intituleAdresse = $adresse->getIntituleAdresseAccueil($value, array('ifTitreAfficheTitreSeulement'=>true));
			$intituleAdresseAlt = strip_tags(str_replace("\"", "'", $intituleAdresse));
			if (isset($params['indiceEvenementsPremierePositions']['dernieresAdresses']) && $indice == $params['indiceEvenementsPremierePositions']['dernieresAdresses']) {

				$urlImage = $this->getUrlRacine().'resizeImage.php?id='.$params['imagesEvenementsPremieresPositions']['dernieresAdresses']['idHistoriqueImage'];

				$tDernieresAdresses->assign_block_vars("premiereAdresseAvecPhoto", array());
				if ($params['imagesEvenementsPremieresPositions']['dernieresAdresses']['idHistoriqueImage']!='') {
					$tDernieresAdresses->assign_vars(
							array(
									'photoAdresse1'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."'><img style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' alt='".$intituleAdresseAlt."' title='".$intituleAdresseAlt."'></a>",
									'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($value['description'], 20))))."</div>"
							)
					);
				} else {
					$tDernieresAdresses->assign_vars(
							array(
									'photoAdresse1'=>"",
									'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($value['description'],  20))))."</div>"
							)
					);

				}
			} else {
				$tDernieresAdresses->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'><span class='date'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).'</span> '.$intituleAdresse."</a>"));
			}
		}


		ob_start();
		$tDernieresAdresses->pparse('encartDernieresAdresses');
		$htmlDerniersAdresses = ob_get_contents();
		ob_end_clean();

		// ************************************************************
		//
		$tDernieresVues = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tDernieresVues->set_filenames(array('encartDernieresVues'=>'encartAccueil.tpl'));

		$tDernieresVues->assign_vars(array('titre'=>_("Dernières vues"), "type"=>"dernieresVues"));

		if (count($params['dernieresVues'])>0) {
			$tDernieresVues->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'toutesLesVues', array())."'>"._("Toutes les vues")."</a>"));

			$i=0;
			foreach ($params['dernieresVues'] as $indice => $value) {
				$arrayIntituleAdressesVuesSur = array();
				foreach ($value['listeVueSur'] as $indice => $valueVuesSur) {
					$arrayIntituleAdressesVuesSur[] = $adresse->getIntituleAdresseFrom($valueVuesSur['idEvenementGroupeAdresse'], 'idEvenementGroupeAdresse', array('ifTitreAfficheTitreSeulement'=>true, 'noVille'=>true, 'noQuartier'=>true, 'noSousQuartier'=>true));
				}

				$arrayIntituleAdressesPrisDepuis = array();
				foreach ($value['listePrisDepuis'] as $indice => $valuePrisDepuis) {
					$arrayIntituleAdressesPrisDepuis[] = "<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', 'archiIdAdresse'=>$valuePrisDepuis['idAdresse'], 'archiIdEvenementGroupeAdresse'=>$valuePrisDepuis['idEvenementGroupeAdresse']))."'>".$adresse->getIntituleAdresseFrom($valuePrisDepuis['idEvenementGroupeAdresse'], 'idEvenementGroupeAdresse', array('ifTitreAfficheTitreSeulement'=>true, 'noVille'=>true, 'noQuartier'=>true, 'noSousQuartier'=>true))."</a>";
				}


				$intituleAdresse1Adresse = $adresse->getIntituleAdresseFrom($value['idEvenementGroupeAdresse'], 'idEvenementGroupeAdresse', array('noVille'=>true, 'noQuartier'=>true, 'noSousQuartier'=>true));
				$intituleAdresseAlt =  strip_tags(str_replace("\"", "'", $intituleAdresse1Adresse));



				$intituleAdresseVueSur = implode("/ ", $arrayIntituleAdressesVuesSur);
				$intituleAdressePrisDepuis = implode("", $arrayIntituleAdressesPrisDepuis);

				if ($i==0) {
					$urlImage = $this->getUrlRacine().'resizeImage.php?id='.$value['idHistoriqueImage'];
					$tDernieresVues->assign_block_vars("premiereAdresseAvecPhoto", array());
					$tDernieresVues->assign_vars(
							array(
									"photoAdresse1"=>"<a href='".$this->creerUrl('', 'imageDetail', array("archiIdImage"=>$value['idImage'], "archiRetourAffichage"=>'evenement', "archiRetourIdName"=>'idEvenement', "archiRetourIdValue"=>$value['idEvenementGroupeAdresse']))."'><img style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' title=\"".$intituleAdresseAlt."\" alt=\"".$intituleAdresseAlt."\"></a>",
									"descriptionAdresse1"=>"<a href='".$this->creerUrl('', 'imageDetail', array("archiIdImage"=>$value['idImage'], "archiRetourAffichage"=>'evenement', "archiRetourIdName"=>'idEvenement', "archiRetourIdValue"=>$value['idEvenementGroupeAdresse']))."'>".date('d/m/Y', strtotime($value['dateUpload']))." ".$intituleAdresseVueSur."</a><br>Pris depuis ".$intituleAdressePrisDepuis."<br>".$string->coupureTexte($bbCode->convertToDisplay(array('text'=>$image->getDescriptionFromIdImage(array("idImage"=>$value['idImage'])))), 5)
							)
					);
				} else {
					$tDernieresVues->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a style='font-size:12px;' href='".$this->creerUrl('', 'imageDetail', array("archiIdImage"=>$value['idImage'], "archiRetourAffichage"=>'evenement', "archiRetourIdName"=>'idEvenement', "archiRetourIdValue"=>$value['idEvenementGroupeAdresse']))."'><span class='date'>".date('d/m/Y', strtotime($value['dateUpload']))."</span> ".$intituleAdresseVueSur."</a>"));


				}
				$i++;
			}
		}


		ob_start();
		$tDernieresVues->pparse('encartDernieresVues');
		$htmlDernieresVues = ob_get_contents();
		ob_end_clean();





		$tActualites = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tActualites->set_filenames(array('encartActualites'=>'encartAccueil.tpl'));

		$tActualites->assign_vars(array('titre'=>_("Actualités"), "type"=>"actualites"));
		$i=0;

		if (count($params['actualites'])>0) {
			$tActualites->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'toutesLesActualites', array())."'>"._("Toutes les actualités")."</a>"));
		}


		// s'il y a un parcours plus récent que la derniere actu ,  on affiche le parcours comme une actualité ( ...je sais mais bon ,  va comprendre....)

		$reqDateDerniereActualite = "SELECT max(date) as maxDate FROM actualites WHERE desactive<>'1'";
		$resDateDerniereActualite = $this->connexionBdd->requete($reqDateDerniereActualite);


		$indiceGlobalNbActu = 0;
		$isParcoursToDisplay = false; // est ce que l'on va afficher un parcours plutot qu'une actu en place principale sur l'encars des actus
		if (mysql_num_rows($resDateDerniereActualite)>0) {


			$fetchDateDerniereActualite = mysql_fetch_assoc($resDateDerniereActualite);
			$dateActu = $fetchDateDerniereActualite['maxDate'];
			// voyons maintenant s'il y a un parcours ajouté actif plus recent
			$reqParcoursActif = "SELECT idParcours,  dateAjoutParcours, libelleParcours, commentaireParcours FROM parcoursArt WHERE dateAjoutParcours>'".$dateActu."' AND isActif='1' ORDER BY dateAjoutParcours DESC,  idParcours DESC LIMIT 1";
			$resParcoursActif = $this->connexionBdd->requete($reqParcoursActif);

			if (mysql_num_rows($resParcoursActif)>0) {
				$isParcoursToDisplay = true;
				$fetchParcoursActif = mysql_fetch_assoc($resParcoursActif);

				// recuperation d'une photo appartenant a une adresse du parcours (en principe dans le meilleur des cas la premiere photo de la premiere etape)

				$reqEtapes = "SELECT idEtape, commentaireEtape FROM etapesParcoursArt WHERE idParcours = '".$fetchParcoursActif['idParcours']."'";
				$resEtapes = $this->connexionBdd->requete($reqEtapes);
				if (mysql_num_rows($resEtapes)>0) {
					$trouvePhoto = false;

					while (!$trouvePhoto && $fetchEtape = mysql_fetch_assoc($resEtapes)) {
						$arrayPhoto = $adresse->getPhotoFromEtape(array('idEtape'=>$fetchEtape['idEtape'], 'format'=>'moyen'));
						$trouvePhoto = $arrayPhoto['trouve'];
					}

					mysql_data_seek($resEtapes, 0);

					$commentaire = "";
					if ($fetchParcoursActif['commentaireParcours']!='') {
						$bbCode = new bbCodeObject();
						$trouveCommentaire = true;
						$commentaire = $bbCode->convertToDisplay(array('text'=>$fetchParcoursActif['commentaireParcours']));
					} else {
						$trouveCommentaire = false;
					}

					while (!$trouveCommentaire && $fetchEtape = mysql_fetch_assoc($resEtapes)) {
						if ($fetchEtape['commentaireEtape']!='') {
							$trouveCommentaire = true;
							$commentaire = $fetchEtape['commentaireEtape'];
						}
					}


					if ($trouvePhoto) {
						$s = new stringObject();

						// si une photo pour le dernier parcours a ete trouvee ,  alors on affiche le parcours en actu principale
						$i=1; // pour que la boucle des actus commence a 1 et ne remplace pas l'actu principale
						$indiceGlobalNbActu = 1; // pour que l'on affiche pas la derniere actu ramenee par la fonction sinon il y en aurait une de plus que dans les autres encars


						$urlImage = $arrayPhoto['url'];

						$url = $this->creerUrl('', 'detailParcours', array('archiIdParcours'=>$fetchParcoursActif['idParcours']));


						$dimensionImage = "";

						$tActualites->assign_block_vars("premiereAdresseAvecPhoto", array());
						$tActualites->assign_vars(
								array(
										"photoAdresse1"=>"<a href='".$url."'><img alt='' style='border:1px #000000 solid;margin-right:2px;float:left;'  src='".$urlImage."' $dimensionImage ></a>",
										"descriptionAdresse1"=>"<a href='".$url."'>".$d->toFrenchAffichage($fetchParcoursActif['dateAjoutParcours'])." ".stripslashes($fetchParcoursActif['libelleParcours'])."</a><br>".$s->coupureTexte($s->sansBalisesHtml(stripslashes($commentaire)), 10)."<br>".mysql_num_rows($resEtapes)." étapes... <a href='".$url."' style='font-size:11px;'>lire la suite</a>"
								)
						);

					}


				}

			}


		}



		foreach ($params['actualites'] as $indice => $value) {
			if ($indiceGlobalNbActu<5) {
				if ($i==0) {
					// premiere actualite
					@list($w, $h) = getimagesize($this->getCheminPhysique()."images/actualites/".$value['idActualite']."/".$value['photoIllustration']);

					if ($w>$h) {
						$dimensionImage = "width=130";    // modif par fabien pour que l'image soit au même format que les autres rubriques (01/02/2013)
					} else {
						$dimensionImage = "height=130";
					}

					$urlImage = $this->getUrlRacine()."images/actualites/".$value['idActualite']."/".$value['photoIllustration'];

					if ($value['urlFichier']!='')
						$url = $value['urlFichier'];
					else
						$url = $this->creerUrl('', 'afficherActualite', array('archiIdActualite'=>$value['idActualite']));

					$tActualites->assign_block_vars("premiereAdresseAvecPhoto", array());
					$tActualites->assign_vars(
							array(
									"photoAdresse1"=>"<a href='".$url."'><img alt='' style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' $dimensionImage></a>",
									"descriptionAdresse1"=>"<a href='".$url."'>".$d->toFrenchAffichage($value['date'])." ".stripslashes($value['titre'])."</a><br>".stripslashes($string->coupureTexte($string->sansBalisesHtml($value['texte']), 20))." <a href='".$url."' style='font-size:11px;'>lire la suite</a>"
							)
					);

				} else {
					if ($value['urlFichier']!='')
						$url = $value['urlFichier'];
					else
						$url = $this->creerUrl('', 'afficherActualite', array('archiIdActualite'=>$value['idActualite']));

					// by fabien le 23/03/2012 : ajout de stripslashes pour virer les \ sur la page d'acceuil

					$tActualites->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a style='font-size:12px;' href='".$url."'><span class='date'>".$d->toFrenchAffichage($value['date'])."</span> ".stripslashes($value['titre'])."</a>"));
				}

				$i++;
			}
			$indiceGlobalNbActu++;
		}

		ob_start();
		$tActualites->pparse('encartActualites');
		$htmlActualites = ob_get_contents();
		ob_end_clean();



		return array('demolitions'=>$htmlDemolitions, 'travaux'=>$htmlTravaux, 'culturel'=>$htmlCulturel, 'dernieresAdresses'=>$htmlDerniersAdresses, 'dernieresVues'=>$htmlDernieresVues, 'actualites'=>$htmlActualites);
	}




	/**
	 * Get the HTML for the last addresses added encarts
	 *
	 *
	 * @param unknown $params
	 * @return string html of the last added addresses
	 */
	public function getDernieresAdresses($params = array()){
		$tDernieresAdresses = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tDernieresAdresses->set_filenames(array('encartDernieresAdresses'=>'encartAccueil.tpl'));
		 
		$tDernieresAdresses->assign_vars(array('titre'=>_("Nouvelles adresses"), "type"=>"dernieresAdresses"));
		 
		if (count($params['dernieresAdresses'])>0) {
			$tDernieresAdresses->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'recherche', array_merge(array('motcle'=>'', 'submit'=>'Rechercher'), $arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Toutes les adresses")."</a>"));
		} else {
			// il n'y a pas de "dernieres adresses" affichées ,  on envoi donc l'affichage par defaut
			$tDernieresAdresses->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'ajoutNouveauDossier', array_merge($arrayIdVilleGeneral, $archiIdPaysGeneral))."'>"._("Ajouter une adresse")."</a>"));
				
			$tDernieresAdresses->assign_block_vars("premiereAdresseAvecPhoto", array());
			$tDernieresAdresses->assign_vars(
					array(
							'photoAdresse1'=>"",
							'descriptionAdresse1'=>"<div>"._("Il n'y a pas encore de nouvelles adresses pour cette localité")."</div>"
					)
			);
		}
		 
		foreach ($params['dernieresAdresses'] as $indice => $value) {
			$intituleAdresse = $adresse->getIntituleAdresseAccueil($value, array('ifTitreAfficheTitreSeulement'=>true));
			$intituleAdresseAlt = strip_tags(str_replace("\"", "'", $intituleAdresse));
			if (isset($params['indiceEvenementsPremierePositions']['dernieresAdresses']) && $indice == $params['indiceEvenementsPremierePositions']['dernieresAdresses']) {
				 
				$urlImage = $this->getUrlRacine().'resizeImage.php?id='.$params['imagesEvenementsPremieresPositions']['dernieresAdresses']['idHistoriqueImage'];
				 
				$tDernieresAdresses->assign_block_vars("premiereAdresseAvecPhoto", array());
				if ($params['imagesEvenementsPremieresPositions']['dernieresAdresses']['idHistoriqueImage']!='') {
					$tDernieresAdresses->assign_vars(
							array(
									'photoAdresse1'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."'><img style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' alt='".$intituleAdresseAlt."' title='".$intituleAdresseAlt."'></a>",
									'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($value['description'], 20))))."</div>"
							)
					);
				}
				else {
					$tDernieresAdresses->assign_vars(
							array(
									'photoAdresse1'=>"",
									'descriptionAdresse1'=>"<div><a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).' '.$intituleAdresse."</a><br>".($string->sansBalises(stripslashes($string->coupureTexte($value['description'],  20))))."</div>"
							)
					);
						
				}
			}
			else {
				$tDernieresAdresses->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a href='".$this->creerUrl('', '', array('archiAffichage'=>'adresseDetail', "archiIdAdresse"=>$value['idAdresse'], "archiIdEvenementGroupeAdresse"=>$value['idEvenementGroupeAdresse']))."' style='font-size:12px;'><span class='date'>".date('d/m/Y', strtotime($value['dateCreationAdresse'])).'</span> '.$intituleAdresse."</a>"));
			}
		}
		ob_start();
		$tDernieresAdresses->pparse('encartDernieresAdresses');
		$htmlDerniersAdresses = ob_get_contents();
		ob_end_clean();
		return $htmlDerniersAdresses;
	}




	/**
	 * Get the last news
	 * @param unknown $params
	 * @return string html of the last news encarts
	 */
	public function getActualites($params = array()){
		$tActualites = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$tActualites->set_filenames(array('encartActualites'=>'encartAccueil.tpl'));

		$tActualites->assign_vars(array('titre'=>_("Actualités"), "type"=>"actualites"));
		$i=0;

		if (count($params['actualites'])>0) {
			$tActualites->assign_vars(array('lienVersTout'=>"<a href='".$this->creerUrl('', 'toutesLesActualites', array())."'>"._("Toutes les actualités")."</a>"));
		}


		// s'il y a un parcours plus récent que la derniere actu ,  on affiche le parcours comme une actualité ( ...je sais mais bon ,  va comprendre....)
		$reqDateDerniereActualite = "SELECT max(date) as maxDate FROM actualites WHERE desactive<>'1'";
		$resDateDerniereActualite = $this->connexionBdd->requete($reqDateDerniereActualite);

		$indiceGlobalNbActu = 0;
		$isParcoursToDisplay = false; // est ce que l'on va afficher un parcours plutot qu'une actu en place principale sur l'encars des actus
		if (mysql_num_rows($resDateDerniereActualite)>0) {
				
				
			$fetchDateDerniereActualite = mysql_fetch_assoc($resDateDerniereActualite);
			$dateActu = $fetchDateDerniereActualite['maxDate'];
			// voyons maintenant s'il y a un parcours ajouté actif plus recent
			$reqParcoursActif = "SELECT idParcours,  dateAjoutParcours, libelleParcours, commentaireParcours FROM parcoursArt WHERE dateAjoutParcours>'".$dateActu."' AND isActif='1' ORDER BY dateAjoutParcours DESC,  idParcours DESC LIMIT 1";
			$resParcoursActif = $this->connexionBdd->requete($reqParcoursActif);
				
			if (mysql_num_rows($resParcoursActif)>0) {
				$isParcoursToDisplay = true;
				$fetchParcoursActif = mysql_fetch_assoc($resParcoursActif);

				// recuperation d'une photo appartenant a une adresse du parcours (en principe dans le meilleur des cas la premiere photo de la premiere etape)
				$reqEtapes = "SELECT idEtape, commentaireEtape FROM etapesParcoursArt WHERE idParcours = '".$fetchParcoursActif['idParcours']."'";
				$resEtapes = $this->connexionBdd->requete($reqEtapes);
				if (mysql_num_rows($resEtapes)>0) {
					$trouvePhoto = false;
						
					while (!$trouvePhoto && $fetchEtape = mysql_fetch_assoc($resEtapes)) {
						$arrayPhoto = $adresse->getPhotoFromEtape(array('idEtape'=>$fetchEtape['idEtape'], 'format'=>'moyen'));
						$trouvePhoto = $arrayPhoto['trouve'];
					}
						
					mysql_data_seek($resEtapes, 0);
						
					$commentaire = "";
					if ($fetchParcoursActif['commentaireParcours']!='') {
						$bbCode = new bbCodeObject();
						$trouveCommentaire = true;
						$commentaire = $bbCode->convertToDisplay(array('text'=>$fetchParcoursActif['commentaireParcours']));
					} else {
						$trouveCommentaire = false;
					}
						
					while (!$trouveCommentaire && $fetchEtape = mysql_fetch_assoc($resEtapes)) {
						if ($fetchEtape['commentaireEtape']!='') {
							$trouveCommentaire = true;
							$commentaire = $fetchEtape['commentaireEtape'];
						}
					}
						
						
					if ($trouvePhoto) {
						$s = new stringObject();

						// si une photo pour le dernier parcours a ete trouvee ,  alors on affiche le parcours en actu principale
						$i=1; // pour que la boucle des actus commence a 1 et ne remplace pas l'actu principale
						$indiceGlobalNbActu = 1; // pour que l'on affiche pas la derniere actu ramenee par la fonction sinon il y en aurait une de plus que dans les autres encars


						$urlImage = $arrayPhoto['url'];

						$url = $this->creerUrl('', 'detailParcours', array('archiIdParcours'=>$fetchParcoursActif['idParcours']));


						$dimensionImage = "";

						$tActualites->assign_block_vars("premiereAdresseAvecPhoto", array());
						$tActualites->assign_vars(
								array(
										"photoAdresse1"=>"<a href='".$url."'><img alt='' style='border:1px #000000 solid;margin-right:2px;float:left;'  src='".$urlImage."' $dimensionImage ></a>",
										"descriptionAdresse1"=>"<a href='".$url."'>".$d->toFrenchAffichage($fetchParcoursActif['dateAjoutParcours'])." ".stripslashes($fetchParcoursActif['libelleParcours'])."</a><br>".$s->coupureTexte($s->sansBalisesHtml(stripslashes($commentaire)), 10)."<br>".mysql_num_rows($resEtapes)." étapes... <a href='".$url."' style='font-size:11px;'>lire la suite</a>"
								)
						);

					}
				}
			}
		}



		foreach ($params['actualites'] as $indice => $value) {
			if ($indiceGlobalNbActu<5) {
				if ($i==0) {
					// premiere actualite
					@list($w, $h) = getimagesize($this->getCheminPhysique()."images/actualites/".$value['idActualite']."/".$value['photoIllustration']);
						
					if ($w>$h) {
						$dimensionImage = "width=130";    // modif par fabien pour que l'image soit au même format que les autres rubriques (01/02/2013)
					} else {
						$dimensionImage = "height=130";
					}
						
					$urlImage = $this->getUrlRacine()."images/actualites/".$value['idActualite']."/".$value['photoIllustration'];
						
					if ($value['urlFichier']!='')
						$url = $value['urlFichier'];
					else
						$url = $this->creerUrl('', 'afficherActualite', array('archiIdActualite'=>$value['idActualite']));
						
					$tActualites->assign_block_vars("premiereAdresseAvecPhoto", array());
					$tActualites->assign_vars(
							array(
									"photoAdresse1"=>"<a href='".$url."'><img alt='' style='border:1px #000000 solid;margin-right:2px;float:left;' src='".$urlImage."' $dimensionImage></a>",
									"descriptionAdresse1"=>"<a href='".$url."'>".$d->toFrenchAffichage($value['date'])." ".stripslashes($value['titre'])."</a><br>".stripslashes($string->coupureTexte($string->sansBalisesHtml($value['texte']), 20))." <a href='".$url."' style='font-size:11px;'>lire la suite</a>"
							)
					);
						
				} else {
					if ($value['urlFichier']!='')
						$url = $value['urlFichier'];
					else
						$url = $this->creerUrl('', 'afficherActualite', array('archiIdActualite'=>$value['idActualite']));
						
					// by fabien le 23/03/2012 : ajout de stripslashes pour virer les \ sur la page d'acceuil
						
					$tActualites->assign_block_vars('listeAdressesSuivantes', array('lien'=>"<a style='font-size:12px;' href='".$url."'><span class='date'>".$d->toFrenchAffichage($value['date'])."</span> ".stripslashes($value['titre'])."</a>"));
				}

				$i++;
			}
			$indiceGlobalNbActu++;
		}

		ob_start();
		$tActualites->pparse('encartActualites');
		$htmlActualites = ob_get_contents();
		ob_end_clean();
		return $htmlActualites;
	}


	/**
	 * Recupere la listes des architectes
	 * les plus productifs classée
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function getListeArchitectesProductifs($params=array())
	{
		$pagination = new paginationObject();
		$adresse = new archiAdresse();
		$nbEnregistrementsParPage=10;

		$sqlLimit="";

		$titre = "";
		if (isset($params['setTitre'])) {
			$titre = $params['setTitre']."<br><br>";
		}


		if (isset($params['sqlLimit'])) {
			$sqlLimit = $params['sqlLimit'];
		}
		$paginationHTML="";
		if (!isset($params['noPagination']) || $params['noPagination']==false) {
			$reqArchitectesCount = "
					SELECT  p.idPersonne, p.nom, p.prenom,  count(distinct ae.idAdresse) as nbAdresses
					FROM personne p
					LEFT JOIN personne p2 ON p2.idPersonne = p.idPersonne
					LEFT JOIN _evenementPersonne ep ON ep.idPersonne = p2.idPersonne
					LEFT JOIN _evenementEvenement ee ON ee.idEvenementAssocie = ep.idEvenement
					LEFT JOIN _adresseEvenement ae ON ae.idEvenement = ee.idEvenement
					WHERE ae.idAdresse IS NOT NULL
					GROUP BY p.idPersonne
					";

			$resArchitectesCount = $this->connexionBdd->requete($reqArchitectesCount);

			$arrayPagination=$pagination->pagination(
					array(
							'nomParamPageCourante'=>'archiPageCouranteArchitectes',
							'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
							'nbEnregistrementsTotaux'=>mysql_num_rows($resArchitectesCount),
							'typeLiens'=>'noformulaire'
					)
			);

			$sqlLimit = "LIMIT ".$arrayPagination['limitSqlDebut'].", ".$nbEnregistrementsParPage;
		}
		// liste des architectes
		$reqArchitectes = "
		SELECT  p.idPersonne, p.nom, p.prenom,  count(distinct ae.idAdresse) as nbAdresses
		FROM personne p
		LEFT JOIN personne p2 ON p2.idPersonne = p.idPersonne
		LEFT JOIN _evenementPersonne ep ON ep.idPersonne = p2.idPersonne
		LEFT JOIN _evenementEvenement ee ON ee.idEvenementAssocie = ep.idEvenement
		LEFT JOIN _adresseEvenement ae ON ae.idEvenement = ee.idEvenement
		WHERE ae.idAdresse IS NOT NULL
		GROUP BY p.idPersonne
		ORDER BY nbAdresses DESC
		$sqlLimit
		";

		$resArchitectes = $this->connexionBdd->requete($reqArchitectes);
		$tableau = new tableau();

		if (!isset($params['noPagination']) || $params['noPagination']==false) {
			$paginationHTML = $arrayPagination['html']."<br>";
		}


		while ($fetchArchitectes = mysql_fetch_assoc($resArchitectes)) {
			$tableau->addValue("<a href='".$this->creerUrl('', 'evenementListe', array('selection'=>'personne', 'id'=>$fetchArchitectes['idPersonne']))."'>".$fetchArchitectes['nom']." ".$fetchArchitectes['prenom']."</a>&nbsp;(".$fetchArchitectes['nbAdresses'].")");

			$tableau->addValue("<img src='".$adresse->getUrlImageFromPersonne($fetchArchitectes['idPersonne'], 'mini')."' alt=\"".$fetchArchitectes['nom']." ".$fetchArchitectes['prenom']."\" title=\"".$fetchArchitectes['nom']." ".$fetchArchitectes['prenom']."\" >");
		}

		return $titre.$paginationHTML.$tableau->createHtmlTableFromArray(2, "", "tableau");
	}

	/**
	 * Recupere la liste des rues les plus completes
	 * (ou il y a le plus d'adresses dans la rue) classée
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function getListeRuesCompletes($params=array())
	{
		$pagination = new paginationObject();
		$adresse = new archiAdresse();
		$nbEnregistrementsParPage=10;


		$paginationHTML="";

		$sqlLimit="";

		if (isset($params['sqlLimit'])) {
			$sqlLimit = $params['sqlLimit'];
		}

		$titre = "";
		if (isset($params['setTitre'])) {
			$titre = $params['setTitre']."<br><br>";
		}


		if (!isset($params['noPagination']) || $params['noPagination']==false) {
			$reqRuesCount="
					SELECT r.idRue,  count(distinct ae.idAdresse) as nbAdresses
					FROM rue r
					LEFT JOIN historiqueAdresse ha ON ha.idRue = r.idRue
					LEFT JOIN _adresseEvenement ae ON ae.idAdresse = ha.idAdresse
					WHERE ha.numero<>'0' and ha.numero<>'' AND ha.idAdresse IS NOT NULL
					GROUP BY r.idRue
					";

			$resRuesCount = $this->connexionBdd->requete($reqRuesCount);
			$nbEnregistrementTotaux = mysql_num_rows($resRuesCount);


			$arrayPagination=$pagination->pagination(
					array(
							'nomParamPageCourante'=>'archiPageCouranteRue',
							'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
							'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
							'typeLiens'=>'noformulaire'
					)
			);
			$sqlLimit = "LIMIT ".$arrayPagination['limitSqlDebut'].", ".$nbEnregistrementsParPage;
		}

		// liste des rues les plus completes
		$reqRues = "
		SELECT r.idRue,  count(distinct ae.idAdresse) as nbAdresses
		FROM rue r
		LEFT JOIN historiqueAdresse ha ON ha.idRue = r.idRue
		LEFT JOIN _adresseEvenement ae ON ae.idAdresse = ha.idAdresse
		WHERE ha.numero<>'0' AND ha.numero<>'' AND ha.idAdresse IS NOT NULL
		GROUP BY r.idRue
		ORDER BY nbAdresses DESC
		$sqlLimit
		";


		$resRues = $this->connexionBdd->requete($reqRues);

		if (!isset($params['noPagination']) || $params['noPagination']==false) {
			$paginationHTML = $arrayPagination['html']."<br>";
		}

		$tableau = new tableau();

		while ($fetchRues = mysql_fetch_assoc($resRues)) {
			$intituleRue = $adresse->getIntituleAdresseFrom($fetchRues['idRue'], 'idRue');
			$tableau->addValue("<a href='".$this->creerUrl('', 'listeAdressesFromRue', array('recherche_rue'=>$fetchRues['idRue'], 'noAdresseSansNumero'=>1))."'>".$intituleRue."</a>&nbsp;(".$fetchRues['nbAdresses'].")");

			$tableau->addValue("<img src='".$adresse->getUrlImageFromRue($fetchRues['idRue'], 'mini')."' alt=\"".$intituleRue."\" title=\"".$intituleRue."\" >");
		}

		return $titre.$paginationHTML.$tableau->createHtmlTableFromArray(2, "", "tableau");
	}


	/**
	 * Affichage de la page des statistiques quand on clique sur le lien au dessus des encarts sur la page d'accueil
	 *
	 * @return string HTML
	 * */
	public function afficheStatistiques()
	{
		$t = new Template($this->getCheminPhysique().$this->cheminTemplates);
		$t->set_filenames(array('statsAccueil'=>'statistiquesAccueil.tpl'));

		// recherche du nombre d'evenements
		$reqEvenements = "SELECT DISTINCT idEvenement as nbEvenements FROM evenements;";
		$resEvenements = $this->connexionBdd->requete($reqEvenements);

		// recherche du nombre d'adresses
		$reqAdresses = "SELECT DISTINCT idAdresse as nbAdresses FROM historiqueAdresse;";
		$resAdresses = $this->connexionBdd->requete($reqAdresses);

		// recherche du nombre de photos
		$reqPhotos = "SELECT DISTINCT idImage as nbImages FROM historiqueImage;";
		$resPhotos = $this->connexionBdd->requete($reqPhotos);

		$t->assign_vars(array('architectes'=>$this->getListeArchitectesProductifs(array('sqlLimit'=>"LIMIT 10", "noPagination"=>true))));
		$t->assign_vars(array('rues'=>$this->getListeRuesCompletes(array('sqlLimit'=>"LIMIT 10", "noPagination"=>true))));

		$t->assign_vars(array('voirTousLesArchitectes'=>"<a href='".$this->creerUrl('', 'tousLesArchitectesClasses')."'>"._("Voir tous les architectes classés")."</a>"));

		$t->assign_vars(array('voirToutesLesRues'=>"<a href='".$this->creerUrl('', 'toutesLesRuesCompletesClassees')."'>"._("Voir toutes les rues classées")."</a>"));

		$t->assign_vars(array('nbAdresses'=>mysql_num_rows($resAdresses)));
		$t->assign_vars(array('nbEvenements'=>mysql_num_rows($resEvenements)));
		$t->assign_vars(array('nbPhotos'=>mysql_num_rows($resPhotos)));

		ob_start();
		$t->pparse('statsAccueil');
		$html .= ob_get_contents();
		ob_end_clean();

		return $html;
	}


	/**
	 * Gestion d'un sondage
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function gestionSondage($params = array())
	{
		$t = new Template($this->getCheminPhysique().$this->cheminTemplates);

		if (isset($params['modeAffichage']) && $params['modeAffichage']=='resultatAccueil') {
			$t->set_filenames(array('sondage'=>'sondageRESULTAT.tpl'));
		} else {
			$t->set_filenames(array('sondage'=>'sondageTEMPORAIRE.tpl'));


			$c = new calqueObject();
			$t->assign_vars(
					array('jsScroll'=>$c->getJsScrollDivWithPage(
							array(
									'conditionsToScrollBegin'=>"if ((document.getElementById('texteSuite').style.display=='block' && y_<4650) || (document.getElementById('texteSuite').style.display=='none' && y_<100))",
									'identifiantDivToScroll'=>"divScroll"
							)
					))
			);

			// verification : est ce que la personne a deja participé aujourd'hui
			$ip = $_SERVER['REMOTE_ADDR'];
			if (trim($ip)=='') {
				// on assigne une ip temporaire,  soit un nombre aleatoire pour pouvoir comptabiliser le vote quand meme ,  on pourra toujours les supprimer si quelqu'un exagere
				$ip = rand(0, 1000000);
			}

			$reqVerif = "SELECT idResultat FROM sondagesResultats WHERE ip like '$ip' AND date=CURDATE()";
			$resVerif = $this->connexionBdd->requete($reqVerif);
			if ( isset($params['modeAffichage']) && $params['modeAffichage']=='noFormulaire' || mysql_num_rows($resVerif)>0) {
				$t->assign_block_vars('resultatsSondage', array('resultats'=>$this->afficheResumeSondage(array('idSondage'=>1))));
			} else {
				// nouvelle participation
				// recuperation des propositions
				$reqPropositions = "SELECT idProposition, libelleProposition FROM sondagesPropositions WHERE idSondage='1'";
				$resPropositions = $this->connexionBdd->requete($reqPropositions);
				$t->assign_block_vars('afficheFormSondage', array());
				while ($fetchPropositions = mysql_fetch_assoc($resPropositions)) {
					$t->assign_block_vars('afficheFormSondage.propositions', array('idProposition'=>$fetchPropositions['idProposition'], 'libelleProposition'=>$fetchPropositions['libelleProposition']));
				}


				$t->assign_vars(array('formAction'=>$this->creerUrl('enregistrerEntreeSondage', 'afficheAccueil')));

			}
		}

		if (isset($params['afficheToutLeTexte']) && $params['afficheToutLeTexte']==true) {
			$displaySuite = "block";
			$styleAccueil = "";
			$lienSuite = "";
		} else {
			$displaySuite = "none";
			$styleAccueil = "border:3px solid #000000;padding:5px;";
			if (isset($params['modeAffichage']) && $params['modeAffichage']=='resultatAccueil') {
				$lienSuite = "<a href='".$this->creerUrl('', 'afficheSondageResultatGrand')."'>"._("Lire la suite")."</a>";
			} else {
				$lienSuite = "<a href='".$this->creerUrl('', 'afficheSondageGrand')."'>"._("Lire la suite")."</a>";
			}
		}

		if (isset($params['modeAffichage']) && $params['modeAffichage']=='resultatAccueil') {

			$t->assign_vars(
					array(
							'pictoSrc'=>'',
							'displaySuite'=>$displaySuite,
							'lienSuite'=>$lienSuite,
							'styleAccueil'=>$styleAccueil,
							'urlIconePdf'=>$this->urlImages.'logo_pdf.jpg',
							'urlDocumentPdf'=>$this->urlImages.'publicite/avenirFinancementArchiStrasbourg.pdf',
							'resultats'=>$this->afficheResumeSondage(array('idSondage'=>1)),
							'urlArticlePresentation'=>$this->creerUrl('', 'afficheSondageGrand')
					)
			);
		} else {
			$t->assign_vars(
					array(
							'pictoSrc'=>$this->urlImages.'pictoSondage.jpg',
							'displaySuite'=>$displaySuite,
							'lienSuite'=>$lienSuite,
							'styleAccueil'=>$styleAccueil,
							'urlIconePdf'=>$this->urlImages.'logo_pdf.jpg',
							'urlDocumentPdf'=>$this->urlImages.'publicite/avenirFinancementArchiStrasbourg.pdf'
					)
			);
		}

		ob_start();
		$t->pparse('sondage');
		$html .= ob_get_contents();
		ob_end_clean();


		return $html;
	}

	/**
	 * Enregistre une entrée de sondage
	 *
	 * @return void
	 * */
	public function enregistreEntreeSondage()
	{
		if (isset($this->variablesPost['choixSondage']) && is_array($this->variablesPost['choixSondage'])) {
			if (count($this->variablesPost['choixSondage'])>0) {
				// on verifie que la personne n'a pas encore fait de proposition aujourd'hui
				$ip = $_SERVER['REMOTE_ADDR'];
				if ($ip!='') {
					$reqVerif = "SELECT idResultat FROM sondagesResultats WHERE ip like '$ip' AND date=CURDATE()";
					$resVerif = $this->connexionBdd->requete($reqVerif);
					if (mysql_num_rows($resVerif)>0) {
						echo "<br><span style='color:red;'>"._("Votre participation a déjà été enregistrée.")."</span><br>";
					} else {
						// enregistrement
						foreach ($this->variablesPost['choixSondage'] as $indice => $idProposition) {
							$reqInsert = "INSERT INTO sondagesResultats (idSondage, date, ip, idProposition) VALUES ('1', now(), '".$ip."', '".$idProposition."')";
							$resInsert = $this->connexionBdd->requete($reqInsert);
						}
					}
				} else {
					echo "<br><span style='color:red;'>"._("Votre vote n'a pas pu être enregistré.")."</span><br>";
				}
			} else {
				echo "<br><span style='color:red;'>"._("Vous n'avez selectionné aucune proposition.")."</span><br>";
			}
		}
	}

	/**
	 * Affichage du résumé d'un sondage
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function afficheResumeSondage($params = array())
	{
		$html="";
		if (isset($params['idSondage']) && $params['idSondage']!='') {
			// a deja participe
			// affichage des resultats
			$reqNbVotants = "SELECT DISTINCT ip FROM sondagesResultats WHERE idSondage='".$params['idSondage']."'";
			$resNbVotants = $this->connexionBdd->requete($reqNbVotants);
			$nbVotants = mysql_num_rows($resNbVotants);
			$html.="<table border=''  style='margin:0;padding:0;font-size:12px;'><tr><td style='margin:0;padding:0;'><h3>"._("Statistiques à ce jour")."</h3>"._("Nombre de participants :")." ".$nbVotants."</td></tr></table>";
			$reqCountParProposition = "
					SELECT p.idProposition, p.libelleProposition as libelleProposition, count(r.ip) as nbVotes
					FROM sondagesPropositions p
					LEFT JOIN sondagesResultats r ON r.idProposition = p.idProposition
					WHERE p.idSondage = '".$params['idSondage']."'
							GROUP BY p.idProposition, r.idProposition
							";

			$resCountParProposition = $this->connexionBdd->requete($reqCountParProposition);


			$reqCountVotes = "SELECT idResultat FROM sondagesResultats WHERE idSondage='1'";
			$resCountVotes = $this->connexionBdd->requete($reqCountVotes);
			$nbVotes = mysql_num_rows($resCountVotes);

			$tableau = new tableau();
			while ($fetchCountParProposition = mysql_fetch_assoc($resCountParProposition)) {
				$tableau->addValue($fetchCountParProposition['libelleProposition']."&nbsp;", "style='margin:0;padding:0;font-size:11px;'");
				$tableau->addValue(round($fetchCountParProposition['nbVotes']*100/$nbVotes)."%", "style='margin:0;padding:0;font-size:11px;'");
				$tableau->addValue("<table style='margin:0;padding:0; position:relative;' border=''><tr><td style='background-color:red; position:absolute; font-size:3px;width:".round($fetchCountParProposition['nbVotes']*100/$nbVotes)."%'>&nbsp;</td></tr></table>", "style='margin:0;padding:0;font-size:11px;'");
				$tableau->addValue("&nbsp;", "style='margin:0;padding:0;font-size:11px;'");
			}

			$html.=$tableau->createHtmlTableFromArray(2, 'margin:0;padding:0;', '', '', " border=''");
		}

		return $html;

	}


	/**
	 * Affichage du detail d'une actualite
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function getActualiteDetail($params = array())
	{
		$html = "";
		if (isset($this->variablesGet['archiIdActualite']) && $this->variablesGet['archiIdActualite']!='') {
			$req = "SELECT idActualite,  date, texte,  titre, sousTitre, urlFichier, fichierPdf FROM actualites WHERE idActualite='".$this->variablesGet['archiIdActualite']."'";
			$res = $this->connexionBdd->requete($req);
			if (mysql_num_rows($res)>0) {
				$fetch = mysql_fetch_assoc($res);

				$tab = new tableau();
				if ($fetch['fichierPdf']!='') {
					$tab->addValue("<div style='font-size:9px;'>"._("Pour un plus grand confort de lecture téléchargez la")." <a href='".$this->getUrlImage()."actualites/".$fetch['idActualite']."/".$fetch['fichierPdf']."' target='_blank'>"._("version PDF du texte.")."</a></div>");
				}
				$tab->addValue(stripslashes($fetch['titre']), "style='font-size:18px;font-weight:bold;'");
				$tab->addValue(stripslashes($fetch['sousTitre']), "style='font-size:14px;font-weight:bold;'");
				$html.=$tab->createHtmlTableFromArray(1, 'margin:0;padding:0;', '', '', " border=''");

				$html.="<br>";
				$html.=str_replace("###cheminImages###", $this->getUrlImage()."actualites/".$fetch['idActualite']."/", stripslashes($fetch['texte']));
			}
		}

		return $html;
	}

	/**
	 * Affichage de toutes les actualites
	 *
	 * @param array $params Paramètres
	 *
	 * @return string HTML
	 * */
	public function getHtmlToutesLesActualites($params = array())
	{
		$html = "<h1>"._("Actualités")."</h1>";

		$d = new dateObject();
		$pagination = new paginationObject();
		$resDernieresActualites = $this->getDernieresActualites(array('sqlFields'=>'0', "returnAsMysqlRes"=>true));
		$nbEnregistrementTotaux = mysql_num_rows($resDernieresActualites);


		$nbEnregistrementsParPage=15;

		$arrayPagination=$pagination->pagination(
				array(
						'nomParamPageCourante'=>'page',
						'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
						'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
						'typeLiens'=>'noformulaire'
				)
		);



		$arrayActus = $this->getDernieresActualites(array("sqlWhere"=>" AND desactive<>'1' ", "sqlLimit"=>"LIMIT ".mysql_real_escape_string($arrayPagination['limitSqlDebut']).", ".$nbEnregistrementsParPage));

		$tab = new tableau();

		foreach ($arrayActus as $indice => $value) {
			if ($value['urlFichier']!='') {
				$url = $value['urlFichier'];
			} else {
				$url = $this->creerUrl('', 'afficherActualite', array('archiIdActualite'=>$value['idActualite']));
			}

			$tab->addValue("<a href='".$url."'>".$d->toFrenchAffichage($value['date'])." ".stripslashes($value['titre'])."</a>");

			if ($value['photoIllustration']!='') {
				list($w, $h) = getimagesize(
						$this->getCheminPhysique()."images/actualites/".
						$value['idActualite']."/".$value['photoIllustration']
				);
				if ($w>$h) {
					$dimension = "width=80";
				} else {
					$dimension = "height=80";
				}

				$tab->addValue(
						"<img src='".$this->urlImages."actualites/".
						$value['idActualite']."/".
						$value['photoIllustration']."' $dimension>"
				);
			} else {
				$tab->addValue("&nbsp;");
			}
		}

		$html.=$arrayPagination['html'];
		$html.=$tab->createHtmlTableFromArray(
				2, 'margin:0;padding:0;', '', '', " border=''"
		);


		return $html;

	}


	/**
	 * Renvoi les dernieres actualites pour la page d'accueil
	 * sous forme de resultat mysql ou de tableau
	 *
	 * @param array $params Paramètres
	 *
	 * @return Resource
	 * */
	public function getDernieresActualites($params = array())
	{
		$sqlLimit = "";
		if (isset($params['sqlLimit']) && $params['sqlLimit']!='') {
			$sqlLimit = $params['sqlLimit'];

		}

		$sqlFields = "idActualite,  titre,  date,  ".
				"photoIllustration,  texte,  urlFichier";
		if (isset($params['sqlFields']) && $params['sqlFields']!='') {
			$sqlFields = $params['sqlFields'];
		}

		$sqlWhere = "";
		if (isset($params['sqlWhere']) && $params['sqlWhere']!='') {
			$sqlWhere = $params['sqlWhere'];
		}

		$req = "SELECT $sqlFields FROM actualites ".
				"WHERE 1=1 $sqlWhere ORDER BY date DESC $sqlLimit";
		$res = $this->connexionBdd->requete($req);

		$i=0;
		if (!isset($params['returnAsMysqlRes'])
		|| $params['returnAsMysqlRes']!=true
		) {
			$retour = array();
			while ($fetch = mysql_fetch_assoc($res)) {
				$retour[$i] = $fetch;
				$i++;
			}
		} else {
			$retour = $res;
		}

		return $retour;
	}






	public function getLatestNewsInfo($nbNews=1){
		$requete = '
				SELECT titre, sousTitre,date,photoIllustration,idActualite, texte
				FROM actualites
				WHERE desactive = 0
				ORDER BY idActualite DESC
				LIMIT '.$nbNews.'
						';
		 
		$result = $this->connexionBdd->requete($requete);
		$fetch = mysql_fetch_assoc($result);
		$url = 'images/actualites/'.$fetch['idActualite'].'/'.$fetch['photoIllustration'];
		$urlNews = 'actualites-archi-strasbourg-'.$fetch['idActualite'].'.html';
		$description = strip_tags($fetch['texte']);
		$so = new StringObject();
		$description = $so->sansBalises($description);
		$description = $so->truncateStringToWord($description,320,' ','...');
		
		
		$news=array(
				'urlMiniature'=>$url,
				'titre' => $fetch['titre'],
				'date' => $fetch['date'],
				'description' => $description,
				'urlNews' => $urlNews
		);
		return $news;
	}
	public function getLatestComments($nbComment){
		 
		
		
		$sousRequete1 = "SELECT
				date_format(c.date,"._('"%e/%m/%Y"').") as date,
						c.idUtilisateur,
						c.idEvenement,
						c.commentaire,
						c.nom,
						c.prenom,
						ha.numero,
						r.prefixe,
						r.nom as nomRue,
						'commentairesEvenement' as typeCommentaire,
						 date_format( c.date, '%Y%m%d%H%i%s' ) AS dateTri,
						c.idCommentairesEvenement as idCommentaire
						 
						FROM commentairesEvenement c
						LEFT JOIN utilisateur u on u.idUtilisateur = c.idUtilisateur
						LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie= c.idEvenement
						LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee.idEvenement
						LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
						LEFT JOIN rue r on r.idRue = ha.idRue
						WHERE c.CommentaireValide =1
						GROUP BY c.idCommentairesEvenement
						";
		
		$sousRequete2 = "SELECT
						date_format(c.date,"._('"%e/%m/%Y"').") as date,
						c.idUtilisateur,
						c.idEvenementGroupeAdresse,
						c.commentaire,
						c.nom,
						c.prenom,
						ha.numero,
						r.prefixe,
						r.nom as nomRue,
						'commentaires' as typeCommentaire,
						date_format( c.date, '%Y%m%d%H%i%s' ) AS dateTri,
						c.idCommentaire as idCommentaire
								

						 
						FROM commentaires c
						LEFT JOIN utilisateur u on u.idUtilisateur = c.idUtilisateur
						LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie= c.idEvenementGroupeAdresse
						LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee.idEvenement
						LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
						LEFT JOIN rue r on r.idRue = ha.idRue
						WHERE c.CommentaireValide =1
						GROUP BY c.idCommentaire
		";
		
		$requete= "
				SELECT * FROM
				(
				$sousRequete1
					) as tmp1

					UNION all

					SELECT * FROM (
					$sousRequete2
					)
					AS tmp2
					ORDER BY dateTri desc
					LIMIT $nbComment
					";
		$result = $this->connexionBdd->requete($requete);
		$arrayComment = array();
		$e = new archiEvenement();
		while($latestComment = mysql_fetch_assoc($result)){
			$idEvenement = "";
			$idEvenementGroup = "";
			$idAdresse="";
			$ancre="#commentaire";
			
			if($latestComment['typeCommentaire'] == 'commentairesEvenement'){
				$idEvenement = $latestComment['idEvenement'];
				$idEvenementGroup = $e->getIdGroupeEvenement($latestComment['idEvenement']);
				if($idPersonne = archiPersonne::isPerson($idEvenementGroup)){
					$nom = ArchiPersonne::getName($idPersonne);
					$adresse = $nom->nom. " " . $nom->prenom;
					$url = $this->creerUrl('', '', array('archiAffichage'=>'evenementListe', 'selection'=>"personne", 'id'=>$idPersonne));
				}
				else{
					$idAdresse = $e->getIdAdresse($latestComment['idEvenement']);
				}
				$ancre.="Evenement".$latestComment['idCommentaire'];
			}
			else{
				$idEvenementGroup = $latestComment['idEvenement'];
				$reqIdEvt = "
				SELECT idEvenementAssocie as idEvenement
				FROM _evenementEvenement
				WHERE idEvenement = $idEvenementGroup
				";
				$resIdEvt = $this->connexionBdd->requete($reqIdEvt);
				$tmp = mysql_fetch_array($resIdEvt);
				$idEvenement = $tmp['idEvenement'];
				$idAdresse = $e->getIdAdresse($idEvenement);
				
				$ancre.="Adresse".$latestComment['idCommentaire'];
			}

			if(!archiPersonne::isPerson($idEvenementGroup)){
				$adresseArray = $e->getArrayAdresse($idEvenement);
				//Adresse
				$adresse = '';
				$adresse = $e->getAddressText($adresseArray);
				$url = $this->creerUrl('','',array('archiAffichage'=>'adresseDetail',"archiIdAdresse"=>$idAdresse,"archiIdEvenementGroupeAdresse"=>$idEvenementGroup));
			}


			$so = new StringObject();
			$test = $so->replaceUrl($latestComment['commentaire']);
			
			
			$bbCode = new bbCodeObject();
			$commentaireText =$bbCode->stripBBCode($latestComment['commentaire']); 
			$latestComment['commentaire'] = $so->truncateStringToWord($commentaireText,80,' ','...');
			$urlPersonne = $this->creerUrl('','detailProfilPublique',array('archiIdUtilisateur'=>$latestComment['idUtilisateur'],'archiIdEvenementGroupeAdresseOrigine'=>$idEvenementGroup));
			$latestComment['typeCommentaire'] = 'commentaireEvenement';
			$latestComment['urlAdresse'] = $url.$ancre;
			$latestComment['urlPersonne'] = $urlPersonne;
			$latestComment['adresse']=$adresse;
			$arrayComment[] = $latestComment;
		}
			
		return $arrayComment;
	}


	public function getLatestModification($nbElts){
		$interest = new archiInterest();
		$auth = new ArchiAuthentification();
		$whereSimple = "WHERE ae.idAdresse IS NOT NULL ";
		$whereSimpleArray = array();
		if($auth->estConnecte()){
			$arrayInterest = $interest->getFavorisByCategories();
			if(!empty($arrayInterest)){
				if(isset($arrayInterest['rue'])){
					$fieldRue = implode(',', $arrayInterest['rue']);
					$subClause[]= "ha.idRue in ($fieldRue)";
					
					foreach($arrayInterest['rue'] as $idRue){
						$whereSimpleArray[] = "ha.idRue = ".$idRue." ";
					}
				}
				if(isset($arrayInterest['sousQuartier'])){
					$fieldSousQuartier = implode(',',$arrayInterest['sousQuartier']);
					$subClause[] = "ha.idSousQuartier in ($fieldSousQuartier)";
					
					foreach ( $arrayInterest ['sousQuartier'] as $idSousQuartier ) {
						$whereSimpleArray[]= " ha.idSousQuartier = " . $idSousQuartier." ";
					}
				}
				if (isset ( $arrayInterest ['quartier'] )) {
					$fieldQuartier = implode ( ',', $arrayInterest ['quartier'] );
					$subClause [] = "ha.idQuartier in ($fieldQuartier)";
					
					foreach ($arrayInterest['quartier'] as $idQuartier){
						$whereSimpleArray[]=" ha.idQuartier = ".$idQuartier." ";
					}
				}
				if (isset ( $arrayInterest ['ville'] )) {
					$fieldVille = implode ( ',', $arrayInterest ['ville'] );
					$subClause [] = "ha.idVille in ($fieldVille)";
					foreach ($arrayInterest['ville'] as $idVille){
						$whereSimpleArray[]=" ha.idVille = ".$idVille." ";
					}
				}
				if(isset($arrayInterest['pays'])){
					$fieldPays = implode(',', $arrayInterest['pays']);
					$subClause[]="ha.idPays in ($fieldPays)";
					
					foreach ($arrayInterest['pays'] as $idPays){
						$whereSimpleArray[]=" ha.idPays = ".$idPays." ";
					}
				}

				if(!empty($subClause)){
					$whereClause.=" AND (".implode(' OR ', $subClause).")";
				}
				if(!empty($whereSimpleArray)){
					$whereSimple .=" AND (".implode(' OR ', $whereSimpleArray).")";					
				}
				$leftjoinCondition ="AND ".implode (' AND ',$whereSimpleArray);
			}

		}
		

		

		$requeteElements = "select * from (
   					 SELECT
					 ee.idEvenement as idEvenementGroupeAdresse,
					evt.idEvenement AS idEvenement,
					ae.idAdresse,
					null as idPersonne,
					evt.idEvenementRecuperationTitre ,
					evt.idImagePrincipale AS idHistoriqueImage,
					te.nom as typeEvenement,
					date_format(evt.dateCreationEvenement," . _('"%e/%m/%Y"').") as dateCreationEvenement,
					DATE_FORMAT(evt.dateCreationEvenement, '%Y%m%d%H%i%s') as DateTri,
					evt.description,
					'adresse' as type
		
					FROM evenements evt
					LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = evt.idEvenement
					LEFT JOIN _adresseEvenement ae ON ae.idEvenement = ee.idEvenement
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
					LEFT JOIN typeEvenement te ON te.idTypeEvenement = evt.idTypeEvenement
		
					WHERE ae.idAdresse IS NOT NULL
		 			".$whereClause."
		
				    UNION
				    SELECT
				    ee.idEvenement as idEvenementGroupeAdresse,
				    evt.idEvenement AS idEvenement,
					NULL as idAdresse,
					p.idPersonne,
				    evt.idEvenementRecuperationTitre ,
				    evt.idImagePrincipale AS idHistoriqueImage,
				    'Personne' as typeEvenement,
					date_format(evt.dateCreationEvenement," . _('"%e/%m/%Y"').") as dateCreationEvenement,
					DATE_FORMAT(evt.dateCreationEvenement, '%Y%m%d%H%i%s') as DateTri,
				    evt.description,
				    'personne' as type
		
				    FROM evenements evt
				    LEFT JOIN _evenementEvenement ee on ee.idEvenementAssocie = evt.idEvenement
				    LEFT JOIN _personneEvenement pe ON pe.idEvenement = ee.idEvenement
				    LEFT JOIN personne p on p.idPersonne = pe.idPersonne
					LEFT JOIN _evenementPersonne ep on ep.idPersonne = p.idPersonne
					LEFT JOIN _evenementEvenement ee2 on ee2.idEvenementAssocie = ep.idEvenement
					LEFT JOIN _adresseEvenement ae on ae.idEvenement = ee2.idEvenement
					LEFT JOIN historiqueAdresse ha on ha.idAdresse = ae.idAdresse
		
				    WHERE p.idPersonne IS NOT NULL
					".$whereClause."
							
					
		
				) as tmp
		
				WHERE tmp.DateTri = (
				    SELECT max(DATE_FORMAT(evt2.dateCreationEvenement, '%Y%m%d%H%i%s'))
				    FROM evenements evt2
				    LEFT JOIN _evenementEvenement ee2 on ee2.idEvenementAssocie = evt2.idEvenement
				    WHERE ee2.idEvenement = tmp.idEvenementGroupeAdresse
				)
				GROUP BY tmp.idEvenement
				ORDER BY tmp.DateTri DESC
				LIMIT 8
		
				";
		
		$resultIdAdresse = $this->connexionBdd->requete($requeteElements);
		$arrayIdEvenement = array();
		$arrayEvenement = array();
		
		while($lastModif = mysql_fetch_assoc($resultIdAdresse)){
			$tmp = $lastModif;
				if($lastModif['type']=='adresse'){
				$requeteTitre = "SELECT e1.titre , e2.idImagePrincipale
						FROM evenements e1,evenements e2
						WHERE e2.idEvenement = " . $lastModif ['idEvenementGroupeAdresse'] . "
						AND e1.idEvenement = e2.idEvenementRecuperationTitre
								";
				$restitre = $this->connexionBdd->requete ( $requeteTitre );
				$titreArray = mysql_fetch_assoc ( $restitre );
				
				$evenement = new archiEvenement();
				$idTitre = $evenement->getIdEvenementTitre($lastModif);
				$requeteTitreLegacy ="SELECT titre from evenements where idEvenement = $idTitre";
				$resTitreLegacy = $this->connexionBdd->requete($requeteTitreLegacy);
				$titreArray = mysql_fetch_assoc($resTitreLegacy);
				
				$tmp ['titre'] = $titreArray ['titre'];
				$idImagePrincipale = $titreArray ['idImagePrincipale'];
				if (isset ( $idImagePrincipale ) && ! empty ( $idImagePrincipale )) {
					$requeteIdHistoImage = "
							SELECT idHistoriqueImage
							FROM historiqueImage hi 
							WHERE idImage = $idImagePrincipale
							ORDER BY idHistoriqueImage DESC
							LIMIT 1
							";
					$resIdImg = $this->connexionBdd->requete ( $requeteIdHistoImage );
					$arrayIdHistoImg = mysql_fetch_assoc ( $resIdImg );
					$tmp ['idHistoriqueImage'] = $arrayIdHistoImg ['idHistoriqueImage'];
				}
			}
			else{
				$p = new ArchiPersonne($tmp['idPersonne']);
				$tmp['titre'] = $p->getPersonneLibelle($tmp['idPersonne']);
			}
			$arrayLastModif[]=$tmp;
		}
		return $arrayLastModif;
	}



	/**
	 * Get the latest user's favorite information to display
	 *
	 * @param unknown $nbElts to display
	 * @return multitype:
	 */
	public function getLatestFav($nbElts){
		/*
		 * Initialisation des variables :
		* Tableau avec les champs pour remplir la requete
		*/
		$requestField = array(
				array(
						'table'=>'_interetRue',
						'id'=> 'idRue'
				),
				array(
						'table'=>'_interetSousQuartier',
						'id'=> 'idSousQuartier'
				),
				array(
						'table'=>'_interetVille',
						'id'=> 'idVille'
				),
				array(
						'table'=>'_interetAdresse',
						'id'=> 'idHistoriqueAdresse'
				),
				array(
						'table'=>'_interetPays',
						'id'=> 'idPays'
				),
				array(
						'table'=>'_interetQuartier',
						'id'=> 'idQuartier'
				)
		);
		$auth = new ArchiAuthentification();
		$userId=$auth->getIdUtilisateur();
		/*
		 * Boucle pour faire les sous requetes
		*/

		$subRequest = array();
		$request ="";
		$i=0;
		foreach ($requestField as $fields){
			$request.="
					(
					SELECT

					evt.idEvenement AS idEvenement,
					evt.idEvenementRecuperationTitre,
					evt.idImagePrincipale AS idHistoriqueImage,
					ee.idEvenement AS idEvenementGroupeAdresse,
					ae.idAdresse AS idAdresse,
					ha.nom ,
					date_format(evt.dateCreationEvenement,"._('"%e/%m/%Y"').") as dateCreationEvenement,
							i.created as created,
							evt.description,
							evt.titre AS titre
								

							FROM evenements evt
							INNER JOIN _evenementEvenement ee ON ee.idEvenementAssocie = evt.idEvenement
							INNER JOIN _adresseEvenement ae ON ae.idEvenement = ee.idEvenement
							INNER JOIN historiqueAdresse ha ON ha.idAdresse = ae.idAdresse
							INNER JOIN ".$fields['table']." i ON i.".$fields['id']." = ha.".$fields['id']."
									WHERE i.idUtilisateur =".$userId."
									GROUP BY idEvenement DESC
									ORDER BY i.created
									LIMIT $nbElts
									)
									";
			if($i++<count($requestField)-1){
				$request.=" UNION ";
			}
		}
		/*
		 * Data processing
		*/

		//Strange request wrapping to avoid redundancy, might not be accepted by MySQL
		$request = "SELECT * FROM
				(".$request.")
				AS tmp
				GROUP BY idEvenementGroupeAdresse
				ORDER BY created
				LIMIT $nbElts ";
		$result = $this->connexionBdd->requete($request);
		while($fetch = mysql_fetch_assoc($result)){
			$item['CSSClassWrapper'] = 'interest';
			$item['titreItem'] =$fetch['nom'];
			$item['imgUrl'] = $this->getUrlImage().'resizeImage.php?id='.$fetch['idHistoriqueImage'];

			$item['urlItem'] = $this->creerUrl('', '',
					array(
							'archiAffichage'=>'adresseDetail',
							"archiIdAdresse"=>$fetch['idAdresse'],
							"archiIdEvenementGroupeAdresse"=>$fetch['idEvenementGroupeAdresse']
					));
			$item['textItem'] = $fetch['nom'];
			$itemContent[]=$fetch;
		}
		return $itemContent;
	}

	public function afficherOpendata(){
		$html = "";

		$t = new Template('modules/archi/templates/');
		$t->set_filenames(array('opendata'=>'opendata/index.tpl'));
		$t->assign_vars(array(
				'urlContact'=>$this->creerUrl('','contact')
		));
		
		
		$filesArray = array(
				array(
						'name'=>'Adresses par architectes',
						'xml'=>'opendata-adressesArchitecte.xml',
						'csv'=>'opendata-adressesArchitecte.csv',
						'filename'=>'adressesArchitecte'
				),
				array(
						'name'=>'Adresses par quartiers',
						'xml'=>'opendata-adressesQuartier.xml',
						'csv'=>'opendata-adressesQuartier.csv',
						'filename'=>'adressesQuartier'
				),
				array(
						'name'=>'Adresses par rues',
						'xml'=>'opendata-adressesRue.xml',
						'csv'=>'opendata-adressesRue.csv',
						'filename'=>'adressesRue'
						
				),
				array(
						'name'=>'Quartiers par villes',
						'xml'=>'opendata-quartiersVille.xml',
						'csv'=>'opendata-quartiersVille.csv',
						'filename'=>'quartiersVille'
				),
				array(
						'name'=>'Rues par quartiers',
						'xml'=>'opendata-ruesQuartier.xml',
						'csv'=>'opendata-ruesQuartier.csv',
						'filename'=>'ruesQuartier'
				),
				array(
						'name'=>'Rues par sous quartiers',
						'xml'=>'opendata-ruesSousQuartier.xml',
						'csv'=>'opendata-ruesSousQuartier.csv',
						'filename'=>'ruesSousQuartier'
				),
				array(
						'name'=>'Rues par villes',
						'xml'=>'opendata-ruesVille.xml',
						'csv'=>'opendata-ruesVille.csv',
						'filename'=>'ruesVille'
				),
				array(
						'name'=>'Photos par quartiers',
						'xml'=>'opendata-urlPhotosQuartier.xml',
						'csv'=>'opendata-urlPhotosQuartier.csv',
						'filename'=>'urlPhotosQuartier'
				),
				array(
						'name'=>'Photos par rues',
						'xml'=>'opendata-urlPhotosRue.xml',
						'csv'=>'opendata-urlPhotosRue.csv',
						'filename'=>'urlPhotosRue'
				)
		);

		foreach ($filesArray as $file){
			if (file_exists("modules/opendata/xml/".$file['filename'].".xml")) {
				$file['date'] = date("d/m/Y H:i:s", filemtime("modules/opendata/xml/".$file['filename'].".xml")) ;
			}
			$t->assign_block_vars('fichier', $file);
		}

		ob_start();
		$t->pparse('opendata');
		$html .= ob_get_contents();
		ob_end_clean();

		return $html;
	}

}
?>
