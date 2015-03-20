<html>
<head>

</head>
<body>
	<h1>Open Data Archi-Wiki</h1>
	<form method="post" action="convert.php">
		<select name="typeConversion">
			<?php 
			$optionArray = array(
					array(
							'value' => 'adressesRue',
							'label' => 'Adresses par rue'
					),
					array(
							'value' => 'ruesQuartier',
							'label' => 'Rues par quartier'
					),
					array(
							'value' => 'ruesSousQuartier',
							'label' => 'Rues par sous quartier'
					),
					array(
							'value' => 'quartiersVille',
							'label' => 'Quartiers par ville'
					),
					array(
							'value' => 'adressesArchitecte',
							'label' => 'Adresses par architecte'
					),
					array(
							'value' => 'urlPhotosRue',
							'label' => 'Url des photos par rue'
					),
					array(
							'value' => 'urlPhotosQuartier',
							'label' => 'Url des photos par quartier'
					),
					array(
							'value' => 'ruesVille',
							'label' => 'Rues par ville'
					),
					array(
							'value' => 'adressesQuartier',
							'label' => 'Adresses par quartier'
					),
					array(
							'value' => 'urlPhotosAdresse',
							'label' => 'Url des photos par adresse'
					)
			);
			foreach($optionArray as $option){
		echo '<option value="'.$option['value'].'">'.$option['label'].'</option>';
	}
	?>
		</select> <input type="submit">
	</form>
</body>
</html>
