<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$nick = sql("SELECT nick FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$gold = sql("SELECT gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");

echo "$nick"
." "
."<img src='/images/flag/es.png'/>"
." - "
."<img src='/images/status_bar/life.gif'/> 100"
." - "
."<img src='/images/status_bar/gold.gif'/> $gold golds"
." - "
."Mensajes: 0"
." - "
."Alertas: 0";


?>
