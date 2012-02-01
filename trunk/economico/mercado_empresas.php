<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");


if (isset($_GET['pais']))
    $country = $_GET['pais'];
else
    $country = $objeto_usuario->id_pais;

if (isset($_GET['producto']))
    $tipo = $_GET['producto'];
else
    $tipo = 1;
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
        window.location = '/<? echo $_GET['lang'] . "/mercado_empresas/" . $tipo . "/"; ?>'+arg+'/<? echo "0"; ?>';
    }
    function cambiar_item(arg) {
        window.location = '/<? echo $_GET['lang'] . "/mercado_empresas/"; ?>'+arg+'/<? echo "$country/0"; ?>';
    }
</script>

<select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
<?
$sql = sql("SELECT idcountry, name, url_bandera FROM country");
foreach ($sql as $pais1) {
    if ($pais1['idcountry'] == $objeto_usuario->id_pais && !isset($_GET['pais']))
        $seleccionado = "selected='selected'";
    elseif ($pais1['idcountry'] == $_GET['pais'] && isset($_GET['pais']))
        $seleccionado = "selected='selected'";
    else
        $seleccionado = "";

    echo "<option title='" . $pais1['url_bandera'] . "' $seleccionado value='" . $pais1['idcountry'] . "'>" . $pais1['name'] . "</option>";
}

echo getString('company_object_selection');
?></select>
    <select style="width:200px;" name="tipo" id="tipo" onchange="cambiar_item(this.value)">

        <?
        foreach (sql("SELECT * FROM items WHERE empresable = 1 ORDER BY id_item DESC") as $item) {
            if ($item['id_item'] == $tipo)
                $seleccion = "selected='selected'";
            else
                $seleccion = "";

            echo "<option value='" . $item['id_item'] . "' $seleccion title=''>" . $item['nombre'] . "</option>";
        }
        ?>
    </select><br/>

<?php
$empresas = sql2("SELECT empresas.id_empresa, tipo, nombre_empresa, mercado_empresas.precio FROM mercado_empresas  LEFT JOIN empresas ON empresas.id_empresa=mercado_empresas.id_empresa WHERE pais=" . $country . " AND tipo = " . $tipo . " ORDER BY precio ASC");

//Elegimos las empresas que esten en el mercado cuyo pais sea el elegido (ohh el elegido).

if ($empresas == null) {
    echo getString("no_selling_companies");
} else {
    echo "<table><tr><th>" . getString("type") . "</th><th>" . getString("name") . "</th><th>" . getString("precio") . "</th><th>" . getString("comprar") . "</th></tr>";
    foreach ($empresas as $empresa) {
        echo "<tr><td><img src='" . id2itemimg($tipo) . "'></td><td><a href='../../../empresa/".$empresa['id_empresa']."'>" . $empresa['nombre_empresa'] . "</a></td><td>" . $empresa['precio'] . "</td><td><a href='comprar_empresa.php?id=" . $empresa['id_empresa'] . "'>Comprar</a></td></tr>";
    }
}
?>
