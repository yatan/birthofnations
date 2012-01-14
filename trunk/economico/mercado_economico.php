<style type="text/css">
    #cuadro1
    {
        border: 1px solid #781351;
        width:270px;
    }
</style>


<h1>Mercado Economico</h1>
<?php

/*
 * Code started by: yatan
 * Batamanta Team
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/economico/moneda_local.php");

$sql = sql("SELECT * FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");

arsort($sql);

?>

<script type="text/javascript">
$(document).ready(function() {
        $("#alternar").click(function() { 
                var temp = $("#compra").val();
                $("#compra").val( $("#venta").val() );
                $("#venta").val( temp );
        });

}); 
</script>

<div id="cuadro1">
    
<form name="mercado_economico" id="mercado_economico" method="post" action="">
Comprar:
<select name="compra" id="compra">
    <?
    echo "<option>Gold</option>";
foreach ($sql as $moneda => $valor) {
    if(isset($_POST['compra']) && $moneda == $_POST['compra'])
        echo "<option selected='selected'>".$moneda."</option>"; 
    elseif($moneda!="id_usuario" && $moneda!="Gold")// <--- !!! que cojones id_usuario ?
        echo "<option>".$moneda."</option>";
}
?>
</select>
Vender:
<select name="venta" id="venta">
    <?
    echo "<option>Gold</option>";
foreach ($sql as $moneda => $valor) {
    if($moneda!="id_usuario" && $moneda!="Gold")
        if($moneda == $moneda_local[$objeto_usuario->moneda] && !isset($_POST['venta']))
            echo "<option selected='selected'>".$moneda."</option>";
        elseif(isset($_POST['venta']) && $moneda == $_POST['venta'])
            echo "<option selected='selected'>".$moneda."</option>";         
        else
            echo "<option>".$moneda."</option>";
    
}
?>
</select>
<br/>
<input type="button" value="Alternar Monedas" id="alternar"/>
<input type="submit" value="Buscar Ofertas"/>
</form>
    
</div>

<?
if(!isset($_POST['compra']))
    $compra = Gold;
else
    $compra = $_POST['compra'];


if(!isset($_POST['venta']))
    $compra = $objeto_usuario->moneda;
else
    $compra = $_POST['venta'];


?>

<br> <br>

<h2>Ofertas</h2>
<br>
<table style="width:400px;">
    <tr><td>Vendedor</td><td>Cantidad</td><td>Ratio</td><td>Comprar</td></tr> 
    <tr><td>yatan</td><td>432 Gold</td><td>1 Gold = 34 THK</td><td><input type="text" style="width:30px"/><input type="submit" /></td></tr>
</table>


<br> <br>