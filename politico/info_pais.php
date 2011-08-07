<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);


$nombre_pais = $pais->nombre;
echo "<h1>$nombre_pais</h1>";

$leaders = $pais->list_leaders($id_pais);

echo "<table><tr><th>Nick</th><th>Posicion</th></tr>";

foreach ($leaders as $leader) {

    $name = sql("SELECT nick FROM usuarios WHERE id_usuario = " . $leader['idLeader']);

    echo "<tr><td>" . $name . "</td><td>" . $txt['pos_' . $leader['position']] . "</td></tr>";
}

echo "</table>";

echo "<h3>Dineros</h3>";

echo "<table><tr><th>Moneda</th><th>Cantidad</th></tr>";
echo sql("SELECT Gold FROM money_pais WHERE idcountry ='" . $id_pais . "'") . " " . $txt['gold'] . "<br/>";
$sql = sql("SELECT * FROM money_pais WHERE idcountry = " . $id_pais);

unset($sql['idcountry'],$sql['Gold']);
arsort($sql);

foreach ($sql as $moneda => $valor) {
    if($valor == 0){continue;}
    echo "<tr><td>" . $moneda . "</td><td>" . $valor . "</td></tr>";
}

echo "</table>";
?>
