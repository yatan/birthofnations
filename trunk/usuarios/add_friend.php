<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");


//Comprobar que no son amigos.

if ($_SESSION['id_usuario'] < $_GET['id']) {
    $id1 = $_SESSION['id_usuario'];
    $id2 = $_GET['id'];
} else {

    $id2 = $_SESSION['id_usuario'];
    $id1 = $_GET['id'];
}

//Buscamos por la tabla

$sql = sql("SELECT * FROM friends WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
$time = time();
if ($sql == false) {//No estan en la tabla.
    sql("INSERT INTO friends(id_amigo1,id_amigo2,peticion,desde) VALUES ( $id1 , $id2 , 1 , $time )");
    send_friend_alert($_SESSION['id_usuario'], $_GET['id']);
} else {
    //O son amigos o hay una peticion 
    if ($sql['peticion'] == 0) {
        echo "Ya sois amigos";
    } else {//Si ha pasado X tiempo la borramos y reenviamos.
        if ($sql['desde'] + $friendship_expire < time()) {

            sql("UPDATE friends SET desde = " . $time . " WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
            send_friend_alert($_SESSION['id_usuario'], $_GET['id']);
        } else {
            die("Debes esperar para otra peticion enviar");
        }
    }
}

function send_friend_alert($send, $receive) {//De momento son mensajes
    global $txt;
    //Buscamos quien es el que envia:
    $name = sql("SELECT nick FROM usuarios WHERE id_usuario = " . $send);

    $texto = $name . ' ' . $txt['add_friend'] . '<a href="">' . $txt['si'] . '</a><a href="">' . $txt['no'] . '</a>';

    sql("INSERT INTO messages(id_emisor,id_receptor,asunto,mensaje,fecha) VALUES (0," . $receive . ",'" . $txt['add_friend_head'] . "','" . $texto . "', Now() ) ");
}

?>
