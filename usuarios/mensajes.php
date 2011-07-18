<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$cantidad = sql("SELECT COUNT(id) FROM messages WHERE id_receptor ='".$_SESSION['id_usuario']."'");

$sql = sql2("SELECT * FROM messages WHERE id_receptor = " . $_SESSION['id_usuario']);


echo "<table>";

    if($cantidad != 0)
    {
    foreach($sql as $msg){
        $nick = sql ("SELECT nick FROM usuarios WHERE id_usuario = " . $msg['id_emisor']);
        echo '<tr><td>[<a href="/usuarios/borrar_mensaje.php?id='. $msg['id'] .'">Borrar</a>]</td><td>' . $nick . ": </td><td>". $msg['mensaje'] ."</td></tr>";
        }
    }
    else{
        echo "<p>".$txt['no_mensajes']."</p>";
    }
      
echo "</table>";
include("enviar_mensaje.php");
?>