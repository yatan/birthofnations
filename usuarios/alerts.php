<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

echo "<h1>Alertas</h1>";


$alertas = sql2("SELECT * FROM alertas WHERE id_receptor='".$_SESSION['id_usuario']."' AND tipo <> 0 ORDER BY id_alerta DESC");

echo "<form id='borrar_alertas'><table style='text-align: center; width: 600px; margin-left: auto; margin-right: auto; padding: 5px;'><tr><th style='width: 100px'>Tipo</th><th style='width: 310px'>Alerta</th><th>Eliminar</th></tr>";

foreach ($alertas as $alerta) {
    
    switch ($alerta['tipo']) {
        case "1":
            echo "<tr><td>Amigo</td><td>";
            echo id2nick($alerta['id_emisor'])." quiere ser tu amigo. <a href='../usuarios/add_friend.php?ai=".$alerta['id_emisor']."'>Aceptar</a></td>";
            break;
        case "2":
            echo "<tr><td>Trabajador</td><td>";
            echo id2nick($alerta['id_emisor'])." ahora trabaja en <b>".id2empresa($alerta['r1'])."</b></td>";
            break;           
        case "3":
            echo "<tr><td>Jugador</td>";
            echo "<td>Felicidades has subido al level ".$alerta['r1']."</td>";
            break;
        case "4":
            echo "<tr><td>Trabajador</td>";
            echo "<td>El jugador ".id2nick($alerta['id_emisor'])." no puede trabajar en <b>".id2empresa($alerta['r1'])."</b> porque no hay raw suficiente. Se han eliminado las ofertas de trabajo de la empresa</td>";
            break;   
        case "5":
            echo "<tr><td>Trabajador</td>";
            echo "<td>El jugador ".id2nick($alerta['id_emisor'])." no puede trabajar en <b>".id2empresa($alerta['r1'])."</b> porque no hay dinero suficiente. Se han eliminado las ofertas de trabajo de la empresa</td>";
            break;  
        case "6":
            echo "<tr><td>Economia</td>";
            $cosas = explode(",", $alerta['r1']);
            echo "<td>El jugador ".id2nick($alerta['id_emisor'])." ha comprado {$cosas['0']} {$cosas['1']} con ratio: 1 {$cosas['1']} = {$cosas['3']} {$cosas['2']} en el mercado economico.</td>";
            break;   
        case "7":
            echo "<tr><td>Empresa</td>";
            echo "<td>El jugador ".id2nick($alerta['id_emisor'])." te ha despedido de <b>".$alerta['r1']."</b>.</td>";
            break;         
        case "8":
            echo "<tr><td>Jugador</td>";
            echo "<td>Has ganado 2 gold <img src='/images/status_bar/gold.gif'/> por subir a nivel <b>".$alerta['r1']."</b>.</td>";
            break; 
        
        
        default:
            break;
    }
//El boton de eliminar alerta que aparece en cada alerta    
echo "<td><input type='checkbox' name='alertas[]' value='".$alerta['id_alerta']."'/></td></tr>";
}


?>

</table>
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
<?php
//Ponemos todas las alertas como leidas
sql("UPDATE alertas SET leido='1' WHERE id_receptor='".$_SESSION['id_usuario']."'");
?>
