
<div id="crear_empresa">
    <form id="empresa" action="../usuarios/envio_mensaje.php" method="POST">
        <h2>Creacion de empresas:</h2>
        <label for="nombre">Nombre:<input tabindex="1" type="text" name="nombre"></label><br>
        <label for="nombre">Mensaje:<input tabindex="1" type="text" name="msj"></label><br>
        <input type="button" id="enviar" value="Enviar">
    </form>
</div><!--form de creacion de empresas-->
<script>
    $('#enviar').click(function() {
  	$.post("../economico/crear_empresa.php", $("#empresa").serialize(),
        function(data){
                        alert(data);
                      } );
   
    });

</script>