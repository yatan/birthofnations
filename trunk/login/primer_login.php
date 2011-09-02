<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$pais_actual = sql("SELECT id_pais FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
if($pais_actual != null)
    header("Location: ../");

include("../index_head.php");
?>
<style>
div.ui-dialog a.ui-dialog-titlebar-close {
display: none;
}
</style>

<script language="javascript">
	$(function() {
		$( "#dialog" ).dialog({draggable: false, resizable: false});
	});
        
function cambiar_pais(arg) {
    $("#regi").load("/usuarios/v_lista_regiones.php", {id_pais: arg});	
}
</script>

<div id="dialog" title="Bienvenido a Birth of Nations">
	<p>Este es tu primer login al juego, selecciona tu destinación...</br>Blah, blah, blah</p>
        <p>Seleccionar pais destino:</p>
        <form id="viaje">
            <select id="pais" name="pais" onchange="cambiar_pais(this.value)">
                <option value="0">-</option>
                <?
                $sql = sql("SELECT idcountry, name FROM country WHERE EXISTS ( SELECT * FROM region WHERE region.idcountry = country.idcountry )");
                foreach ($sql as $pais) {
                    echo "<option value='".$pais['idcountry']."'>".$pais['name']."</option>";
                }
                ?>
                </select>
            <a id="regi"><p></p></a><br>
            <input type="hidden" name="tokken" value="<? echo base64_encode($_SESSION['id_usuario']); ?>"/>
            <input type="button" value="Viajar" id="enviar"/>
        </form>
</div>

<script>
    $('#enviar').click(function() {
  	$.post("primer_viaje.php", $("#viaje").serialize(),
        function(data){
                        alert(data);
                        window.location.reload();
                      } );
   
    });
</script>
