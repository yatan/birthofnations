<?php

include("../include/funciones.php");
select_lang();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!isset($_POST['nick']) || $_POST['nick']=="") //Si no introduce el nick
die($login_form['login_nonick']);
else
$user = $_POST['nick'];

if(!isset($_POST['pass']) || $_POST['pass']=="") //Si no introduce la pass
die($login_form['login_nopass']);
else
$pass = md5($_POST['pass']);

$consulta = sql("SELECT nick, id_usuario FROM usuarios WHERE nick='$user'");

if($consulta==false)//El usuario no esta en la BD
    die($login_form['login_nomatch']);
else
    $consulta = checkban($consulta['id_usuario']);
    
if($consulta == true ) //Si esta ban    
    die($login_form['login_banned']);
else
    $consulta = sql("SELECT id_usuario FROM usuarios WHERE nick='$user' AND password='$pass'");

if($consulta==false)//No concuerdan user y pass
    die($login_form['login_nomatch2']);
else
{
    $_SESSION['id_usuario'] = $consulta;
    header("Location: ../"); //<-- Redireccion a la pagina principal
    
}
    
?>