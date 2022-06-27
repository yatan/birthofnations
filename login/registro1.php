<?php

require '../vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('../include/birthofnations.json');
$auth = $factory->createAuth();

include("../include/funciones.php");

if (!isset($_POST['username']) || $_POST['username'] == "")
    die(getString('no_user'));
else
    $user = $_POST['username'];

if (!isset($_POST['password1']) || $_POST['password1'] == "")
    die(getString('no_password'));
else
    $pass1 = $_POST['password1'];

if (!isset($_POST['password2']) || $_POST['password2'] == "")
    die(getString('no_re_password'));
else
    $pass2 = $_POST['password2'];

if (!isset($_POST['email']) || $_POST['email'] == "")
    die(getString('no_mail'));
else
    $email = $_POST['email'];

if (!isset($_POST['referer']) || $_POST['referer'] == "")
    die(getString('no_referer'));
else
    $referer = $_POST['referer'];

if ($pass1 != $pass2)
    die(getString('no_re_password'));

$verificar = sql("SELECT nick FROM usuarios WHERE nick='$user'");
if ($verificar == true)
    die(getString('user_again'));

$verificar = sql("SELECT email FROM usuarios WHERE email='$email'");
if ($verificar == true)
    die(getString('mail_again'));

$pass = md5($pass1);
$id_referer = sql("SELECT id_usuario FROM usuarios WHERE nick='$referer'");
$hoy = date("Y.n.j");

sql("INSERT INTO usuarios(nick,password,email,fecha_registro,id_referer) VALUES ('$user','$pass','$email','$hoy','$id_referer')"); //A�adir a la tabla de usuarios
$mi_id = sql("SELECT id_usuario FROM usuarios WHERE nick='$user'");
sql("INSERT INTO money(id_usuario) VALUES ('$mi_id') "); //A�adir a la tabla de dinero
sql("INSERT INTO diario(id_usuario) VALUES ('$mi_id') "); //A�adir a la tabla de diarios
sql("INSERT INTO inventario(id_usuario) VALUES ('$mi_id') "); //Añadir a la tabla de inventario
sql("INSERT INTO skills(id_usuario) VALUES ('$mi_id') "); //Añadir a la tabla de skills
//
//Registrar usuario al foro <-ULTIMO PASO BD->
// anadir_foro($user, $pass1, $email);
// anadir_bugs($user, $pass1, $email);
//Se envia el mail de bienvenida
// mail_bienvenida($user, $email);
//Muestra mensaje de fin de registro OK

$userProperties = [
    'email' => $email,
    'emailVerified' => false,
    'password' => $pass1,
    'disabled' => false,
];

try {
    $createdUser = $auth->createUser($userProperties);
} catch (Exception $e) {
    echo $e->getMessage();
}

die(getString('ok'));
