<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$user = sql("SELECT id_partido, id_nacionalidad FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
$party = sql("SELECT * FROM partidos WHERE id_partido = " . $_GET['af']);

if($user['id_nacionalidad'] == $party['id_pais'] && $user['id_partido'] == 0){
    sql("UPDATE usuarios SET id_partido = " . $party['id_partido'] . ", ant_partido = 0 WHERE id_usuario = " . $_SESSION['id_usuario']);
}


?>
