<?php
/**
 * Génère un fichier MO
 *
 * PHP Version 5.3.3
 *
 * @category Script
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 *
 * */
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
print_r(exec("cd ".dirname(__DIR__)."/locale/; sh ./compile.sh 2>&1"));
header("Location: ".$_SERVER["HTTP_REFERER"]);
?>
