<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");

//id para pedir
//ac para aceptar
//Comprobar que no son amigos.

function send_friend_alert($send, $receive) {//Para enviar la alerta
    global $txt;
//Buscamos quien es el que envia:
    $name = sql("SELECT nick FROM usuarios WHERE id_usuario = " . $send);
    
    sql("INSERT INTO alertas(id_emisor,id_receptor,tipo,fecha) VALUES ('".$send."','".$receive."','1','".time()."')"); 
}

if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id']) > 0) {

    $id1 = $_SESSION['id_usuario']; //Envia
    $id2 = $_GET['id']; //Recibe
//Buscamos por la tabla

    $sql = sql("SELECT * FROM friends WHERE ( id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2 . " ) OR ( id_amigo1 = " . $id2 . " AND id_amigo2 = " . $id1 . " )");
    $time = time();
    if ($sql == false) {//No estan en la tabla.
        sql("INSERT INTO friends(id_amigo1,id_amigo2,peticion,desde) VALUES ( $id1 , $id2 , 0 , $time )");
        send_friend_alert($id1, $id2);
    } else {//O son amigos o hay una peticion 
//Si ha pasado X tiempo la borramos y reenviamos.
        if ($sql['desde'] + $friendship_expire < time()) {

            sql("UPDATE friends SET desde = " . $time . " WHERE ( id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2 . " ) OR ( id_amigo1 = " . $id2 . " AND id_amigo2 = " . $id1 . " )");
            send_friend_alert($_SESSION['id_usuario'], $_GET['id']);
        } else {
            die("Debes esperar para otra peticion enviar");
        }
    }
}

$_GET['ac'] = 'si'; //Aunque ahora no sea posible rechazar, lo dejamos indicado por si algun dia hace falta.
if (isset($_GET['ac']) && $_GET['ac'] != "" && strlen($_GET['ac']) > 0 && isset($_GET['ai'])) {

    $id1 = $_GET['ai']; //El que se supone que vamos a aceptar
    $id2 = $_SESSION['id_usuario']; //El que acepta y recibio la peticion
    //Comprobamos quien envio la peticion.

    $sql = sql("SELECT id_amigo1, peticion FROM friends WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2 . " AND peticion = 0");

    if ($sql == false) {
        //O no hay peticion o el que recibe la peticion no es el SESSION['id_usuario']
        die("No hay ni peticion ni leches");
    }

    if ($sql['peticion'] == 1) {
        // El que envi� la peticion intenta aceptarla O ya son amigos
        die("O sois amigos o no puedes aceptarla");
    } else {
        $_GET['ac'] = 'si'; //Aunque ahora no sea posible rechazar, lo dejamos indicado por si algun dia hace falta.
        if ($_GET['ac'] == 'si') {//Aceptar
            sql("INSERT INTO friends (id_amigo1, id_amigo2, peticion, desde) VALUES (" . $id2 . "," . $id1 . ",1,Now()) ");
            sql("UPDATE friends SET peticion = 1, desde = Now() WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
            echo "Amigo confirmado";
        } elseif ($_GET['ac'] == 'no') {//Rechazar
            sql("UPDATE friends SET peticion = 2, desde = Now() WHERE id_amigo1 = " . $id1 . " AND id_amigo2 = " . $id2);
        } else {
            echo "Esa no es una respuesta valida";
        }
    }
}
?>
