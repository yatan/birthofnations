<?php

//session_start();
include_once("../include/funciones.php");
include_once("../include/config_variables.php");



if (isset($_POST['nombre']) && $_POST['nombre'] != "" && strlen($_POST['nombre']) > 0 && isset($_POST['ant']) && $_POST['ant'] != "" && strlen($_POST['ant']) > 0 && isset($_POST['ant']) && $_POST['ant'] != "" && strlen($_POST['ant']) > 0) {
    $creador = $_SESSION['id_usuario'];
    $nombre = $_POST['nombre'];

    $sql = sql("SELECT id_partido FROM partidos WHERE nombre_partido = '" . $nombre . "'"); //Comprobamos que no este el nombre cogido.
    if ($sql != false)
        die("El nombre esta cogido");
    else
        $gold = sql("SELECT gold FROM money WHERE id_usuario = " . $creador); //Vemos cuanto dinero tiene
        $user = sql("SELECT id_partido FROM usuarios WHERE id_usuario = " . $creador);
    if ($gold < $precio_partido) { //Si tiene menos gold del que cuesta crearla
        die("No hay sugus");
    } elseif ($user['id_partido'] != 0) {
        die("Estas afiliado a otro partido");
    } else {
        sql("UPDATE money SET gold = gold - " . $precio_partido . " WHERE id_usuario = " . $creador); //Se quita el gold
        $id_pais = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario = " . $creador);
        $id_pais = $id_pais['nacionalidad']; //Sacamos la id del pais de su nacionalidad
        $dia_actual = sql("SELECT day FROM settings");
        $dia_elec = ($dia_actual % $_POST['frec']) - 1;
        if($dia_elec == -1){$dia_elec = $_POST['frec'] - 1; } //Al restar uno al modulo podemos caer en -1 y para conservar que el dia de elecciones sea tb un modulo, tenemos que moverlo manualmente el mayor valor posible (frecuencia -1)
        sql("INSERT INTO partidos(id_lider, id_pais, nombre_partido, ant_votaciones, frec_elecciones, dia_elecciones) VALUES ('$creador', '$id_pais', '$nombre','" . $_POST['ant'] . "','" . $_POST['frec'] . "','" . $dia_elec . "') "); //se crea
        $sql = sql("SELECT id_partido FROM partidos WHERE id_lider = " . $creador); //Miramos la id del nuevo partido
        sql("UPDATE usuarios SET id_partido = " . $sql . ", ant_partido = 1 WHERE id_usuario = " . $creador); //Afiliamos al creador
    }
}
else
    die("faltan datos");
?>
