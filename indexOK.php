<?php
// 'noHeaderNoFooter' permet de ne pas retourner et inclure les fichiers qui sont inutiles lors d'un appel ajax

session_start();
date_default_timezone_set('Europe/Paris');

$microstart=microtime(true);

// a l'appel des différentes fonctions qui retourne du javascript , on va placer ce javascript dans le header ou le footer suivant les cas , ce qui evite d'en avoir trop en plein milieu de la page et encourage la creation de fonctions javascript 
// plutot que de mettre beaucoup de code dans les tags onclick ou onmouseover etc
$jsHeader=""; 
$jsFooter="";


include('PEAR.php');
include('HTML/BBCodeParser.php');

include('includes/framework/config.class.php');
$config = new ArchiConfig();
include_once('includes/securimage/securimage.php'); // gestion du captcha

// principe modulaire : chacun des fichiers appel고cidessous devraient etre chargés en fonction du parametre 'moduleName'
include('modules/archi/includes/archiEvenement.class.php');
include('modules/archi/includes/archiImage.class.php');
include('modules/archi/includes/archiAdresse.class.php');
include('modules/archi/includes/archiAuthentification.class.php');
include('modules/archi/includes/archiCourantArchitectural.class.php');
include('modules/archi/includes/archiPersonne.class.php');
include('modules/archi/includes/archiSource.class.php');
include('modules/archi/includes/archiRecherche.class.php');
include('modules/archi/includes/archiUtilisateur.class.php');
include('modules/archi/includes/archiStatic.class.php');
include('modules/archi/includes/archiAccueil.class.php');
include('modules/archi/includes/archiAdministration.class.php');




//
//     Lancement du module principal
//
ob_start();
if(isset($_GET['module']))
{
	include('modules/'.$_GET['module'].'/index.php');
}
else
{
	include('modules/archi/index.php');
}
$htmlModule = ob_get_contents();
ob_end_clean();


//
//     HEADER
//
ob_start();
if(!isset($_GET['noHTMLHeaderFooter']))
{
	if(!isset($_GET["noHeaderNoFooter"]) && !isset($_POST["noHeaderNoFooter"]))
	{
		$headerJS = "";
		if(ArchiConfig::getJsHeader()!='')
		{
			$headerJS = ArchiConfig::getJsHeader();
		}
		include('modules/header/index.php');
	}
	else
	{
		$headerJS = "";
		if(ArchiConfig::getJsHeader()!='')
		{
			$headerJS = ArchiConfig::getJsHeader();
		}
		$ajaxObj = new ajaxObject();
		?><html>
		<head>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='includes/datePicker.js'></script>
		<script type='text/javascript' src='includes/bbcode.js'></script>
		<?php  echo $ajaxObj->getAjaxFunctions(); ?>
		<script type='text/javascript' src='includes/common.js'></script>
		<?php  echo $headerJS; ?>
		</head>
		<body><?php
	}
}
$htmlHeader = ob_get_contents();
ob_end_clean();

echo $htmlHeader;
echo $htmlModule;
if(!isset($_GET['noHTMLHeaderFooter']))
{
	if(!isset($_GET["noHeaderNoFooter"]) && !isset($_POST["noHeaderNoFooter"]))
	{
		$footerJS = "";
		if(ArchiConfig::getJsFooter()!='')
		{
			$footerJS = ArchiConfig::getJsFooter();
		}
		include('modules/footer/index.php');
	}
	else
	{
		$footerJS = "";
		if(ArchiConfig::getJsFooter()!='')
		{
			$footerJS = ArchiConfig::getJsFooter();
		}
		?>
		<?php echo $footerJS; 
		
		
		if(!isset($config->isSiteLocal) || $config->isSiteLocal==false)
		{

			echo "<script type=\"text/javascript\">
var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
</script>
<script type=\"text/javascript\">
try {
var pageTracker = _gat._getTracker(\"UA-16282574-3\");
pageTracker._trackPageview();
} catch(err) {}</script>";
		}
		
		?>
		</body>
		</html><?php
	}
}

 $fin_compte=microtime(true);
 $duree=($fin_compte-$microstart);
 $authDebug = new archiAuthentification();
 if(!isset($_GET['noHTMLHeaderFooter']))
{
 if($authDebug->estAdmin())
 {
	echo '<br><br>Page g&eacute;n&eacute;r&eacute;e en '.substr($duree,0,5).' sec.';
 }
}
?>