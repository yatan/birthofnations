<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
/*
 * Code started by: yatan
 * Batamanta Team
 */

$id_oferta = $_POST['id_oferta'];
$vendedor = sql("SELECT id_vendedor FROM mercado_monetario WHERE id_oferta='$id_oferta'");

//Modulo de sobriedad (seguridad)
if($vendedor != $_SESSION['id_usuario'])
    die("Vas a estar baneado ¬¬");


sql("DELETE FROM mercado_monetario WHERE id_oferta='$id_oferta'");
echo getString('offer_cancel_ok');
?>
