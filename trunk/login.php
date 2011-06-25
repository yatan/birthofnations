<?php

include("include/funciones.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!isset($_POST['nick']) || $_POST['nick']=="")
die("Falta nick");
else
$user = $_POST['nick'];

if(!isset($_POST['pass']) || $_POST['pass']=="")
die("Falta password");
else
$pass = md5($_POST['pass']);

$consulta = sql("SELECT nick FROM usuarios WHERE nick='$user'");
if($consulta==false)
    die("La combinacion de usuario/password no es la correcta [0x01]");
else
    $consulta = sql("SELECT id_usuario FROM usuarios WHERE nick='$user' AND password='$pass'");
if($consulta==false)
    die("La combinacion de usuario/password no es la correcta [0x02]");
else
    $_SESSION['id_usuario'] = $consulta;
    
?>
