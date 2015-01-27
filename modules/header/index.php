<?php
/**
 * Charge le template de l'en-tête
 * 
 * PHP Version 5.3.3
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  Inconnue https://archi-strasbourg.org/?archiAffichage=faq
 * @link     https://archi-strasbourg.org/
 * 
 * */
$t=new Template('modules/header/templates/');
        
$t->set_filenames((array('header'=>'header.tpl')));

$authentification = new archiAuthentification();

$recherche = new archiRecherche();

$config = new config();

$adresse = new archiAdresse();

$evenement = new archiEvenement();

$image = new archiImage();

$ajax = new ajaxObject();

$calque = new calqueObject();

$string = new stringObject();

$utilisateur = new archiUtilisateur();

$session = new objetSession();

$i = new imageObject();


if (!isset($jsHeader)) // variables récupérée de chaque fonction des classes du site permettant de mettre du javascript recupéré , dans le header , plutot qu'en plein milieu de la page ou dans le bas de page s'il faut qu'il soit executé a la fin
    $jsHeader="";
if (!isset($jsFooter))
    $jsFooter = "";

$titreSite=$config->titreSite;
$titre=_("Architecture et photos à Strasbourg");
$description=$config->descSite;
$motsCle = "";
if ($session->isInSession('archiIdVilleGeneral') && $session->getFromSession('archiIdVilleGeneral')!='' && $session->getFromSession('archiIdVilleGeneral')!='1' && !empty($_SESSION["archiIdVilleGeneral"])) {
    //$titreSite = "photos-immeubles.org";
    $infosVille = $adresse->getInfosVille($session->getFromSession('archiIdVilleGeneral'), array("fieldList"=>"v.nom as nomVille"));
    $titre=_("Architecture et photos à")." ".$infosVille['nomVille'];
    $description=_("Architecture, photos et patrimoine de")." ".$infosVille['nomVille'];
} elseif (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='adresseDetail' && isset($_GET['archiIdAdresse']) && $_GET['archiIdAdresse']!='') {
    if ($adresse->getIdVilleFrom($_GET['archiIdAdresse'], 'idAdresse')!=1) {
        //$titreSite = "photos-immeubles.org";
    }
} elseif (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='evenement' && isset($_GET['idEvenement']) && $_GET['idEvenement']!='') {
    if ($adresse->getIdVilleFrom($_GET['idEvenement'], 'idEvenement')!=1) {
        //$titreSite = "photos-immeubles.org";
    }
}

//Titre des pages personne
if (isset($_GET["archiAffichage"]) && $_GET["archiAffichage"]=="evenementListe" && $_GET["selection"]=="personne") {
    $nom=archiPersonne::getName($_GET["id"]);
    $titre=$nom->prenom." ".$nom->nom." - ".$titre;
}




// referencement - description - titre de la page dans le cas de l'affichage de la page detail d'une adresse
if (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='adresseDetail' && isset($_GET['archiIdAdresse']) && $_GET['archiIdAdresse']!='' && $_GET['archiIdAdresse']!='0') {
    // la page courante concerne une adresse , on va chercher le titre du premier evenement pour le renseigner en titre de page
    $resGroupeAdresses = $adresse->getIdEvenementsFromAdresse($_GET['archiIdAdresse']);
    $fetchGroupeAdresses = mysql_fetch_assoc($resGroupeAdresses);
    
    $descriptionAndTitre = $evenement->getDescriptionAndTitreFromFirstChildEvenement($fetchGroupeAdresses['idEvenement']);
    $titreFirstEvenement = $descriptionAndTitre['titre'];
    $descriptionFirstEvenement = $descriptionAndTitre['description'];
    if (isset($_GET['archiIdEvenementGroupeAdresse'])) {
        $intituleAdresse = $adresse->getIntituleAdresseFrom($_GET['archiIdEvenementGroupeAdresse'], "idEvenementGroupeAdresse", array("afficheTitreSiTitreSinonRien"=>true, "noHTML"=>true));
        $quartier=$adresse->getIntituleAdresseFrom($_GET['archiIdAdresse'], "idAdresse", array('afficheSousQuartier'=>false, 'noQuartierCentreVille'=>true, "noSousQuartier"=>true, "noQuartier"=>true, "noVille"=>true));
        if (!empty($intituleAdresse) && !empty($quartier)) {
            $intituleAdresse.=" - ";
        }
        $intituleAdresse.=$quartier;
        $titre = $intituleAdresse." - ".$titre;
    } else {
        $titre = $titre;
    }
    $tabMotsCle = explode(" ", $titre);
    $tabMotsCleNettoye = array();
    foreach ($tabMotsCle as $indice => $value) {
        // on retire tout ce qui n'est pas du texte
        if (ctype_alpha($value)) {
            $tabMotsCleNettoye[] = $value;
        }
    }
    
    if (count($tabMotsCleNettoye)>0) {
        $motsCle = ", ".implode(", ", $tabMotsCleNettoye);
    }
    
    
    // description
    if ($titreFirstEvenement == '') {
        $description = $titre;
    } else {
        $aRemplacer        =    array("\n\r", "\r\n", "\n", "\r", "\"");
        $remplacerPar     =     array("", "", "", "", "'");
        
        // s'il y a un titre au premier evenement, on affiche le titre et les 100 premiers mot de la description
        $description = $titreFirstEvenement." ".$string->coupureTexte(strip_tags($string->sansBalises(str_replace($aRemplacer, $remplacerPar, stripslashes($descriptionFirstEvenement)))), 100);
    }
}


// referencement - description - titre de la page dans le cas de l'affichage de la page detail d'une image
if (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='imageDetail' && isset($_GET['archiIdImage']) && $_GET['archiIdImage']!='' && $_GET['archiIdImage']!='0') {
    $e=new archiEvenement();
    if (!archiPersonne::isPerson($e->getIdEvenementGroupeAdresseFromIdEvenement($_GET['archiRetourIdValue']))) {
        $resAdresses = $image->getIdAdressesFromIdImage($_GET['archiIdImage']);
        if ($fetchAdresses = mysql_fetch_assoc($resAdresses)) {
            $resGroupeAdresses = $adresse->getIdEvenementsFromAdresse($fetchAdresses['idAdresse']);
            $fetchGroupeAdresses = mysql_fetch_assoc($resGroupeAdresses);
            $titreFirstEvenement = $evenement->getTitreFromFirstChildEvenement($fetchGroupeAdresses['idEvenement']);
            $titre = "Photo : ".$titreFirstEvenement;
            $resAdresse = $adresse->getAdressesFromEvenementGroupeAdresses($fetchGroupeAdresses['idEvenement']);
            $fetchAdresse = mysql_fetch_assoc($resAdresse);
            $idAdresse = $fetchAdresse['idAdresse'];
            
            $intituleAdresse = $adresse->getIntituleAdresseFrom($idAdresse, "idAdresse", array('afficheSousQuartier'=>false, 'noQuartierCentreVille'=>true));
            $titre = str_replace("\"", "'", $titre." - ".$intituleAdresse);
        } else {
            $titre = "Photo - ".$titre;
        }
    }
    $tabMotsCle = explode(" ", $titre);
    $tabMotsCleNettoye = array();
    foreach ($tabMotsCle as $indice => $value) {
        // on retire tout ce qui n'est pas du texte
        if (ctype_alpha($value)) {
            $tabMotsCleNettoye[] = $value;
        }
    }
    
    $description = $titre;
    
    if (count($tabMotsCleNettoye)>0) {
        $motsCle = ", ".implode(", ", $tabMotsCleNettoye);
    }
}


$arrayIdVilleGeneral=array();
if ($session->isInSession('archiIdVilleGeneral') && $session->getFromSession('archiIdVilleGeneral')!='' && $session->getFromSession('archiIdVilleGeneral')!='1') {
    $arrayIdVilleGeneral['archiIdVilleGeneral'] = $session->getFromSession('archiIdVilleGeneral');
}


$listPages=archiPage::getListMenu(LANG);
$htmlListPages="";
foreach ($listPages as $page) {
    $htmlListPages.="<li><a href='index.php?archiAffichage=page&idPage=".$page["id"]."'>".$page["title"]."</a></li>";
}

// liens 
$t->assign_vars(
    array(
        'listeUtilisateurs'=>$config->creerUrl('', 'utilisateurListe'),
        'logsMails'=>$config->creerUrl('', 'afficheLogsMails'),
        'administration'=>$config->creerUrl('', 'administration'),
        'seDeconnecter'=>$config->creerUrl('deconnexion', 'authentification'),
        'recherche'=>$config->creerUrl('', 'recherche'),
        'edito'=>$config->creerUrl('', 'edito'),
        'quiSommesNous'=>$config->creerUrl('', 'quiSommesNous'),
        'faq'=>$config->creerUrl('', 'faq'),
        'inscription'=>$config->creerUrl('', 'inscription'),
        'listeDossiers'=>$config->creerUrl('', 'listeDossiers', $arrayIdVilleGeneral),
        'ajoutNouveauDossier'=>$config->creerUrl('', 'ajoutNouveauDossier'),
        "ajoutNouvellePersonne"=>$config->creerUrl("", "ajoutNouvelPersonne"),
        'contact'=>$config->creerUrl('', 'contact'),
        'urlMotDePasseOublie'=>$config->creerUrl('', 'formulaireMotDePasseOublie'),
        'publiciteMedias'=>$config->creerUrl('', 'publiciteArticlesPresse'),
        'nosSources'=>$config->creerUrl('', 'nosSources'),
        'faireUnDon'=>$config->creerUrl('', 'faireUnDon'),
        'ajaxFunctions'=>$ajax->getAjaxFunctions(),
        'calqueFunctions'=>"<script  >".$calque->getJSFunctionContextualHelp()." ".$i->getJsSetOpacityFunction(array('noBalisesJs'=>true))."</script>",
        'titrePage'=>stripslashes($titre),
        'descriptionPage'=>$description,
        'motsCle'=>$motsCle,
        'urlCheminSite'=>$recherche->getHtmlArborescence(),
        'titreSite'=>$titreSite,
        'parcours'=>$config->creerUrl('', 'parcours'),
        'jsHeader'=>$headerJS,
        "lang"=>LANG,
        "lang_short"=>substr(LANG, 0, 2),
        "listPages"=>$htmlListPages
    )
); // headerJS = variables contenant le javascript recupéré des fonctions du site que l'on collecte et que l'on place dans la balise header


// encart des derniers commentaires
$t->assign_vars(array('derniersCommentaires'=>$adresse->getDerniersCommentaires()));

if ($authentification->estConnecte() !== true) {
    // utilisateur pas connecté
    $t->assign_block_vars('utilisateurNonConnecte', array());
    if ($authentification->estConnecte()) {
        $t->assign_vars(array('etatConnexion'=>_("Vous êtes connecté!")));
    } else {
        $t->assign_vars(array('etatConnexion'=>_("Vous n'êtes pas connecté")));
    }
    $t->assign_vars(
        array(
            'formulaireConnexion' => $authentification->afficheFormulaireAuthentification('compact'),
            'formulaireRecherche' => $recherche->afficheFormulaire(array(), 0, array('noDisplayRechercheAvancee'=>false, 'noDisplayCheckBoxResultatsCarte'=>false)),
            'inscriptionDeconnexion' => _("Inscrivez-vous !"),
            'urlInscriptDeconnexion' => $config->creerUrl('', 'inscription'),
            'urlAccueil'=>$config->creerUrl('', 'afficheAccueil'),
            'txtAccueil'=>'Accueil'
        		
    )
    );
    $t->assign_block_vars('linkConnected', array(
    		'authLinkOneClass'=> ' authLinkOneClass forgetPasswordLabel',
    		'authLinkUrl'=> $config->creerUrl('', 'formulaireMotDePasseOublie'),
    		'authLinkLabel' => 'Mot de passe oublié ?'
    ));
    $t->assign_block_vars('linkConnected', array(
    		'authLinkOneClass'=> 'authLinkTwoClass subscribeLabel',
    		'authLinkUrl'=> $config->creerUrl('', 'inscription'),
    		'authLinkLabel' => 'Inscrivez-vous !'
    ));
    
} 
else {
    if ($authentification->estAdmin()) {
        $t->assign_block_vars('isAdmin', array());
    }
    // utilisateur connecté
    $classFastConnect="hidden";
    $t->assign_block_vars('utilisateurConnecte', array());
    $t->assign_vars(
        array(
            'inscriptionDeconnexion' => _("Déconnexion"),
            'formulaireRecherche'    => $recherche->afficheFormulaire(array(), 0, array('noDisplayRechercheAvancee'=>false, 'noDisplayCheckBoxResultatsCarte'=>false)),
            'urlInscriptDeconnexion' => $config->creerUrl('deconnexion', 'authentification'),
            'urlAccueil'=>$config->creerUrl('', 'afficheAccueil'),
            'txtAccueil'=>_("Accueil"),
            'urlMonArchi'=>$config->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'monArchi')),
            'txtMonArchi'=>_("Mon Archi"),
        	'authLinkOneUrl'=>$config->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'profil')),
        	'classAuthLinkWrapper'=>'connectedAuthLink',
        	'classFastConnect' =>$classFastConnect
        )
    );
    $t->assign_block_vars('linkConnected', array(
    		'authLinkOneClass'=> ' authLinkOneClass forgetPasswordLabel',
    		'authLinkUrl'=> $config->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'profil')),
    		'authLinkLabel' => 'Mon profil'
    ));
    $t->assign_block_vars('linkConnected', array(
    		'authLinkOneClass'=> ' authLinkOneClass forgetPasswordLabel',
    		'authLinkUrl'=> $config->creerUrl('', 'afficheAccueil', array('modeAffichage'=>'monArchi')),
    		'authLinkLabel' => 'Mon Archi'
    ));
    
    $t->assign_block_vars('linkConnected', array(
    		'authLinkOneClass'=> 'authLinkTwoClass subscribeLabel',
    		'authLinkUrl'=> $config->creerUrl('deconnexion', 'authentification'),
    		'authLinkLabel' => 'Déconnexion'
    ));
    
    if ($utilisateur->isAuthorized('affiche_menu_admin', $authentification->getIdUtilisateur())) {
        $t->assign_block_vars('afficheAdministrationMenu', array());
    }
    
}


if ($adresse->isParcoursActif()) {
    $t->assign_block_vars('isParcours', array());
}


//$t->assign_vars(array('lienRechercheParCarte'=>"<a style='margin-left:-42px;' href='".$config->creerUrl('', 'rechercheParCarte')."'>Recherche par carte</a>"));
$t->assign_vars(
    array(
        'lienRechercheAvancee'=>"<a style='margin-left:-42px;' href='".$authentification->creerUrl('', 'rechercheAvancee')."'>"._("Recherche avancée")."</a>"
    )
);

if (count($_POST)==0 && count($_GET)==0 || (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='afficheAccueil')) {
    //$t->assign_vars(array('bandeauPublicite'=>"<a href='".$config->creerUrl('', 'publiciteArticlesPresse')."'><img src='".$config->getUrlRacine()."/images/publicite/bandeau3.jpg' border=0></a>"));
}

if (isset($_GET['archiAffichage']) && $_GET['archiAffichage']=='adresseDetail') {
    $a = new archiAdresse();
    $coord=$a->getCoordonneesFrom($_GET["archiIdAdresse"], "idAdresse");
    $t->assign_vars(
        array(
            "GeoCoordinates"=>
            "<div itemscope itemprop='geo' itemtype='http://schema.org/GeoCoordinates'>
            <meta itemprop='latitude' content='".$coord["latitude"]."' />
            <meta itemprop='longitude' content='".$coord["longitude"]."' />
            </div>",
            "microdata"=>"itemscope itemtype='http://schema.org/LandmarksOrHistoricalBuildings'"
        )
    );
}
$informations =array();

// recherche du nombre d'evenements
$reqEvenements = "SELECT DISTINCT idEvenement as nbEvenements FROM historiqueEvenement;";
$resEvenements = $config->connexionBdd->requete($reqEvenements);
//$infos .= "<b>"._("Évènements :")."</b> ".mysql_num_rows($resEvenements).'<br/>';
$informations['evenement'] = mysql_num_rows($resEvenements);

// recherche du nombre d'adresses
$reqAdresses = "SELECT DISTINCT idAdresse as nbAdresses FROM historiqueAdresse;";
$resAdresses = $config->connexionBdd->requete($reqAdresses);
//$infos .= "<b>"._("Adresses :")."</b> ".mysql_num_rows($resAdresses).'<br/>';
$informations['adresse'] = mysql_num_rows($resAdresses);


// recherche du nombre de photos
$reqPhotos = "SELECT DISTINCT idImage as nbImages FROM historiqueImage;";
$resPhotos = $config->connexionBdd->requete($reqPhotos);
//$infos .= "<b>"._("Photos :")."</b> ".mysql_num_rows($resPhotos);
$informations['photo'] = mysql_num_rows($resPhotos);

$t->assign_block_vars('informations', $informations);


$reqCompteur = $config->connexionBdd->requete("SELECT nom, valeur FROM options WHERE nom LIKE 'compteur_%';");
while ($row = mysql_fetch_object($reqCompteur)) {
   $compteur[$row->nom] = $row->valeur;
}
$t->assign_vars(
    array("mailContact"=>$config->mail, "authorLink"=>$config->authorLink)
);
if (empty($compteur['compteur_actif'])) {
    $compteur['compteur_actif'] = 0;
}
$t->assign_vars(
    array(
        'compteur_pourcentage'=>round(($compteur['compteur_actuel'] / $compteur['compteur_max']) * 100),
        'compteur_actif'=>$compteur['compteur_actif'],
        'compteur_restant'=>$compteur['compteur_max'] - $compteur['compteur_actuel'],
        'compteur_lien'=>$compteur['compteur_lien'],
        'compteur_projet'=>$compteur['compteur_projet'],
        'compteur_label'=>$compteur['compteur_label']
    )
);



ob_start();
$t->pparse('header');
$html=ob_get_contents();
ob_end_clean();

$header = $html;
//echo $html;

?>
