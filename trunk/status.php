<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$dia = sql("SELECT day FROM settings");
$nick = sql("SELECT nick FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$gold = sql("SELECT gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");
$mensajes = sql("SELECT COUNT(*) FROM messages WHERE id_receptor='".$_SESSION['id_usuario']."' AND leido='0' AND deleted='0'");
$alertas = sql("SELECT COUNT(*) FROM alertas WHERE id_receptor='".$_SESSION['id_usuario']."' AND leido='0'");
$pais = sql("SELECT name, url_bandera FROM country WHERE idcountry IN (SELECT id_nacionalidad FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."')");
$estado = sql("SELECT status FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
ventana_js("hola","hola link","ventana js",2);
if($estado != null)
{
$a_estado = explode(",",$estado);
$i_estado="";
foreach ($a_estado as $estado2) {
    switch($estado2)
    {
        case "a":
            $i_estado = $i_estado."<img title='".$txt['stat_a']."' src='/images/status_bar/status/2.png'/> ";
            break;        
        case "b":
            $i_estado = $i_estado."<img title='".$txt['stat_b']."' src='/images/status_bar/status/3.png'/> ";
            break;
        case "c":
            $i_estado = $i_estado."<img title='".$txt['stat_c']."' src='/images/status_bar/status/4.png'/> ";
            break;     
        case "S":
            $i_estado = $i_estado."<img title='".$txt['stat_S']."' src='/images/status_bar/status/5.png'/> ";
            break;        
        default:
            $i_estado = $i_estado."";
    }
}
}
else
$i_estado = "<img src='/images/status_bar/status/1.png'/>";

echo "$i_estado - <a href='/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']."'>$nick</a>"
." - "
."<img alt='bandera' title='".$pais['name']."' src='".$pais['url_bandera']."'>"
." - "
."<img alt='vida'  src='/images/status_bar/life.gif'> 100"
." - "
."<img alt='gold' src='/images/status_bar/gold.gif'> $gold golds"
." - ";
echo"<a style='none' href='/".$_GET['lang']."/mensajes'>";
if($mensajes==0 || $mensajes == false)
echo "<img alt='no_mail' src='/images/status_bar/no_mail.gif' > No tienes mensajes nuevos";
elseif ($mensajes==1) 
echo "<img alt='mail' src='/images/status_bar/mail.gif' > Tienes un mensaje nuevo";    
elseif ($mensajes>1) 
echo "<img alt='/mail' src='/images/status_bar/mail.gif' > Tienes mensajes nuevos";  
echo"</a>";

echo " - ";


echo"<a style='none' href='/".$_GET['lang']."/alertas'>";
if($alertas==0 || $alertas == false)
echo "<img src='/images/status_bar/no_alert.png' alt='no_alert'> Alertas: 0";  
elseif ($alertas>=1) 
echo "<img alt='alert' src='/images/status_bar/alert.png'> Alertas nuevas: $alertas";  
echo"</a>";
echo "<a style='padding-left: 3em; text-align:right;'>Dia: $dia</a>";

?>
