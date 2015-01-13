<html>
	<head>
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
