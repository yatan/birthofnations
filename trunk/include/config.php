<?


$server=""; /* Nuestro server mysql */
$database=""; /* Nuestra base de datos */
$dbpass=""; /*Nuestro password mysql */
$dbuser=""; /* Nuestro user mysql */


$link=mysql_connect($server,$dbuser,$dbpass);

mysql_select_db($database, $link);



?>

