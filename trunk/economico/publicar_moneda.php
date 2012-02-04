<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/economico/moneda_local.php");
/*
 * Code started by: yatan
 * Batamanta Team
 */
if(isset($_POST['compra']))
    $compra = $_POST['compra'];
else
    die(getString('generic_error'));

if(isset($_POST['venta']))
    $venta = $_POST['venta'];
else
    die(getString('generic_error'));

if($compra==$venta)
    die(getString ('monedas_iguales'));


if(isset($_POST['cantidad']) && $_POST['cantidad'] > 0)
{
    $cantidad = $_POST['cantidad'];
    $cantidad = str_replace(",",".",$cantidad);
    $cantidad = rfloor($cantidad, 2); // redondear
}
else
    die(getString('generic_error'));

if(isset($_POST['ratio']) && $_POST['ratio'] > 0)
{
    $ratio = $_POST['ratio'];
    $ratio = str_replace(",",".",$ratio);
    $ratio = rfloor($ratio, 2); // redondear
}
else
    die(getString('generic_error'));


$mi_id = $_SESSION['id_usuario'];

$id_compra = array_search($compra, $moneda_local);
$id_venta = array_search($venta, $moneda_local);

$mi_dinero = sql("SELECT $compra FROM money WHERE id_usuario='$mi_id'");
if($mi_dinero<$cantidad)
    die(getString('not_enough_money'));
else {
    sql("UPDATE money SET $compra = $compra - $cantidad");
    sql("INSERT INTO mercado_monetario (id_vendedor, tipo_moneda_comprar, tipo_moneda_vender, cantidad_moneda_comprar, cantidad_moneda_vender) VALUES ('$mi_id', '$id_compra', '$id_venta', '$cantidad', '$ratio')");
    echo "Se ha vendido $cantidad de $compra al ratio de 1 $compra = $ratio $venta";
}


?>
