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
    
<form name="mercado_economico" id="mercado_economico">
Comprar:
<select name="compra" id="compra">
    <?
    echo "<option>Gold</option>";
foreach ($sql as $moneda => $valor) {
    if($moneda!="id_usuario" && $moneda!="Gold")
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
    echo "<option>".$moneda."</option>";
}
?>
</select>
<br/>
<input type="button" value="Alternar Monedas" id="alternar"/>
<input type="submit" value="Buscar Ofertas"/>
</form>
    
</div>