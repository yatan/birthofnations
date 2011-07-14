
<div id="crear_empresa">
    <form id="empresa" action="../economico/crear_empresa.php" method="POST">
        <h2>Creacion de empresas:</h2>
        <label for="nombre">Nombre:<input tabindex="1" type="text" name="nombre"></label><br>
        <label for="pass">Tipo:<select name="tipo">
                <option value=1>Fábrica de Sugus</option>
                <option value=2>Fábrica de Az�car</option></select>
        </label><br>
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