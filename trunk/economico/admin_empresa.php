<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Sustituir por error 404


$id_empresa = $_GET['id_empresa'];


//El objeto empresa ya esta declarado ya que este script se llama con include
$empresa = new empresa($id_empresa);


// Mostrar trabajadores

$workers = sql("SELECT nick FROM usuarios WHERE id_empresa = " . $id_empresa);

echo "<table>";
foreach ($workers as $worker ){
    echo "<tr><td>" . $worker['nick'] . "</td></tr>";
}
echo "</table>";

//Mostrar dineros.

$money = sql("SELECT capital_gold, capital FROM empresas WHERE id_empresa = " . $id_empresa);

echo "Hay " . $money['capital'] . " moneda local y " . $money['capital_gold'] . " sugus en la empresa.";

?>
