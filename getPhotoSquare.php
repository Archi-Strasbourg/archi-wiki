<?php
/**
 * Redimenssionne une photo en 130x130 px pour la version mobile
 * 
 * PHP Version 5.3.3
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * 
 * */
require_once "includes/framework/config.class.php";
$config = new Config();
$req = "
        SELECT dateUpload
        FROM  historiqueImage 
        WHERE idImage = ".$_GET["id"];
$res =$config->connexionBdd->requete($req);
$image=mysql_fetch_object($res);
$path="images/moyen/".$image->dateUpload."/".$_GET["id"].".jpg";
$infos=getimagesize($path);
$input = imagecreatefromjpeg($path);
header("Content-Type: image/jpeg");
if ($infos[1] > $infos[0]) {
    $width=130;
    $height=($infos[1]*130)/$infos[0];
} else {
    $height=130;
    $width=($infos[0]*130)/$infos[1];
}
$output = imagecreatetruecolor(130, 130);
imagecopyresampled(
    $output, $input, 0, 0, 0, 0, $width, $height, $infos[0], $infos[1]
);
imagejpeg($output);
?>
