<?

include("include/funciones.php");

if(!isset($_POST['username']) || $_POST['username']=="")
die("Falta usuario");
else
$user = $_POST['username'];

if(!isset($_POST['password1']) || $_POST['password1']=="")
die("Falta password");
else
$pass1 = $_POST['password1'];

if(!isset($_POST['password2']) || $_POST['password2']=="")
die("Falta validacion password");
else
$pass2 = $_POST['password2'];

if(!isset($_POST['email']) || $_POST['email']=="")
die("Falta email");
else
$email = $_POST['email'];


if($pass1 != $pass2)
    die("Error al validar password");

$verificar = sql("SELECT nick FROM usuarios WHERE nick='$user'");
if($verificar==true)
    die("Ya existe un usuario con ese nick");

$verificar = sql("SELECT email FROM usuarios WHERE email='$email'");
if($verificar==true)
    die("Ya existe un email registrado");



?>