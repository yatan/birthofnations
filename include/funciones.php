<?
/*

Script con varias funciones:


online(): Muestra si el servidor mysql esta disponible o no


*/

function online()
{
 
$ip = "localhost";  
$puerto = 3306; 
 
if ($fp=@fsockopen($ip,$puerto,$ERROR_NO,$ERROR_STR,(float)0.5))   
    {   
    fclose($fp);   
            echo "<font color='Green'>Online</font>";  
        } else {         
            echo "<font color='Red'>OFFLINE</font>";   
        }   


}

?>

