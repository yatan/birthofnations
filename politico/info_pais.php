<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

if(!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$nombre_pais = sql("SELECT name FROM country WHERE idcountry='$id_pais'");
echo "<h1>$nombre_pais</h1>";

?>
