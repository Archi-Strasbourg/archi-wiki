<?php
/**
 * Redimenssionne une photo en 640x340 px pour la page d'accueil de la version mobile
 *
 * PHP Version 5.3.3
 *
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * */
require_once "includes/framework/config.class.php";
require_once 'vendor/autoload.php';
$config = new Config();
$req = "
        SELECT dateUpload
        FROM  historiqueImage
        WHERE idHistoriqueImage = ".mysql_real_escape_string($_GET["id"]);
$res =$config->connexionBdd->requete($req);
$image=mysql_fetch_object($res);
$path="images/grand/".$image->dateUpload."/".$_GET["id"].".jpg";
$image = new \Eventviva\ImageResize($path);
$image->crop(640, 340, true);
$image->output();
