<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$nick = sql("SELECT nick FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$gold = sql("SELECT gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");
$mensajes = sql("SELECT COUNT(*) FROM messages WHERE id_receptor='".$_SESSION['id_usuario']."' AND leido='0'");

echo "$nick"
." "
."<img src='/images/flag/es.png'/>"
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


echo "Alertas: 0";


?>
