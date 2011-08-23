<?php

$x = 700;
$y = 700;

$gd = imagecreatetruecolor($x, $y);
 
$red = imagecolorallocate($gd, 255, 0, 0); 
$green = imagecolorallocate($gd, 0, 255, 0); 
$blue = imagecolorallocate($gd, 0, 0, 255); 

$black = imagecolorallocate($gd, 0, 0, 0); 


for ($i = 0; $i < 700; $i+=25) {
    for ($j = 0; $j < 700; $j+=25) {
        $a = rand(0, 2);
        if($a==1)
            imagefilledrectangle($gd, $i,$j, $i+25,$j+25, $blue);
        elseif($a==2)
            imagefilledrectangle($gd, $i,$j, $i+25,$j+25, $green);
        else
            imagefilledrectangle($gd, $i,$j, $i+25,$j+25, $red);
            

    }
}
 

for ($i = 0; $i <= $y; $i += 15) {
    imageline($gd, $i, 0, $i, 700, $black);
}

for ($i = 0; $i <= $x; $i += 15) {
    imageline($gd, 0, $i, 700, $i, $black);
} 


header('Content-Type: image/png');
imagepng($gd);

?>

