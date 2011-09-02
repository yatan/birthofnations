<?php

$x = 176;
$y = 176;

$gd = imagecreatetruecolor($x, $y);

//Colores
$red = imagecolorallocate($gd, 255, 0, 0); 
$green = imagecolorallocate($gd, 0, 255, 0); 
$blue = imagecolorallocate($gd, 0, 0, 255); 
$black = imagecolorallocate($gd, 0, 0, 0); 


    $mapa = array(
        0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,
        0,1,0,0,0,0,0,
        0,0,2,0,2,0,0,
        0,0,0,0,0,0,0,
        0,0,0,1,0,0,0,
        0,0,0,0,0,0,0
       );
    $posicion = 0;

for ($i = 1; $i < 175; $i+=25) {
    for ($j = 1; $j < 175; $j+=25) {
        
        if($mapa[$posicion]==1)
            imagefilledrectangle($gd, $j,$i, $j+25,$i+25, $red);
        elseif($mapa[$posicion]==2)
            imagefilledrectangle($gd, $j,$i, $j+25,$i+25, $blue);
        else
            imagefilledrectangle($gd, $j,$i, $j+25,$i+25, $green);
        $posicion++;
            

    }
}
 

for ($i = 0; $i <= $y; $i += 25) {
    imageline($gd, $i, 0, $i, 177, $black);
}

for ($i = 0; $i <= $x; $i += 25) {
    imageline($gd, 0, $i, 177, $i, $black);
} 


header('Content-Type: image/png');
imagepng($gd);

?>

