<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = base64_decode($_POST['tokken']);
$pais_destino = $_POST['pais'];

if(!isset($_POST['region']) || $_POST=="0")
    die("Selecciona una region!");
else
    $region_destino = $_POST['region'];

$pais_actual = sql("SELECT id_region FROM usuarios WHERE id_usuario='$id_usuario'");

if($pais_actual != null)
    die("Ya estas en un pais !!!");

//Se actualiza el pais
$sql = sql("UPDATE usuarios SET id_nacionalidad='$pais_destino', id_region='$region_destino' WHERE id_usuario='$id_usuario'");

if($sql==false)
    die("error");
else
    echo "Has viajado correctamente";

?>
