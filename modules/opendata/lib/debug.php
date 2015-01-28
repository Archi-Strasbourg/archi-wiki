<?php
/**
 * Print debug variable content
 * @param $variable : variable to print
 */
function debug($variable){
	$backtrace = debug_backtrace();
	print_r("Line <strong>".$backtrace[0]['line']."</strong> on file : " . $backtrace[0]['file']);
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
}
?>