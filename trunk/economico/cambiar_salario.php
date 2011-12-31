<?php

//session_start();
include_once("../include/funciones.php");
include_once("../include/config_variables.php");

if (isset($_POST['salario']) && $_POST['salario'] != "" && is_numeric($_POST['salario'])) {
    if($_POST['salario'] > 0) {//Comprobaciones varias
        sql("UPDATE usuarios SET salario = " . $_POST['salario'] . " WHERE id_usuario = " . $_POST['worker']);

        echo getString('salary_succesfully_changed');
    } else {
        echo getString('increase_salary');
    }
} else {

    die(getString("not_enough_data"));
}
?>