<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Sustituir por error 404


$id_empresa = $_GET['id_empresa'];

//var_dump($empresa);

//El objeto empresa ya esta declarado ya que este script se llama con include
$empresa = new empresa($id_empresa);

echo "<br>Empresa: " . $empresa->nombre_empresa . " (" . $empresa->get_tipo() . ")";
echo "<br>Stock: " .$empresa->stock . " Raw: " . $empresa->raw;

// Mostrar trabajadores

$work = mysql_query("SELECT id_usuario, nick, salario FROM usuarios WHERE id_empresa = " . $id_empresa);

echo "<table>";
while ($worker = mysql_fetch_array($work)){
    echo "<tr><td>" . $worker['nick'] . '</td><td>'. $worker['salario'] .'</td><td>[<a href="/economico/despedir.php?id_worker='.$worker['id_usuario'].'">Despedir</a>]</td></tr>';
}
echo "</table>";

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
    </div><!--form de ofertas de trabajo-->
    <hr>
    <h3>Puestos ofertados</h3>
    <table border="0">
        <tr>
            <td>Salario</td><td>Cantidad</td>
        </tr>
    <?
    $cantidad = sql("SELECT COUNT(id_empresa) FROM mercado_trabajo WHERE id_empresa ='".$_GET['id_empresa']."'");
    
    $sql = sql("SELECT id_oferta, salario, cantidad FROM mercado_trabajo WHERE id_empresa = '".$_GET['id_empresa']."' ORDER BY salario DESC");
    if($cantidad > 1)
    {
    foreach($sql as $oferta){
        echo "<tr><td>". $oferta['salario'] ."</td><td>". $oferta['cantidad'] .'</td><td>[<a href="/economico/quitar_oferta.php?id_oferta='.$oferta['id_oferta'].'">Quitar</a>]</td></tr>';
        
        }
    }
    elseif($cantidad==0)
        echo "<p>".$txt['no_ofertas_trabajo']."</p>";
    elseif($cantidad==1)
        echo "<tr><td>". $sql['salario'] ."</td><td>". $sql['cantidad'] .'</td><td>[<a href="/economico/quitar_oferta.php?id_oferta='.$sql['id_oferta'].'">Quitar</a>]</td></tr>';
        
    
    ?>
    </table>
        
    <h2>Economia</h2>
    <table border="0">
        <tr>
            <td>Moneda</td><td>Cantidad</td>
        </tr>
       <?
       $sql = sql("SELECT * FROM empresas WHERE id_empresa = '$empresa->id_empresa'");
       foreach ($moneda_local as $id => $nombre) {
       echo"
        <tr>
            <td>$nombre</td><td>$sql[$nombre]</td>
        </tr>";  
       }

       ?>
    </table>
    
    <h3>Dineros</h3>
    <form id="dineros">
        <label for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" id="cantidad"/>
        <label for="moneda">Moneda:</label>
         <select id="moneda" name="moneda">
          <? 
          
          $sql = mysql_query("SELECT * FROM money");
          for($n=1;$n<mysql_num_fields($sql);$n++) {
              
              $mon = mysql_field_name($sql,$n);
              echo"<option value='1'> $mon </option>";
              
          }
          
          
          ?>
         </select></br>
        <input type="button" name="retirar" id="retirar" value="Retirar"/>
        <input type="button" name="ingresar" id="ingresar" value="Ingresar"/>
    </form>