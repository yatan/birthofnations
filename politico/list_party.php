<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);
$nombre_pais = $pais->nombre;

echo "<h1>Partidos politicos en: $pais->nombre <img alt='bandera' title='".$pais->nombre."' src='".$pais->bandera."'/></h1>";
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
	window.location = '/<? echo $_GET['lang']."/partidos/"; ?>'+arg;
}
</script>

<select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
<?
        $sql = sql("SELECT idcountry, name, url_bandera FROM country");
        foreach ($sql as $pais1) {
            if($pais1['idcountry']==$id_pais)
                $seleccionado = "selected='selected'";
            else
                $seleccionado = "";
            
            echo "<option title='".$pais1['url_bandera']."' $seleccionado value='".$pais1['idcountry']."'>".$pais1['name']."</option>";
        }
?>
</select>

<?
$partidos = sql("SELECT * FROM partidos WHERE id_pais='$pais->id'");

foreach ($partidos as $partido) {
    echo "<a href='/".$_GET['lang']."/partido/".$partido['id_partido']."'>".$partido['nombre_partido']." Lider: ".id2nick($partido['id_lider'])."</a><br>";
}
?>
