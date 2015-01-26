<?php
/** @file
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
$path="images/placeholder.jpg";
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $req = "
            SELECT dateUpload
            FROM  historiqueImage 
            WHERE idHistoriqueImage = '".mysql_real_escape_string($_GET["id"])."'";
    $res =$config->connexionBdd->requete($req);
    $image=mysql_fetch_object($res);
    if ($image) {
        $tempPath="images/moyen/".$image->dateUpload."/".$_GET["id"].".jpg";
        if (file_exists($tempPath)) {
            $path = $tempPath;
        }
    }     
}

if(isset($_GET['height']) && $_GET['height']!=''&& isset($_GET['width']) && $_GET['width']!=''){
	$heightFinal=$_GET['height'];
	$widthFinal = $_GET['width'];
}
else{
	$heightFinal=130;
	$widthFinal = 130;
}

echo $widthFinal;
echo $heightFinal;
$infos=getimagesize($path);
$input = imagecreatefromjpeg($path);
header("Content-Type: image/jpeg");
if ($infos[1] > $infos[0]) {
    $width=$widthFinal;
    $height=($infos[1]*$widthFinal)/$infos[0];
} else {
    $height=$heightFinal;
    $width=($infos[0]*$heightFinal)/$infos[1];
}
$output = imagecreatetruecolor($heightFinal, $widthFinal);
imagecopyresampled(
    $output, $input, 0, 0, 0, 0, $width, $height, $infos[0], $infos[1]
);
imagejpeg($output);
?>