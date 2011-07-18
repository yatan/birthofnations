<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


$sql = sql("DESCRIBE money");
$i = -1;


foreach ($sql as $id => $name) {
    $moneda_local[$i] = $name['Field'];
    $i++;
}
$moneda_local[0] = "Gold";
unset($moneda_local[-1]);

?>
