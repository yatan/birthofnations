<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

//$user = sql("SELECT id_partido, id_nacionalidad, ant_partido FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
//$votacion = sql("SELECT * FROM votaciones WHERE id_votacion = " . $_GET['v']);
//$party = sql("SELECT ant_votaciones FROM partidos WHERE id_partido = " . $user['id_partido']);
//Miramos si ya esta postulado

$sql = sql("SELECT * from candidatos_elecciones WHERE id_candidato = " . $_SESSION['id_usuario'] . " AND id_votacion = " . $_GET['v']);

if ($sql != false) {//Si esta postulado
    sql("DELETE FROM candidatos_elecciones WHERE id_candidato = ". $_SESSION['id_usuario'] . " AND id_votacion = " . $_GET['v']);
    echo getString("been_postulado");
} else {
    die(getString("no_postulated"));
}
?>
