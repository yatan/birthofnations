<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = base64_decode($_POST['tokken']);
$pais_destino = $_POST['pais'];

if(!isset($_POST['region']) || $_POST=="0")
    die(getString("choose_a_region"));
else
    $region_destino = $_POST['region'];

$pais_actual = sql("SELECT id_region FROM usuarios WHERE id_usuario='$id_usuario'");

if($pais_actual != null)
    die(getString('you_are_in_a_country'));

//Se actualiza el pais
$sql = sql("UPDATE usuarios SET id_nacionalidad='$pais_destino', id_region='$region_destino' WHERE id_usuario='$id_usuario'");

if($sql==false)
    die(getString("generic_error"));
else
    echo getString("moved_ok");

?>
