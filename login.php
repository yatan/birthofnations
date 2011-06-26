<?php

include("include/funciones.php");
select_lang();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!isset($_POST['nick']) || $_POST['nick']=="")
die($login_form['login_nonick']);
else
$user = $_POST['nick'];

if(!isset($_POST['pass']) || $_POST['pass']=="")
die($login_form['login_nopass']);
else
$pass = md5($_POST['pass']);

$consulta = sql("SELECT nick FROM usuarios WHERE nick='$user'");
if($consulta==false)
    die($login_form['login_nomatch']);
else
    $consulta = sql("SELECT id_usuario FROM usuarios WHERE nick='$user' AND password='$pass'");
if($consulta==false)
    die($login_form['login_nomatch2']);
else
{
    $_SESSION['id_usuario'] = $consulta;
    //header("index.php"); <-- Redireccion a la pagina principal
    
}
    
?>
