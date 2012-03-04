<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

//Comprobaciones de quien intenta upgradear y todo eso.

$tech = $_GET['tech'];
$pais = $_GET['pais'];
$id_usuario = $_SESSION['id_usuario'];

$gov = check_gov($id_usuario, $pais);

//Comprobar Gold del que pague
if ($gov == true) {//Paga el pais
    $gold_pais = sql("SELECT Gold FROM money_pais WHERE idcountry = " . $pais);
} else {//Paga el user
    $gold_pais = sql("SELECT Gold FROM money WHERE id_usuario = " . $id_usuario);
}

//Sacar precio de la renovacion

$precio = sql("SELECT precio" . $tech . " FROM country_tech WHERE id_country = " . $pais);

//Comparar

if ($gold_pais >= $precio) {//Hay pasta
    //Quitar dinero
    if ($gov == true) {//Paga el pais
        sql("UPDATE money_pais SET Gold = Gold - " . $precio . " WHERE idcountry = " . $pais);
    } else {//Paga el user
        sql("UPDATE money SET Gold = Gold - " . $precio . " WHERE id_usuario = " . $id_usuario);
    }
    //Añadir dias
    $tiempo = sql("SELECT tech" . $tech . " FROM country_tech WHERE id_country = " . $pais);
    $time = time_tech($tech);
    if ($tiempo >= 0) {
        sql("UPDATE country_tech SET tech" . $tech . " = tech" . $tech . " + " . $time . " WHERE id_country = " . $pais);
    } else {
        sql("UPDATE country_tech SET tech" . $tech . " = " . $time . " WHERE id_country = " . $pais);
    }
} else {
    //No hay pasta
}
?>