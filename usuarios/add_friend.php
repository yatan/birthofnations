<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");

//id para pedir
//ac para aceptar
//Comprobar que no son amigos.

function send_friend_alert($send, $receive) {//De momento son mensajes
    global $txt;
    //Buscamos quien es el que envia:
    $name = sql("SELECT nick FROM usuarios WHERE id_usuario = " . $send);

    $texto = $name . ' ' . $txt['add_friend'] . '<a href="add_friend.php?ac=si&ai=' . $send . '">' . $txt['si'] . '</a><a href="add_friend.php?ac=no&ai=' . $send . '">' . $txt['no'] . '</a>';

    sql("INSERT INTO messages(id_emisor,id_receptor,asunto,mensaje,fecha) VALUES (0," . $receive . ",'" . $txt['add_friend_head'] . "','" . $texto . "', Now() ) ");
}

if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id']) > 0) {
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
        sql("INSERT INTO friends(id_amigo1,id_amigo2,peticion,desde) VALUES ( $id1 , $id2 , " . $_SESSION['id_usuario'] . " , $time )");
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
}

if (isset($_GET['ac']) && $_GET['ac'] != "" && strlen($_GET['ac']) > 0 && isset($_GET['ai'])) {

    if ($_SESSION['id_usuario'] < $_GET['ai']) {

        $id1 = $_SESSION['id_usuario'];
        $id2 = $_GET['ai'];
    } else {

        $id2 = $_SESSION['id_usuario'];
        $id1 = $_GET['ai'];
    }

    //Sacamos quien fue el que envio la peticion
    $sql = sql("SELECT peticion FROM friends WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
    ;
    if ($sql == 0) {
        echo "Ya sois amigos";
    } else {
        if ($_GET['ac'] == 'si' && $_SESSION['id_usuario'] != $sql) {//Aceptar si el que accede al link no es el que la envio
            sql("UPDATE friends SET peticion = 0, desde = Now() WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
        } elseif ($_GET['ac'] == 'no' && $_SESSION['id_usuario'] != $sql) {//Rechazar
            sql("UPDATE friends SET peticion = -1, desde = Now() WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
        } else {
            echo "Esa no es una respuesta valida";
        }
    }
}
?>
