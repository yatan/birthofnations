<?php

    session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");

if (isset($_POST['name']) && $_POST['name'] != "" && strlen($_POST['name']) != 0){

    $creador = $_SESSION['id_usuario'];
    sql("INSERT INTO country(name, date_of_birth) VALUES $name, GETDATE()"); 


}
?>