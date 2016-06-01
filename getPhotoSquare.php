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
 * @link     http://archi-wiki.org/
 * */
require_once 'vendor/autoload.php';
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
$image = new \Eventviva\ImageResize($path);
$image->crop(130, 130, true);
$image->output();
