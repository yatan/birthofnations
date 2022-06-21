<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/birthofnations/include/funciones.php");
$id_pais = $_POST['id_pais'];

if ($id_pais == 0)
    die("Pais incorrecto");

$sql = sql2("SELECT idregion, name FROM region WHERE idcountry='$id_pais'");

if ($sql == false)
    die("No hay regiones en el pais seleccionado");
?>
Region:
<select name="region">
    <?php
    foreach ($sql as $region) {
        echo "<option value='" . $region['idregion'] . "'>" . $region['name'] . "</option>";
    }
    ?>
</select>