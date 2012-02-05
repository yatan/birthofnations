<style type="text/css">
    #cuadro1
    {
        border: 1px solid #781351;
        width:270px;
    }
    .base_economico
    {
        width:60%;
        float: left;
        
    }
    .base_nueva_oferta
    {
        float:right;
        
    }
</style>


<table>
    <tr>
        <td style="width:65%;" valign="top" align="center">
<?php
echo "<h1>".getString('mercado_economico')."</h1>";
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
        
        $("#alternar2").click(function() { 
                var temp = $("#compra2").val();
                $("#compra2").val( $("#venta2").val() );
                  $("#moneda_compra").text($("#venta2").val());
                  $("#moneda_compra2").text($("#venta2").val());
                $("#venta2").val( temp );
                

                $("#moneda_venta").text(temp);
        });

}); 

function cambiar_compra(arg) {
    $("#moneda_compra").text(arg);
    $("#moneda_compra2").text(arg);
}
function cambiar_venta(arg) {
    $("#moneda_venta").text(arg);
}
</script>

<div id="cuadro1">
    
<form name="mercado_economico" id="mercado_economico" method="post" action="">
<? echo getstring('comprar'); ?>:
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
<? echo getstring('vender'); ?>:
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
<input type="button" value="<? echo getstring('alternate_money'); ?>" id="alternar"/>
<input type="submit" value="<? echo getstring('search_offers'); ?>"/>
</form>
    
</div>

<?
if(!isset($_POST['compra']))
    $compra = "Gold";
else
    $compra = $_POST['compra'];


if(!isset($_POST['venta']))
    $venta = $moneda_local[$objeto_usuario->moneda];
else
    $venta = $_POST['venta'];


$id_moneda_compra = array_search($compra, $moneda_local);
$id_moneda_venta = array_search($venta, $moneda_local);

?>

<br> <br>
    
<h2><? echo getString('Ofertas'); ?></h2>

<?


$ofertas = sql2("SELECT * 
    FROM mercado_monetario 
    WHERE tipo_moneda_comprar = '$id_moneda_compra' AND tipo_moneda_vender = '$id_moneda_venta' AND cantidad_moneda_comprar>0 ORDER BY cantidad_moneda_vender ASC");

//var_dump($ofertas);
?>


<table style="width:400px;">
    <?
    echo "<tr><td>".getstring('seller')."</td><td>".getstring('cantidad')."</td><td>Ratio</td><td>".getstring('comprar')."</td></tr>";
    
    foreach ($ofertas as $oferta){
        echo "<form id='oferta_{$oferta['id_oferta']}' action='/economico/comprar_moneda.php' method='post'><input type='hidden' name='id_oferta' value='{$oferta['id_oferta']}'><tr><td><a href='perfil/{$oferta['id_vendedor']}'>".id2nick($oferta['id_vendedor'])."</a></td><td>{$oferta['cantidad_moneda_comprar']} $compra</td><td>1 $compra = {$oferta['cantidad_moneda_vender']} $venta</td><td><input name='cantidad' type='text' style='width:30px'/><input type='button' value='Ok' id='oferta_{$oferta['id_oferta']}' class='comprar'/></td></tr></form>";
    }
   ?>
</table>


</td><td style="width:35%;" valign="top" align="center">

    <h2>Mis ofertas</h2>
    
    <div id="cuadro1">
    
<form name="publicar_moneda" id="publicar_moneda" method="post" action="">
<? echo getstring('offer'); ?>:
<select name="compra" id="compra2" onchange="cambiar_compra(this.value)">
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
<? echo getstring('comprar'); ?>:
<select name="venta" id="venta2"  onchange="cambiar_venta(this.value)">
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
<input type="button" value="<? echo getstring('alternate_money'); ?>" id="alternar2"/>

<p>Offer <input name="cantidad" type="text" style="width: 30px;" value="0.00"/> <a id="moneda_compra"></a> at rate</p>
<p>1 <a id="moneda_compra2"></a> = <input name="ratio" type="text" style="width: 30px;" value="0.00"/> <a id="moneda_venta"></a></p>
<input class="publicar" type="button" value="<? echo getstring('post_offer'); ?>"/>
</form>
   
   
    </div><!-- Fin cuadro mis ventas -->

<table>
    <tr>
        <td>Cantidad</td><td>Ratio</td><td>Cancelar</td>
    </tr>
    <?
    
    $mis_ofertas = sql2("SELECT * FROM mercado_monetario WHERE id_vendedor = $objeto_usuario->id_usuario");
    foreach ($mis_ofertas as $oferta) {
        echo "<tr style='font-size:12px;'>";
        echo "<td>{$oferta['cantidad_moneda_comprar']} {$moneda_local[$oferta['tipo_moneda_comprar']]}</td><td>1 {$moneda_local[$oferta['tipo_moneda_comprar']]} = {$oferta['cantidad_moneda_vender']} {$moneda_local[$oferta['tipo_moneda_vender']]}</td><td style='background:red; color:black;' id='{$oferta['id_oferta']}' class='cancelar_oferta'>CANCELAR</td>"; 
        echo "</tr>";
        
        }
    ?>
</table>     

<br>
<script type="text/javascript">
$(document).ready(function() {
    var compra = $("#compra2").val();
    var venta = $("#venta2").val();
    $("#moneda_compra").text(compra);
    $("#moneda_compra2").text(compra);
    $("#moneda_venta").text(venta);
});
    
    $('.cancelar_oferta').click(function() {
        var element = $(this);
        var Id = element.attr("id");
        
        
        var notice = $.pnotify({
        pnotify_title: "<? echo getstring('offer_cancel'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        pnotify_hide: false,
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.post("/economico/eliminar_oferta_monetaria.php", {id_oferta: Id},
         function(data) {
          var options = {
                pnotify_text: data
            };
            notice.pnotify(options);
            setTimeout(function() { 
                window.location.reload();
                },750);
         });
         
         
    });
    
    
    $('.comprar').click(function() {
        var element = $(this);
        var Id = element.attr("id");
        
         var notice = $.pnotify({
        pnotify_title: "<? echo getstring('comprar'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        pnotify_hide: false,
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.post("/economico/comprar_moneda.php", $('#'+Id).serialize(),
         function(data) {
          var options = {
                pnotify_text: data
            };
            notice.pnotify(options);
            setTimeout(function() { 
                window.location.reload();
                },750);
         });
 
 
    }); 
    
    
    
    $('.publicar').click(function() {
       
        var notice = $.pnotify({
        pnotify_title: "<? echo getstring('comprar'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        pnotify_hide: false,
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.post("/economico/publicar_moneda.php", $('#publicar_moneda').serialize(),
         function(data) {
          var options = {
                pnotify_text: data
            };
            notice.pnotify(options);
            setTimeout(function() { 
                window.location.reload();
                },750);
         });
 
 
    }); 
</script>    


</td>
    </tr>
</table>

<br> <br>