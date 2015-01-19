<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{descriptionPage}" />
	<meta name="robots" content="index follow, all" />
	<meta name="keywords" content="<?_("architectures,architecture,neudorf,contades,centre,strasbourg,photos,immeubles,monuments,immobilier,alsace")?>{motsCle}" />
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='includes/datePicker.js'></script>
		<script type='text/javascript' src='includes/bbcode.js'></script>
		<script type='text/javascript' src='includes/common.js'></script>
		<script type='text/javascript' src='js/utils.js'></script>
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
	{htmlHeader}
	{htmlModule}
	{content}
	{footer}
	</body>
</html>
