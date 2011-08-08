<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_region.php");

if (!isset($_GET['id_region']))
    die("Error: id no valido"); //Substituir por error 404

$region = new region($_GET['id_region']);

echo"<h1>".$region->nombre."</h1>";

echo"Propiedad de: <a href='../pais/".$region->owner_id()."'>" . $region->owner_name() . "</a>";


?>
