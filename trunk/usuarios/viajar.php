<link rel="stylesheet" type="text/css" href="/css/dd.css" />
<script type="text/javascript" src="/js/jquery.dd.js"></script>

<script language="javascript">
$(document).ready(function(e) {
try {
$("#pais2").msDropDown();
} catch(e) {
alert(e.message);
}
});

function cambiar_pais2(arg) {
 $("#regi").load("/usuarios/v_lista_regiones.php", {id_pais: arg});	
}
</script>

<p>Para viajar es necesario un sugus por region, cuanto mas lejos, mas sugus</p>

<form id="viajar2">
Pais:
<select id="pais2" style="width:200px;" name="pais" onchange="cambiar_pais2(this.value)">
    <option></option>    
<?
    $sql = sql("SELECT idcountry, name, url_bandera FROM country ORDER BY name ASC");
    foreach ($sql as $pais) {
       echo "<option title='".$pais['url_bandera']."' value='".$pais['idcountry']."'>".$pais['name']."</option>";
    }
    ?>
</select>
<a id="regi"></a>
<br/>
    <input type="button" value="Viajar" id="enviar2"/>
</form>

<script>
    $('#enviar2').click(function() {
  	$.post("/usuarios/viaje.php", $("#viajar2").serialize(),
        function(data){
                        alert(data);
                        window.location.reload();
                      } );
   
    });
</script>