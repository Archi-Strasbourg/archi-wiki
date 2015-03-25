	{htmlHeader}

<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>{titrePage}</title>
<meta name="description" content="{descriptionPage}" />
<meta name="robots" content="index follow, all" />
<meta name="keywords" content="<?_("architectures,architecture,neudorf,contades,centre,strasbourg,photos,immeubles,monuments,immobilier,alsace")?>{motsCle}" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="{descriptionPage}" />
<meta name="robots" content="index follow, all" />
<meta name="keywords" content="<?_("architectures,architecture,neudorf,contades,centre,strasbourg,photos,immeubles,monuments,immobilier,alsace")?>{motsCle}" />
		<link href="css/default.css" rel="stylesheet" type="text/css" />
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
<script src="js/jquery-ui/js/jquery-1.7.2.min.js" type="text/javascript">
<script src='includes/datePicker.js'></script>
<script src='includes/bbcode.js'></script>
<script type='text/javascript' src='includes/datePicker.js'></script>
<script type='text/javascript' src='includes/bbcode.js'></script>
<script type='text/javascript' src='includes/common.js'></script>
<script type='text/javascript' src='js/utils.js'></script>
<script src="https://browserid.org/include.js" type="text/javascript"></script>  
<script src="js/browserid.js" type="text/javascript"></script>  
<script src="js/analytics.js" type="text/javascript"></script> 
<script src="js/jquery-ui/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="js/jquery-ui/themes/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<script src="js/homeSearch.js"></script>
<script type="js/utils.js"></script>
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
<script src="js/homeSearch.js"></script>
<script type="js/utils.js"></script>
<link rel="license" href="http://www.data.gouv.fr/Licence-Ouverte-Open-Licence">
</head>


	
		{ajaxFunctions}
		{headerJS}
		{analyticsJS}
		{header}
		<script type="text/javascript">
			$(document).ready(function() { 
				newMenuAction();
			});
		</script>
	</head>
	<body>
	{htmlModule}
	{content}
	{footer}
	</body>
</html>
