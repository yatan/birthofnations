<?


$server="birthofnations.com"; /* Nuestro server mysql */
$database="birthofn_bon"; /* Nuestra base de datos */
$dbpass="root1234"; /*Nuestro password mysql */
$dbuser="birthofn_bon"; /* Nuestro user mysql */


$link=mysql_connect($server,$dbuser,$dbpass);

mysql_select_db($database, $link);

?>

