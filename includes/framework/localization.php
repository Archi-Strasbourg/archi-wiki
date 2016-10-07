<?php
/**
 * Initialisation de la traduction avec Gettext
 * 
 * PHP Version 5.3.3
 * 
 * @category Lang
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Partenaire Immobilier <contact@partenaireimmo.com>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 * 
 * */
if (function_exists("bindtextdomain")) {
    if (isset($_GET["lang"])) {
        define("LANG", $_GET["lang"]);
    } else if (isset($_COOKIE["lang"])) {
        define("LANG", $_COOKIE["lang"]);
    } else {
        define("LANG", ArchiConfig::$default_lang);
    }
    setcookie("lang", LANG);
    $resultPutenv = putenv("LC_ALL=".LANG);
    $resultSetenv = setlocale(
        LC_ALL, LANG.".utf8",
        LANG, LANG."_".strtoupper(LANG),
        LANG."_".strtoupper(LANG).".utf8"
    );
    $resbindtd  = bindtextdomain("messages", dirname(dirname(__DIR__))."/locale");
    $resultBindTextdomaincodeset=bind_textdomain_codeset("messages", "UTF-8");
    $retTextDomain = textdomain("messages");
} else {
    define("LANG", "fr_FR");
    if (!function_exists("gettext")) {
        /**
         * Fonction gettext factice
         * 
         * @param string $string Texte à traduire
         * 
         * @return string
         * */
        function gettext($string)
        {
            return $string;
        }
    }
}
?>
