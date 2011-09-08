<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

if(isset($_GET['pais']))
    $pais = $_GET['pais']; 
else
    $pais = sql("SELECT id_pais FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");

if(isset($_GET['producto']))
    $objeto = $_GET['producto']; 
else
    $objeto= 3;

$objeto = sql("SELECT id_item, nombre, marketable FROM items WHERE id_item = ". $objeto);

if(isset($_GET['pag']))
    $pagina = $_GET['pag']; 
else
    $pagina=0;
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
	window.location = '/<? echo $_GET['lang']."/mercado/".$objeto['id_item']."/"; ?>'+arg+'/<? echo "0"; ?>';
}
function cambiar_item(arg) {
	window.location = '/<? echo $_GET['lang']."/mercado/"; ?>'+arg+'/<? echo "$pais/0"; ?>';
}
</script>

<select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
<?
        $sql = sql("SELECT idcountry, name, url_bandera FROM country");
        foreach ($sql as $pais1) {
            if($pais1['idcountry']==sql("SELECT id_pais FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'") && !isset($_GET['pais']))
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
Seleccion de objeto
  <select style="width:200px;" name="objeto" id="objeto" onchange="cambiar_item(this.value)">
    
    <?
    foreach (sql("SELECT * FROM items WHERE marketable = 1") as $item) {
        if($item['id_item']==$objeto['id_item'])
            $seleccion = "selected='selected'";
        else
            $seleccion = "";
        
        echo "<option value='".$item['id_item']."' $seleccion title=''>".$item['nombre']."</option>";
    }
    ?>
  </select>

<?
echo "<h1>Mercado de objetos de: ".sql("SELECT name FROM country WHERE idcountry='$pais'")."</h1>";

//A partir de que registro se va a ver segun la pagina que estemos
$pag_resultados = $pagina * 10;

$ofertas = sql2("SELECT * FROM mercado_objetos WHERE id_pais = " . $pais . " AND id_item = '". $objeto['id_item'] ."' ORDER BY precio ASC LIMIT $pag_resultados, 10");

echo "<table><tr><th>Empresa</th><th>Precio</th><th>Cantidad</th><th>Comprar</th></tr>";

foreach ($ofertas as $oferta){
    
    $empresa = sql("SELECT nombre_empresa FROM empresas WHERE id_empresa = '" . $oferta['id_empresa']."'");
    
    echo " <tr><td>". $empresa ."</td><td>". $oferta['precio'] ."</td><td>". $oferta['cantidad'] .'</td><td>
<form action="/economico/comprar.php"  method="POST">
            <label for="cantidad"><input tabindex="1" type="text" name="cantidad"></label>
            <label for="id_oferta"><input tabindex="1" type="hidden" name="id_oferta" value = "'. $oferta['id_oferta'] .'"></label>
            <input type="submit" value="Comprar">
        </form>
</td> </tr>'  ;
    
}

echo "</table>";

$max_paginas = sql("SELECT COUNT(*) FROM mercado_objetos WHERE id_pais = " . $pais . " AND id_item = '". $objeto['id_item'] ."'")/10+1;
for($i=1;$i<=$max_paginas;$i++)
{   
    $pag = $i-1;
    echo "<a href='/".$_GET['lang']."/mercado/".$objeto['id_item']."/$pais/".$pag."'>$i </a>";
}
?>
