<?php
/** @file
 * Redimenssionne une photo en 130x130 px pour la version mobile
 * 
 * PHP Version 5.3.3
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Antoine Rota Graziosi
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * 
 * */

ini_set( 'memory_limit', '32M' );



function resizeJpeg($url, $thumb_width, $thumb_height)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	$data = curl_exec($ch);

	curl_close($ch);

	$image = imagecreatefromstring($data);

	$width = imagesx($image);
	$height = imagesy($image);

	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;

	if ( $original_aspect >= $thumb_aspect )
	{
		// If image is wider than thumbnail (in aspect ratio sense)
		$new_height = $thumb_height;
		$new_width = $width / ($height / $thumb_height);
	}
	else
	{
		// If the thumbnail is wider than the image
		$new_width = $thumb_width;
		$new_height = $height / ($width / $thumb_width);
	}

	$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

	// Resize and crop
	imagecopyresampled($thumb,
	$image,
	0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
	0 - ($new_height - $thumb_height) / 2, // Center the image vertically
	0, 0,
	$new_width, $new_height,
	$width, $height);

	header('Content-Type: image/jpeg');
	return $thumb;
	// Also tried 'return imagejpeg($thumb);' and simply 'imagejpeg($thumb);'
}






$path="images/placeholder.jpg";
if (isset($_GET["id"]) && !empty($_GET["id"])) {
	
	
	$ressource = mysql_connect('localhost', 'archi_u_preprod', 'archi_pwd_preprod')
	or die(file_get_contents(__DIR__.'/../../../maintenance.html'));
	mysql_select_db('archi_dbname_preprod') or die(mysql_error());
	mysql_query('SET NAMES "utf8"') or die (mysql_error());
    $req = "
            SELECT dateUpload
            FROM  historiqueImage 
            WHERE idHistoriqueImage = '".mysql_real_escape_string($_GET["id"])."'";
    
    $res = mysql_query($req)
    or
    die($requete.' -- '.mysql_error().' -- <br/> Request in file : <b>'.debug_backtrace()[0]['file'].'</b><br/> on line <b>'.debug_backtrace()[0]['line']).'</b>';
    
    
    
    //$res =$config->connexionBdd->requete($req);
    $image=mysql_fetch_object($res);
    if ($image) {
    	
    	//RewriteRule photos-(.*)-([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)-([a-zA-Z]+)\.jpg images/$6/$2-$3-$4/$5\.jpg [L,QSA]
    	//http://archi-strasbourg.org/photo-detail-16_rue_bastian__cronenbourg__strasbourg-1-evenement-idEvenement-1-adresse1.html
    	
        $tempPath="http://archi-strasbourg.org/photos--".$image->dateUpload."-".$_GET["id"]."-moyen.jpg";
        //if (file_exists($tempPath)) {
            $path = $tempPath;
       // }
       
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


$image_p = resizeJpeg($path, $new_width, $new_height);
header('Content-Type: image/jpeg');
imagejpeg($image_p, NULL, 100);
imagedestroy($image_p);


/*

$remote_file=$path;
list($width, $height) = getimagesize($remote_file);
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($remote_file);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
header('Content-Type: image/jpeg');
imagejpeg($image_p, NULL, 100);
imagedestroy($image_p);
*/
?>