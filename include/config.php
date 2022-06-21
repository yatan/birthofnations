<?php

$server = "localhost"; /* Nuestro server mysql */
$database = "bon"; /* Nuestra base de datos */
$dbuser = "root"; /* Nuestro user mysql */
$dbpass = ""; /*Nuestro password mysql */


$link = mysqli_connect($server, $dbuser, $dbpass);

mysqli_select_db($link, $database);
