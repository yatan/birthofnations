<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$user = sql("SELECT id_partido, id_nacionalidad, ant_partido FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
$votacion = sql("SELECT * FROM votaciones WHERE id_votacion = " . $_GET['v']);
$party = sql("SELECT ant_votaciones FROM partidos WHERE id_partido = " . $user['id_partido']);

//Miramos si ya esta postulado

$sql = sql("SELECT * from candidatos_elecciones WHERE id_candidato = " . $_SESSION['id_usuario'] . " AND id_votacion = " . $_GET['v']);

if ($sql == false) {

    if ($user['id_partido'] == $votacion['param1'] && $user['ant_partido'] >= $party['ant_votaciones']) {
        //Condiciones para la postulacion
        // 1. Esta afiliado
        // 2. Llevar dentro una cantidad de tiempo determinada por el lider (ant_votaciones)

        sql("INSERT INTO candidatos_elecciones(id_votacion,id_candidato,tipo_elecciones,votos) VALUES ('" . $_GET['v'] . "','" . $_SESSION['id_usuario'] . "','1','0')");
        echo "Molas cantidubi, has sido postulado.";
    } else {

        echo "El amado lider te mira con desaprobacion, no cumples algun requisito para postularte";
    }
} else {
    die("Ya estas postulado");
}
?>
