<?php

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");
    
/*
 * Code started by: yatan
 * Batamanta Team
 */

if(isset($_POST['cantidad']) && $_POST['cantidad']!="")
    $cantidad = $_POST['cantidad'];
else
    die("Error");

if(isset($_POST['id_oferta']) && $_POST['id_oferta']!="")
    $id_oferta = $_POST['id_oferta'];
else
    die("Error");



$oferta = sql("SELECT * FROM mercado_monetario WHERE id_oferta=$id_oferta");

var_dump($oferta);

if($cantidad > $oferta['cantidad_moneda_comprar'])
    die("La cantidad introducida se excede de la oferta");

$mi_id = $_SESSION['id_usuario'];

$moneda_vender = $moneda_local[$oferta['tipo_moneda_vender']];
$mi_dinero = sql("SELECT $moneda_vender FROM money WHERE id_usuario='$mi_id'");

if($mi_dinero < ( $oferta['cantidad_moneda_vender'] * $cantidad ) )
    die("No tienes tanto dinero para comprar");


echo "Vas a gastarte: ".$oferta['cantidad_moneda_vender'] * $cantidad ." ". $moneda_local[$oferta['tipo_moneda_vender']]. "<br>";
echo "Vas a comprar: ". $cantidad ." ". $moneda_local[$oferta['tipo_moneda_comprar']]. "<br>";

?>
