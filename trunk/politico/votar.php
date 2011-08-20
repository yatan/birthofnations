<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if (isset($_GET['idv']) && strlen($_GET['idv'])>0 && $_GET['idv'] != "" && isset($_GET['vot']) && strlen($_GET['vot'])>0 && $_GET['vot'] != ""){
    
    //Re-revisar condiciones
    
    sql("INSERT INTO log_votos(id_votacion,id_usuario,voto) VALUES (".$_GET['idv'].",".$_SESSION['id_usuario'].",".$_GET['vot'].")");
    sql("UPDATE candidatos_elecciones SET votos = votos + 1 WHERE id_candidato = " . $_GET['vot'] . " AND id_votacion = " . $_GET['idv']);
    
}


?>
