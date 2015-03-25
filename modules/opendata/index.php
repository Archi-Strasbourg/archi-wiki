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
	
	<?php 


	$cplxArray = array(
			'layer11'=>array(
					'layer2'=>'blabla',
					'layer2bis'=>
					array(
							'layer3'=>"blip",
							'layer3bis'=>"blop",
							'layer3bis2'=>"blup",
							'layer3bis3'=>"blap",
							'layer3bis4'=>"blyp",
					)
			),
		'layer12'=>array(
				'layer21'=>'blabla',
				'layer21bis'=>
				array(
						'layer31'=>"blip",
						'layer31bis'=>"blop",
						'layer31bis2'=>"blup",
						'layer31bis3'=>"blap",
						'layer31bis4'=>"blyp",
				)
)
	
	);
	
foreach (glob("lib/ArchiWikiConvertor/Interface/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/ArchiWikiConvertor/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/*.php") as $filename){
	include $filename;
}
	
	
	$util = new Utils();
	//$second = $util->complexFlat($cplxArray);
	$flat = $util->flattenTest($cplxArray);
	debug($cplxArray);
	//debug($second);
	debug($flat);
	
	?>
</body>
</html>
