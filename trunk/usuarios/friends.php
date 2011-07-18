<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once("objeto_usuario.php");

echo "<h2>Amigos</h2>";

$cantidad = sql("SELECT COUNT(*) FROM friends WHERE id_amigo1='$id_usuario'");

if($cantidad==0)
    echo $txt['no_friends'];
elseif($cantidad==1)
{
    $sql = sql("SELECT id_amigo2 FROM friends WHERE id_amigo1='$id_usuario'");
    $usuario = new usuario($sql);
    echo $usuario->get_nick()."<br/>";
}
elseif($cantidad>1)
{
    $sql = sql("SELECT id_amigo2 FROM friends WHERE id_amigo1='$id_usuario'");
    foreach ($sql as $amigo) {
        
        $usuario = new usuario($amigo['id_amigo2']);
        echo $usuario->get_nick()."<br/>";
        
    }
}

?>
