<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = base64_decode($_POST['tokken']);
$pais_destino = $_POST['pais'];

$pais_actual = sql("SELECT id_pais FROM usuarios WHERE id_usuario='$id_usuario'");

if($pais_actual != null)
    die("Ya estas en un pais !!!");

//Se actualiza el pais
$sql = sql("UPDATE usuarios SET id_pais='$pais_destino', id_nacionalidad='$pais_destino' WHERE id_usuario='$id_usuario'");

if($sql==false)
    die("error");
else
    echo "Has viajado correctamente";

?>
