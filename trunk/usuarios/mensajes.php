<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$cantidad = sql("SELECT COUNT(id) FROM messages WHERE id_receptor ='".$_SESSION['id_usuario']."'");

$sql = sql("SELECT * FROM messages WHERE id_receptor = " . $_SESSION['id_usuario']);

echo "<table>";

    if($cantidad > 1)
    {
    foreach($sql as $msg){
        echo "<tr><td>" . $msg['nick_emisor'] . ": </td><td>". $msg['mensaje'] ."</td></tr>";
        }
    }
    elseif($cantidad==0)
        echo "<p>".$txt['no_mensajes']."</p>";
    elseif($cantidad==1)
        echo '<tr><td>[<a href="/usuarios/borrar_mensaje.php?id=' .$sql['id']. '">Borrar</a>]</td><td>'. $sql['nick_emisor'] .": </td> <td>". $sql['mensaje'] .'</td></tr>';
      
echo "</table>";

?>