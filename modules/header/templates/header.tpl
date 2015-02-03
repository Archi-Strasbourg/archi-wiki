<!Doctype HTML>
<html lang="{lang_short}">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>{titrePage}</title>
<meta name="description" content="{descriptionPage}" />
<meta name="robots" content="index follow, all" />
<meta name="keywords" content="<?_("architectures,architecture,neudorf,contades,centre,strasbourg,photos,immeubles,monuments,immobilier,alsace")?>{motsCle}" />
<!-- <link href="css/default.css" rel="stylesheet" type="text/css" /> -->
<link href="css/persona-buttons.css" rel="stylesheet" type="text/css" />
<link rel="author" href="index.php?archiAffichage=contact" />
<link rel="author" href="mailto:{mailContact}" />
<link rel="author" href="{authorLink}" />
<!--dernieresAdresses, constructions, demolitions, actualites, culture-->
<link rel="alternate" href="rss.php?type=actualites" type="application/rss+xml" title="Actualités" />
<link rel="alternate" href="rss.php?type=dernieresAdresses" type="application/rss+xml" title="Nouvelles adresses" />
<link rel="alternate" href="rss.php?type=constructions" type="application/rss+xml" title="Derniers travaux" />
<link rel="alternate" href="rss.php?type=demolitions" type="application/rss+xml" title="Dernières démolitions" />
<link rel="alternate" href="rss.php?type=culture" type="application/rss+xml" title="Derniers événements culturels" />
<link rel="alternate" href="rss.php?type=dernieresVues" type="application/rss+xml" title="Dernières vues" />
<link rel="icon" href="favicon.png" type="image/png"  />
<script src='includes/datePicker.js'></script>
<script src='includes/bbcode.js'></script>
{ajaxFunctions}
{calqueFunctions}
<script src='includes/common.js'></script>
{jsHeader}
<!-- BEGIN utilisateurNonConnecte -->
<script src="https://browserid.org/include.js" type="text/javascript"></script>  
<script src="js/browserid.js" type="text/javascript"></script>  
<!-- END utilisateurNonConnecte -->
<script src="js/analytics.js" type="text/javascript"></script> 
<script src="js/jquery-ui/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="js/jquery-ui/themes/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link rel="license" href="http://www.data.gouv.fr/Licence-Ouverte-Open-Licence">
</head>


<body onload="{onload}">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=323670477709341";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="outer">
	
	<div id="header">
		<div class="menu-button-div inline-block">
			<button id="menu-button" class="toggle-push-left menu-button"><div><span id="logoMenu" class="visible">&#9776;</span><span id="crossMenu" class="hidden">&#x2715;</span></div><div>Menu</div></button>
		</div>
		<div class="logo_header">
			<a href="./">
			<img alt="Archi-Wiki" src="images/logo_archi_wiki.png">
			<div class="text-lien-header inline-block">
				<div>Tous architectes !</div>
				<div>Partageons la ville, ses batiments, ses lieux</div>		
			</div>
			</a>
		</div>
		<div class="left-div-header">
			
			<div>
				<ul class="languageSwitch">
					<li><a href="?lang=fr_FR">FR</a>/</li>
					<li><a href="?lang=en_US">EN</a>/</li>
					<li><a href="?lang=de_DE">DE</a></li>
				</ul>
			</div>
			
			<div>
				<!-- BEGIN informations -->
				<div class="stats inline-block">
					<div class="stats-wrap">
						<p>Évènements : {informations.evenement}<br/>
						Adresses : {informations.adresse}<br/>
						Photos : {informations.photo}</p>
					</div>
				</div>
				<!-- END informations -->
				<div class="inline-block">
					
					<div>
						<div class=" inline-block">
							<button id="searchButton" class="left-buttons-header menu-button">
								<div><span><img id="logoSearch" alt="" src="images/logo_loupe.png"></span><span id="crossSearch">&#x2715;</span></div>
								<div class="label-menu-buttons-left">Recherche</div>
							</button>
						</div>
						<div class="inline-block">
							<button id="connexionButton" class="left-buttons-header menu-button">
								<div><span id="logoConnexion"><img alt="" src="images/logo_connexion.png"></span><span id="crossConnexion">&#x2715;</span></div>
								<div class="label-menu-buttons-left">Connexion</div>
							</button>			
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
		<div class="push-menu-top-search">
		{formulaireRecherche}
		</div>
		<div class="push-menu-top-connexion">
			<div>
				<div class="formConnexion">
				
					<div class="classicConnexion">
					{formulaireConnexion}
					<hr/>
					<div class="linksConnexion {classAuthLinkWrapper}">
					<!-- BEGIN linkConnected -->
						<a class="authLinkOneClass {linkConnected.authLinkClass}" href="{linkConnected.authLinkUrl}">{linkConnected.authLinkLabel}</a>
					<!-- END linkConnected -->
					</div>
					</div>
					<div class="fastConnect {classFastConnect}">
						<div>Connexion rapide</div>
				        <div><a class="persona-button dark" id="browserid" title="<?_("Se connecter avec BrowserID")?>" title="<?_("Se connecter avec BrowserID")?>" ><span><?_("Connexion")?></span></a></div> 
					</div>
				</div>
				
			</div>
		</div>
    <div id="content" class="content">
    	<nav  class="menu-new push-menu-left inline-block">
			<ul>
				<li><a href="">Accueil</a></li>
				<li><a href="index.php?archiAffichage=page&idPage=7">Présentation du site</a></li>
				<li><a href="index.php?archiAffichage=page&idPage=7">Revue de presse</a></li>
				<li><a href="{quiSommesNous}">Qui sommes-nous ?</a></li>
				<li><a href="{listeDossiers}">Adresses</a></li>
				<!-- BEGIN isParcours -->
				<li><a href="{parcours}">Parcours</a></li>
				<!-- END isParcours -->
				<li class="opendataLink"><a href="{urlOpendata}">Accèder à l'Opendata</a>
				<li><a href="{ajoutNouveauDossier}">Ajouter une adresse</a></li>
				<li><a href="{ajoutNouvellePersonne}">Ajouter une personne</a></li>
				<li><a href="{nosSources}">Nos sources</a></li>
				<li><a href="index.php?archiAffichage=donateurs">Nos donateurs</a></li>
			</ul>
		</nav>
        <div id="primaryContentContainer" class="inline-block">
            <div id="secondaryContent" class="secondaryContent inline-block">
                <div class="box">

                <div class="subbox paypal">
	                <a href='index.php?archiAffichage=membership' >
	                <?_("Devenir membre")?>
	                </a>
                </div>
                <div class="subbox paypal">
	                <a href='{faireUnDon}' >
	                <!--<img src='https://www.paypalobjects.com/{lang}/i/btn/btn_donate_LG.gif' alt="-->
	                	<?_("Faire un don")?>
	                <!--">-->
	                </a>
                </div>

                <div class="emplacementPub pubSecondaryContent">
                	<img alt="" src="images/pub/pub_mobile.jpg">
                </div>
                
                <div class="fb-like-box reseauSocial" data-href="https://www.facebook.com/pages/Association-Archi-Strasbourg/215793091822502" data-width="250" data-stream="false" data-header="true"></div>
                <br/>
                <div class="reseauSocial">
	                <a data-chrome="nofooter noscrollbar" width="250" height="170" data-link-color="#6D89A1" class="twitter-timeline"  href="https://twitter.com/ArchiStrasbourg"  data-widget-id="339535482302119936">Tweets de @ArchiStrasbourg</a>
	                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
                <!--<A HREF="http://www.archi-strasbourg.org/?archiAffichage=faireUnDon"><IMG SRC="images/20120326appeldons/bandeau_pub_vertical.jpg" width="174" alt="<?_("Pour continuer à lire du contenu gratuit et de qualité, faites un don.")?>"></A>-->

                <div class="box boxB">
					{derniersCommentaires}
                </div>
                
                <!-- ajout fabien du 03/04/2012 nouveau bandeau de pub-->
                <div class="box licenceLogo">
	                <a href="http://www.data.gouv.fr/Licence-Ouverte-Open-Licence" title="<?_("Le texte de ce site est disponible selon les termes de la Licence ouverte.")?>"><img src="images/Advisa/openlicence.png" alt="Licence ouverte"/>
	                </a>
                </div>
                <div>
                <a href="{urlOpendata}"><img alt="" src="images/opendata.png"></a>
                </div>
                
                </div>
            </div>
            <div id="primaryContent" class="primaryContent inline-block" {microdata}>
            <div class="pubPrimaryContent">
            	<div class="emplacementPub pubPrimaryOne inline-block">
					<img alt="" src="images/pub/bandeau_merci_bleu.jpg">
            	
            	</div>
            	<div class="emplacementPub pubPrimaryTwo inline-block">
					<img alt="" src="images/pub/bandeau_open_data_bleu.jpg">
            	
            	</div>
            	
            </div>
            {GeoCoordinates}
            {bandeauPublicite}
            <div class="title breadcrumbs">{urlCheminSite}</div>
