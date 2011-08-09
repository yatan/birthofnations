<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
$id_pais = $_POST['id_pais'];

$sql = sql2("SELECT idregion, name FROM region WHERE idcountry='$id_pais'");
?>
Region:
<select name="region">
    <?
    foreach ($sql as $region) {
        echo "<option value='".$region['idregion']."'>".$region['name']."</option>";
    }
    ?>
</select>