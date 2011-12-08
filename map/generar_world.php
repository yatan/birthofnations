<?
//header('Content-Type: image/png');
include_once("../include/funciones.php");

$regiones = sql2("SELECT idregion FROM region");

foreach ($regiones as $id_region) {
    
    $id_r = $id_region['idregion'];
    
$x2 = 251;
$y2 = 251;

$gd = imagecreatetruecolor($x2, $y2);

//Colores
$red = imagecolorallocate($gd, 255, 0, 0); 
$green = imagecolorallocate($gd, 0, 255, 0); 
$blue = imagecolorallocate($gd, 0, 0, 255); 
$black = imagecolorallocate($gd, 0, 0, 0); 



for ($y = 0; $y < 10; $y++) {
    for ($x = 0; $x < 10; $x++) {
        
        $tipo = sql("SELECT tipo FROM map_zonas WHERE x='$x' AND y='$y' AND id_zona='$id_r'");
        if($tipo==1)
            imagefilledrectangle($gd, $x*25,$y*25, $x*25+25,$y*25+25, $red);
        elseif($tipo==2)
            imagefilledrectangle($gd, $x*25,$y*25, $x*25+25,$y*25+25, $blue);
        else
            imagefilledrectangle($gd, $x*25,$y*25, $x*25+25,$y*25+25, $green);
        
            

    }
}
 

for ($i = 0; $i <= $y2; $i += 25) {
    imageline($gd, $i, 0, $i, 251, $black);
}

for ($i = 0; $i <= $x2; $i += 25) {
    imageline($gd, 0, $i, 251, $i, $black);
} 



imagepng($gd,"region".$id_r.".png");
imagedestroy($gd);

}

?>

