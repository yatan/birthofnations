<?php

include_once("include/funciones.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$email = $_POST['mail'];
$id = $_SESSION['id_usuario'];


$codigo = md5($id.$email);
$hoy = date("Y.n.j");

$referal = sql_error("INSERT INTO referals(codigo, id_padrino, email, fecha) VALUES ('$codigo','$id','$email','$hoy')");

$code = " http://birthofnations.com/login/registro.php?referer=".$codigo;


$nick = sql("SELECT nick FROM usuarios WHERE id_usuario='$id'");
mail_referido("$nick","$email","$code");
echo "Email enviado correctamente.";
?>
