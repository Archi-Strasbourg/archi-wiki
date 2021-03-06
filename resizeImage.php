<?php
/** @file resizeImage
 * Resize and crop image to square one
 * 
 * PHP Version 5.5.9
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Antoine Rota Graziosi - InApps / InPeople
 * @link     http://archi-wiki.org/
 * 
 * */
require_once "includes/framework/config.class.php";
$config = new ArchiConfig();

$path="images/placeholder.jpg";
if (isset($_GET["id"]) && !empty($_GET["id"])) {
	$req = "
            SELECT dateUpload
            FROM  historiqueImage
            WHERE idHistoriqueImage = '".mysql_real_escape_string($_GET["id"])."'";
	$res=$config->connexionBdd->requete($req);
	$image=mysql_fetch_object($res);
	if ($image) {
		$tempPath="images/grand/".$image->dateUpload."/".$_GET["id"].".jpg";
		if (!file_exists($tempPath)) {
			$tempPath="http://archi-strasbourg.org/photos--".$image->dateUpload."-".$_GET["id"]."-grand.jpg";
		}
		$path=$tempPath;
	}
}
if(isset($_GET['height'])){
	$new_height = $_GET['height'];
}
else{
	$new_height = 130;
}
if(isset($_GET['width'])){
	$new_width=$_GET['width'];
}
else{
	$new_width = 130;
}

$source_path = $path;


define('DESIRED_IMAGE_WIDTH', $new_width);
define('DESIRED_IMAGE_HEIGHT', $new_height);

list($source_width, $source_height, $source_type) = getimagesize($source_path);
switch ($source_type) {
	case IMAGETYPE_GIF:
		$source_gdim = imagecreatefromgif($source_path);
		break;
	case IMAGETYPE_JPEG:
		$source_gdim = imagecreatefromjpeg($source_path);
		break;
	case IMAGETYPE_PNG:
		$source_gdim = imagecreatefrompng($source_path);
		break;
}

$source_aspect_ratio = $source_width / $source_height;
$desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

if ($source_aspect_ratio > $desired_aspect_ratio) {
	/*
	 * Triggered when source image is wider
	*/
	$temp_height = DESIRED_IMAGE_HEIGHT;
	$temp_width = ( int ) (DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);
} else {
	/*
	 * Triggered otherwise (i.e. source image is similar or taller)
	*/
	$temp_width = DESIRED_IMAGE_WIDTH;
	$temp_height = ( int ) (DESIRED_IMAGE_WIDTH / $source_aspect_ratio);
}

/*
 * Resize the image into a temporary GD image
*/

$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
imagecopyresampled(
$temp_gdim,
$source_gdim,
0, 0,
0, 0,
$temp_width, $temp_height,
$source_width, $source_height
);

/*
 * Copy cropped region from temporary image into the desired GD image
*/

$x0 = ($temp_width - DESIRED_IMAGE_WIDTH) / 2;
$y0 = ($temp_height - DESIRED_IMAGE_HEIGHT) / 2;
$desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
imagecopy(
$desired_gdim,
$temp_gdim,
0, 0,
$x0, $y0,
DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT
);
/*
 * Render the image
* Alternatively, you can save the image in file-system or database
*/
header('Content-type: image/jpeg');
imagejpeg($desired_gdim);
?>