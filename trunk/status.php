<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$nick = sql("SELECT nick FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$gold = sql("SELECT gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");
$mensajes = sql("SELECT COUNT(*) FROM messages WHERE id_receptor='".$_SESSION['id_usuario']."' AND leido='0' AND deleted='0'");
$alertas = sql("SELECT COUNT(*) FROM alertas WHERE id_receptor='".$_SESSION['id_usuario']."' AND leido='0'");
$pais = sql("SELECT name, url_bandera FROM country WHERE idcountry IN (SELECT id_nacionalidad FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."')");


echo "<a href='/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']."'>$nick</a>"
." "
."<img alt='bandera' title='".$pais['name']."' src='".$pais['url_bandera']."'/>"
." - "
."<img src='/images/status_bar/life.gif'/> 100"
." - "
."<img src='/images/status_bar/gold.gif'/> $gold golds"
." - ";
echo"<a style='none' href='/".$_GET['lang']."/mensajes'>";
if($mensajes==0 || $mensajes == false)
echo "<img src='/images/status_bar/no_mail.gif'/> No tienes mensajes nuevos";
elseif ($mensajes==1) 
echo "<img src='/images/status_bar/mail.gif'/> Tienes un mensaje nuevo";    
elseif ($mensajes>1) 
echo "<img src='/images/status_bar/mail.gif'/> Tienes mensajes nuevos";  
echo"</a>";

echo " - ";


echo"<a style='none' href='/".$_GET['lang']."/alertas'>";
if($alertas==0 || $alertas == false)
echo "<img src='/images/status_bar/no_alert.png'/> Alertas: 0";  
elseif ($alertas>=1) 
echo "<img src='/images/status_bar/alert.png'/> Alertas nuevas: $alertas";  
echo"</a>";


?>
