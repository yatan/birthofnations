<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Sustituir por error 404


$id_empresa = $_GET['id_empresa'];

var_dump($empresa);

//El objeto empresa ya esta declarado ya que este script se llama con include
$empresa = new empresa($id_empresa);


// Mostrar trabajadores

$work = mysql_query("SELECT id_usuario, nick FROM usuarios WHERE id_empresa = " . $id_empresa);

echo "<table>";
while ($worker = mysql_fetch_array($work)){
    echo "<tr><td>" . $worker['nick'] . '</td><td>[<a href="/economico/despedir.php?id_worker='.$worker['id_usuario'].'">Aceptar</a>]</td></tr>';
}
echo "</table>";

//Mostrar dineros.

$local = sql("SELECT pais FROM empresas WHERE id_empresa = " . $id_empresa);

$local = $moneda_local[$local];

$money = sql("SELECT gold, ". $local ." FROM empresas WHERE id_empresa = " . $id_empresa);

echo "Hay " . $money[$local] . " ". $local ." y " . $money['gold'] . " sugus en la empresa.";


echo "<h2>".$txt['Poner_ofertas_trabajo']."</h2>" ;
?>
    <div id="ofertas_trabajo">
        <form action="/economico/poner_oferta.php"  method="POST">
            <label for="salario">Salario:<input tabindex="1" type="text" name="salario"></label><br>
            <label for="cantidad">Cantidad:<input tabindex="1" type="text" name="cantidad"></label><br>
            <input tabindex="1" type="hidden" name="id_empresa" value="<?php echo $empresa->id_empresa; ?>">
            <input tabindex="1" type="hidden" name="id_pais" value="<?php echo $empresa->pais; ?>">
            <input type="submit">
        </form>
    </div><!--form de creacion de empresas-->
    <hr>
    <h2>Economia</h2>
    <table border="0">
        <tr>
            <td>Moneda</td><td>Cantidad</td>
        </tr>
       <?
       $sql = sql("SELECT gold, esp, frf FROM empresas WHERE id_empresa = '$empresa->id_empresa'");
       foreach ($sql as $moneda => $valor) {
       echo"
        <tr>
            <td>$moneda</td><td>$valor</td>
        </tr>";  
       }

       ?>
    </table>