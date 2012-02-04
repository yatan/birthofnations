<?php

//session_start();
include_once("../include/funciones.php");
include_once("../include/config_variables.php");
$precio = $_POST['precio'];
$id = $_POST['id'];

//Comprobamos que no este en la lisa

$sql = sql("SELECT * FROM mercado_empresas WHERE id_empresa = " . $id);

if ($sql == null) {//Si no esta
    if ($precio >= 0) {
        sql("INSERT INTO mercado_empresas(id_empresa, precio) VALUES (" . $id . "," . $precio . ")");
    }
} else {

    if ($precio == 0) {
        sql("DELETE FROM mercado_empresas WHERE id_empresa = " . $id);
    } else {
        sql("UPDATE mercado_empresas SET precio = " . $precio . " WHERE id_empresa = " . $id);
    }
}
?>
