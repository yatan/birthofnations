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

<script>
	$(function() {
		$( "#dialog" ).dialog({draggable: false, resizable: false});
	});
</script>

<div id="dialog" title="Bienvenido a Birth of Nations">
	<p>Este es tu primer login al juego, selecciona tu destinación...</br>Blah, blah, blah</p>
        <p>Seleccionar pais destino:</p>
        <form id="viaje">
            <select id="pais" name="pais">
                <?
                $sql = sql("SELECT idcountry, name FROM country");
                foreach ($sql as $pais) {
                    echo "<option value='".$pais['idcountry']."'>".$pais['name']."</option>";
                }
                ?>
                </select>
            <input type="hidden" name="tokken" value="<? echo base64_encode($_SESSION['id_usuario']); ?>"/>
            <input type="button" value="Viajar" id="enviar"/>
        </form>
        <p>Regiones aun no implementadas</p>
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
