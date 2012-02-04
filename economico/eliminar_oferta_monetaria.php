<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/economico/moneda_local.php");
/*
 * Code started by: yatan
 * Batamanta Team
 */

$id_oferta = $_POST['id_oferta'];
$vendedor = sql("SELECT id_vendedor FROM mercado_monetario WHERE id_oferta='$id_oferta'");
$moneda = sql("SELECT tipo_moneda_comprar FROM mercado_monetario WHERE id_oferta='$id_oferta'");
$cantidad = sql("SELECT cantidad_moneda_comprar FROM mercado_monetario WHERE id_oferta='$id_oferta'");
//Modulo de sobriedad (seguridad)
if($vendedor != $_SESSION['id_usuario'])
    die("Vas a estar baneado ¬¬");

$moneda = $moneda_local[$moneda];
sql("DELETE FROM mercado_monetario WHERE id_oferta='$id_oferta'");
sql("UPDATE money SET $moneda = $moneda + $cantidad WHERE id_usuario='$vendedor'");

echo getString('offer_cancel_ok');
?>
