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

if(!isset($_POST['referer']) || $_POST['referer']=="")
die("Falta referer");
else
$referer = $_POST['referer'];

if($pass1 != $pass2)
    die("Error al validar password");

$verificar = sql("SELECT nick FROM usuarios WHERE nick='$user'");
if($verificar==true)
    die("Ya existe un usuario con ese nick");

$verificar = sql("SELECT email FROM usuarios WHERE email='$email'");
if($verificar==true)
    die("Ya existe un email registrado");

$pass = md5($pass1);
$id_referer = sql("SELECT id_usuario FROM usuarios WHERE nick='$referer'");
$hoy = date("Y.n.j");

sql("INSERT INTO usuarios(nick,password,email,fecha_registro,id_referer) VALUES ('$user','$pass','$email','$hoy','$referer')");//Añadir a la tabla de usuarios
sql("INSERT INTO money(gold) VALUES 0 "); //Añadir a la tabla de dinero

//Registrar usuario al foro <-ULTIMO PASO BD->
anadir_foro($user,$pass1,$email);
anadir_bugs($user, $pass1, $email);
//Se envia el mail de bienvenida
mail_bienvenida($user, $email);
//Muestra mensaje de fin de registro OK
die("ok")

?>