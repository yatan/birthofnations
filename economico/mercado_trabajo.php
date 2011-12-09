<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

//$id_pais = 1; //Sea como sea que se seleccione

if(isset($_GET['pais']))
    $pais = $_GET['pais']; 
else
    $pais = $objeto_usuario->id_pais;

if(isset($_GET['producto']))
    $objeto = $_GET['producto']; 
else
    $objeto= 1;

$objeto = sql("SELECT id_item, nombre, marketable FROM items WHERE id_item = ". $objeto);

if(isset($_GET['pag']))
    $pagina = $_GET['pag']; 
else
    $pagina=0;

$moneda = moneda_pais($pais);
?>
<link rel="stylesheet" type="text/css" href="/css/dd.css" />
<script type="text/javascript" src="/js/jquery.dd.js"></script>
<script language="javascript">
$(document).ready(function(e) {
try {
$("#pais").msDropDown();
} catch(e) {
alert(e.message);
}
});
function cambiar_pais(arg) {
	window.location = '/<? echo $_GET['lang']."/mercado_laboral/".$objeto['id_item']."/"; ?>'+arg+'/<? echo "0"; ?>';
}
</script>

<select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
<?
        $sql = sql("SELECT idcountry, name, url_bandera FROM country");
        foreach ($sql as $pais1) {
            if($pais1['idcountry']==$objeto_usuario->id_pais && !isset($_GET['pais']))
                $seleccionado = "selected='selected'";
            elseif($pais1['idcountry']==$_GET['pais'])
                $seleccionado = "selected='selected'";
            else
                $seleccionado = "";
            
            echo "<option title='".$pais1['url_bandera']."' $seleccionado value='".$pais1['idcountry']."'>".$pais1['name']."</option>";
        }
?>
</select>
<br/>
<?
$ofertas = mysql_query("SELECT * FROM mercado_trabajo WHERE id_pais = " . $pais . " ORDER BY salario DESC");

echo "<table><tr><th>Empresa</th><th>Jefe</th><th>Salario</th><th>Puestos</th></tr>";

while ($oferta = mysql_fetch_array($ofertas)){
    $sql = sql("SELECT nombre_empresa FROM empresas WHERE id_empresa='".$oferta['id_empresa']."'");
    $jefe = sql("SELECT nick FROM usuarios WHERE id_usuario = '". $oferta['id_jefe'] ."' " );
    echo "<tr><td>".$sql."</td><td>". $jefe ."</td><td>". $oferta['salario'] ."</td><td>". $oferta['cantidad'] .'</td><td>[<a href="/economico/aceptar_trabajo.php?oferta='.$oferta['id_oferta'].'">Aceptar</a>]</td></tr>';
        
}
echo "</table>";
?>
