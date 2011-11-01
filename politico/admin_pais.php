<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");


//Temporal hasta que se ponga en el hta
$_GET['id_pais']=2;

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);


$nombre_pais = $pais->nombre;
echo "<h1>$nombre_pais</h1><img alt='bandera' title='".$pais->nombre."' src='".$pais->bandera."'/>";

echo "Poblacion actual: " . $pais->population();

echo "<h3>Líderes</h3>";

include("./list_leader.php");

echo "</table>";

echo "<h3>Dineros</h3>";

echo "<table><tr><th>Moneda</th><th>Cantidad</th></tr>";
$gold = sql("SELECT Gold FROM money_pais WHERE idcountry ='" . $id_pais . "'");

echo "<tr><td>" . $txt['Gold'] . "</td><td>" . $gold . "</td></tr>";
$sql = sql("SELECT * FROM money_pais WHERE idcountry = " . $id_pais);

unset($sql['idcountry'], $sql['Gold']);
arsort($sql);

foreach ($sql as $moneda => $valor) {
    if ($valor == 0) {
        continue;
    }
    echo "<tr><td>" . $moneda . "</td><td>" . $valor . "</td></tr>";
}

echo "</table>";

echo "<h3>Regiones</h3>";

$regiones = $pais->list_regions();

if ($regiones == false) {
    echo $txt['no_regions'];
} else {

    echo "<table><tr><th>Nombre</th></tr>";

    foreach ($regiones as $region) {

        echo "<tr><td><a href='../region/" . $region['idregion'] . "'>" . $region['name'] . "</a></td></tr>";
    }

    echo "</table>";
}
?>
