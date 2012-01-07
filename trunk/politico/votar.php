<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if (isset($_GET['idv']) && strlen($_GET['idv']) > 0 && $_GET['idv'] != "" && isset($_GET['vot']) && strlen($_GET['vot']) > 0 && $_GET['vot'] != "") {

    //Re-revisar condiciones (por si las moscas) y que votamos por un candidato
    //Que no haya votado ya
    $sql = sql("SELECT * FROM log_votos WHERE id_usuario = " . $_SESSION['id_usuario'] . " AND id_votacion = " . $_GET['idv']);
    
    if($sql == false){//Si no ha votado
    sql("INSERT INTO log_votos(id_votacion,id_usuario,voto) VALUES (" . $_GET['idv'] . "," . $_SESSION['id_usuario'] . "," . $_GET['vot'] . ")");
    sql("UPDATE candidatos_elecciones SET votos = votos + 1 WHERE id_candidato = " . $_GET['vot'] . " AND id_votacion = " . $_GET['idv']);
    }else{
        echo getString('already_voted');
    }
}
?>
