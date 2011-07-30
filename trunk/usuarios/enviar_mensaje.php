
<div id="crear_empresa">
    <form id="empresa">
        <h2>Envio de mensajes</h2>
        <label for="nombre">Nick:<input tabindex="1" type="text" name="nombre"></label><br>
        <label for="markItUp">Mensaje:<textarea id="markItUp" cols="60" rows="10" tabindex="1" name="msj"></textarea></label><br>
        <input type="button" id="enviar" value="Enviar">
    </form>
</div><!--form de creacion de empresas-->
<script>
    $('#enviar').click(function() {
  	$.post("/usuarios/envio_mensaje.php", $("#empresa").serialize(),
        function(data){
                        alert(data);
                      } );
   
    });

</script>