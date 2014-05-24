<?php
/**
 * Retourne une adresse en JSON à partir de son ID
 * 
 * PHP Version 5.4
 * 
 * @category Script
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @author   Partenaire Immobilier <contact@partenaireimmo.com>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * */
if (isset($_GET['archiIdAdresse'])) {
    include_once "../includes/framework/config.class.php";
    include_once "../modules/archi/includes/archiAdresse.class.php";
    $a = new ArchiAdresse();
    $adresse = $a->getIntituleAdresseFrom(
        $_GET['archiIdAdresse'], 'idAdresse',
        array('noQuartier'=>true, 'noSousQuartier'=>true, 'noVille'=>true)
    );
    echo json_encode(str_replace("d' ", "d'", str_replace("l' ", "l'", $adresse)));
}
?>
