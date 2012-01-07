<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


echo "<h2>Amigos</h2>";

$cantidad = sql("SELECT COUNT(*) FROM friends WHERE id_amigo1='$id_usuario' AND peticion=1");

if($cantidad==0)
    echo $txt['no_friends'];
elseif($cantidad==1)
{
    $sql = sql("SELECT id_amigo2 FROM friends WHERE id_amigo1='$id_usuario' AND peticion=1");
    $usuario = new usuario($sql);
    echo "<a href='/".$_GET['lang']."/perfil/".$usuario->id_usuario."'>".$usuario->get_nick()."</a><br/>";
}
elseif($cantidad>1)
{
    $sql = sql("SELECT id_amigo2 FROM friends WHERE id_amigo1='$id_usuario' AND peticion=1");
    foreach ($sql as $amigo) {
        
        $usuario = sql("SELECT nick FROM usuarios WHERE id_usuario='{$amigo['id_amigo2']}'");
        echo "<a href='/".$_GET['lang']."/perfil/{$amigo['id_amigo2']}'>".$usuario."</a><br/>";
        
        
    }
}

?>
