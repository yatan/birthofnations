<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if (isset($_GET['idv']) && strlen($_GET['idv'])>0 && $_GET['idv'] != "" && isset($_GET['vot']) && strlen($_GET['vot'])>0 && $_GET['vot'] != ""){
    
    sql("INSERT INTO log_votos(id_votacion,id_usuario,voto) VALUES (".$_GET['idv'].",".$_SESSION['id_usuario'].",".$_GET['vot'].")");
    
}


?>
