<?php

//session_start();
include_once("../include/funciones.php");
include_once("../include/config_variables.php");
include_once("../usuarios/objeto_usuario.php");

$usuario = new usuario(16);
if (isset($_GET['x']) && isset($_GET['y']) && isset($_GET['zone'])) {
    $x = $_GET['x'];
    $y = $_GET['y'];
    $zona = $_GET['zone'];
    //info cuadro
    $lot = sql("SELECT * FROM map_zonas WHERE x=$x AND y=$y AND id_zona = $zona");
    if($lot['en_venta'] == 0)
    {
        die("DIAF");
    }
    //Pais de la zona
    $id_country = zona2country($zona);
    //moneda del pais
    $currency = moneda_pais($id_country);
    //dinero del user
    $cartera = sql("SELECT " . $currency . " FROM money WHERE id_usuario = $usuario->id_usuario");
    if ($cartera >= $lot['precio']) {//hay dinero
        //Quitar moneda
        $usuario->cambiar_moneda(-$lot['precio'], $currency);
        //Poner moneda al vendedor
        if ($lot['tipo_prop'] == 1) {
            sql("UPDATE money_pais SET " . $currency . " = " . $currency . " + " . $lot['precio'] . " WHERE idcountry = " . $lot['id_prop']);
        } elseif ($lot['tipo_prop'] == 2) {
            sql("UPDATE money SET " . $currency . " = " . $currency . " + " . $lot['precio'] . " WHERE id_usuario = " . $lot['id_prop']);
        }
        //Quitar la venta
        sql("UPDATE map_zonas SET en_venta = 0, precio = 0, id_prop = " . $usuario->id_usuario . ", tipo_prop = 2 WHERE x=$x AND y=$y AND id_zona = $zona");
    } else {//No dinero
        echo "Caca";
    }
}
else
    die(getString('not_enough_data'));
?>
