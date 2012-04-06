<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_region.php");

echo "<h1>Batallas actuales</h1>";

$batallas = sql2("SELECT * FROM battles");

echo "<table border='1' bordercolor='#009933' >";
echo "<tr align='center'><td>Batalla</td><td>Ronda</td><td>Tipo</td><td>Estado</td><td>Ver</td><td>Inscripción</td></tr>";

foreach ($batallas as $batalla) {
    $bandos = sql("SELECT pais_atacante, pais_defensor FROM wars WHERE id_war='{$batalla['id_war']}'");
    
    $pais_atacante = new pais($bandos['pais_atacante']);
    $pais_defensor = new pais($bandos['pais_defensor']);
    $region_afectada = new region($batalla['region']);
    
    echo "<tr align='center'>";
    echo "<td>".$pais_atacante->nombre." vs ".$pais_defensor->nombre." por la lucha de: ".$region_afectada->nombre."</td>";
    echo "<td>".$batalla['ronda_actual']."</td>";
    echo "<td>".$batalla['tipo']."</td>";
    echo "<td>".$batalla['estado']."</td>";
    echo "<td><img src='/images/war/eye.png' /></td>";
    echo "<td><img src='/images/war/inscription.png' /></td>";
    echo "</tr>";
}

echo "</table>";

?>
