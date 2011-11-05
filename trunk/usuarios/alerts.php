<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo "<h1>Alertas</h1>";


$alertas = sql2("SELECT * FROM alertas WHERE id_receptor='".$_SESSION['id_usuario']."' ORDER BY id_alerta DESC");

echo "<form id='borrar_alertas'>";

foreach ($alertas as $alerta) {
    echo id2nick($alerta['id_emisor'])." quiere ser tu amigo. <a href='#'>Añadir a amigos</a> <input type='checkbox' name='alertas[]' value='".$alerta['id_alerta']."'/>";
    echo "<hr>";
}


?>


</form>



<button id='eliminar'>Eliminar</button>



<script>

  $(document).ready(function() {
    $("#eliminar").button();
  });
  
  $('#eliminar').click(function() {
        
            $.post("/usuarios/delete_alerts.php", $("#borrar_alertas").serialize(),
    function(data){
                    alert(data);
                    window.location.reload();
                  } );

    });  
</script>
<?
//Ponemos todas las alertas como leidas
sql("UPDATE alertas SET leido='1' WHERE id_receptor='".$_SESSION['id_usuario']."'");
?>
