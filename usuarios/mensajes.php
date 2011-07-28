<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$cantidad = sql("SELECT COUNT(id) FROM messages WHERE id_receptor ='".$_SESSION['id_usuario']."'");

$sql = sql2("SELECT * FROM messages WHERE id_receptor = " . $_SESSION['id_usuario']." AND deleted='0'");

//Se ponen todos como leidos
sql("UPDATE messages SET leido='1' WHERE id_receptor='".$_SESSION['id_usuario']."'");

echo "<table>";

    if($cantidad != 0)
    {
    foreach($sql as $msg){
        if($msg['id_emisor']==0)
            $nick="Sistema";
        else
            $nick = sql("SELECT nick FROM usuarios WHERE id_usuario = " . $msg['id_emisor']);
        echo '<tr><td>[<a href="/usuarios/borrar_mensaje.php?id='. $msg['id'] .'">Borrar</a>]</td><td>' . $nick . ": </td><td>". substr($msg['mensaje'], 0, 1000)."</td></tr>";
        }
    }
    else{
        echo "<p>".$txt['no_mensajes']."</p>";
    }
      
echo "</table>";
include("enviar_mensaje.php");
?>