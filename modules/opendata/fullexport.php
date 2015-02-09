<?php
foreach (glob("lib/ArchiWikiConvertor/Interface/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/ArchiWikiConvertor/*.php") as $filename){
	include $filename;
}
foreach (glob("lib/*.php") as $filename){
	include $filename;
}

ini_set('memory_limit', '-1');
set_time_limit(0);

$config = new Config('archi_u_preprod', 'archi_pwd_preprod', 'archi_dbname_preprod', 'localhost');
$rp = new RequestProcessor(NULL,$config);
$rp->executeAllStrategies();

ini_set('memory_limit', '128M');
set_time_limit(30);
?>