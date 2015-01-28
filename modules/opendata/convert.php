<?php



/*
 * Include all the files
*/
foreach (glob("lib/ArchiWikiConvertor/Interface/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/ArchiWikiConvertor/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/*.php") as $filename){
	include $filename;
}

$c = new Convertor();
$c->connect('localhost', 'archiwiki', 'archi-dev', 'archi_v2');


$typeConversion = $_POST['typeConversion'];
echo "<div><h2>$typeConversion</h2></div>";

//Using a strategy pattern
$rp = new RequestProcessor();
$rp->executeStrategy($typeConversion);



/*
 $array =$c->processRequest('select * from historiqueAdresse');
$c->arrayToXML($array);
*/
?>
<p>
	<a href="index.php">back to index</a>
</p>
