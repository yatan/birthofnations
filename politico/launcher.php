<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

//Cuando alguien lanza una ley hay dos opciones, se sea automatica o que necesite votacion.
//$data = $_POST['data'];

//Data -> info sobre la ley
//P -> Parametros que se rellenan

$_POST['id_pais'] = 2;
$data = $_POST['data'];

if (is_array($_POST['p'])) {
    $p = implode('.', $_POST['p']);
} else {
    $p = $_POST['p'][0];
}
//Despues de recoger los parametros, añadimos al principio el id del pais

$p = $_POST['id_pais'] . "." . $p;


$data = explode('-', $data);

$rest = explode('.', $data[1]);

//Si el modo es automatico (A), ponemos una votacion, que gane 1-0, cerrada y los efectos son inmediatos.

if ($rest[0] == 'A') {
    $time = time();
    $time2 = $time + 1;
    sql("INSERT INTO votaciones(tipo_votacion, comienzo, fin, restricciones, param1, data, solved) 
        VALUES('" . $data[0] . "','" . $time . "','" . $time2 . "','" . $data[1] . "','" . $p . "','" . $p . "','1')");
    $sql = sql("SELECT id_votacion FROM votaciones WHERE comienzo = ".$time." AND fin = ".$time2." AND param1 = '".$p."'");
    apply_law($sql);
}
?>