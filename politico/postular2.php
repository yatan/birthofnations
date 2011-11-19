<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$votacion = sql("SELECT id_votacion FROM votaciones WHERE tipo_votacion = " . $_GET['v'] . " AND solved = 0");

//Miramos si ya esta postulado

$sql = sql("SELECT * from candidatos_elecciones WHERE id_candidato = " . $_SESSION['id_usuario'] . " AND tipo_elecciones = " . $_GET['v']);

if ($sql == false) {

        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato,tipo_elecciones,votos) VALUES ('".$votacion."','". $_SESSION['id_usuario'] . "','".$_GET['v']."','0')");
        echo "Molas cantidubi, has sido postulado.";
  
} else {
    die("Ya estas postulado");
}
?>
