<?php

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");
    
/*
 * Code started by: yatan
 * Batamanta Team
 */

if(isset($_POST['cantidad']) && $_POST['cantidad']!="")
{
    $cantidad = $_POST['cantidad'];
    $cantidad = str_replace(",",".",$cantidad); //Comas por puntos
    $cantidad = rfloor($cantidad, 2); // redondear
        if($cantidad <= 0.00 )
        die(getString('offer_lower_zero'));
}
else
    die("Error");

if(isset($_POST['id_oferta']) && $_POST['id_oferta']!="")
    $id_oferta = $_POST['id_oferta'];
else
    die("Error");

if($cantidad<=0)
    die("Error");


$oferta = sql("SELECT * FROM mercado_monetario WHERE id_oferta=$id_oferta");

//var_dump($oferta);

if($cantidad > $oferta['cantidad_moneda_comprar'])
    die("La cantidad introducida se excede de la oferta");

$mi_id = $_SESSION['id_usuario'];

if($oferta['id_vendedor']==$mi_id)
    die("No te puedes comprar a ti mismo");

$moneda_vender = $moneda_local[$oferta['tipo_moneda_vender']];
$mi_dinero = sql("SELECT $moneda_vender FROM money WHERE id_usuario='$mi_id'");

if($mi_dinero < ( $oferta['cantidad_moneda_vender'] * $cantidad ) )
    die("No tienes tanto dinero para comprar");


echo "Te has gastado: ".$oferta['cantidad_moneda_vender'] * $cantidad ." ". $moneda_local[$oferta['tipo_moneda_vender']]. "<br>";
echo "Te has comprado: ". $cantidad ." ". $moneda_local[$oferta['tipo_moneda_comprar']]. "<br>";

//Se resta la cantidad comprada de la oferta
sql("UPDATE mercado_monetario SET cantidad_moneda_comprar = cantidad_moneda_comprar - $cantidad WHERE id_oferta=$id_oferta");
//Se añade la moneda que compro
sql("UPDATE money SET ".$moneda_local[$oferta['tipo_moneda_comprar']]." = ".$moneda_local[$oferta['tipo_moneda_comprar']]." + $cantidad WHERE id_usuario=$mi_id");
//Se resta de mi dinero el dinero que cuesta la oferta
sql("UPDATE money SET ".$moneda_local[$oferta['tipo_moneda_vender']]." = ".$moneda_local[$oferta['tipo_moneda_vender']]." - ". $cantidad * $oferta['cantidad_moneda_vender'] . " WHERE id_usuario=$mi_id");
//Se le añade el dinero al vendedor
sql("UPDATE money SET ".$moneda_local[$oferta['tipo_moneda_vender']]." = ".$moneda_local[$oferta['tipo_moneda_vender']]." + ". $cantidad * $oferta['cantidad_moneda_vender'] . " WHERE id_usuario=".$oferta['id_vendedor']);

$datos = $cantidad.",".$moneda_local[$oferta['tipo_moneda_comprar']].",".$moneda_local[$oferta['tipo_moneda_vender']].",".$oferta['cantidad_moneda_vender'];
send_alert($mi_id, $oferta['id_vendedor'], "6", $datos);

?>
