<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once("objeto_usuario.php");

if(!isset($_GET['id_usuario']))
    die("Error: id no valido"); //Sustituir por error 404


$id_usuario = $_GET['id_usuario'];




$usuario = new usuario($id_usuario);
if ($usuario->id_usuario==null)
    die("No existe el usuario"); //Aqui mostrar error 404
else
{
echo "<h1>Perfil de $usuario->nick</h1>";
echo "<img src='$usuario->avatar'/>";

//Aqui si el perfil es el mio hace el include a
//pagina para editar cosas, sino se pagina de perfil publico
if($usuario->soy_yo($_SESSION['id_usuario'])==true)
    {
    include("mi_perfil.php");
    
    }
else
    {
    //Zona publica
    //var_dump($usuario);
    echo "<br/>";
    echo "<a><img src='/images/friend.png'/>Añadir amigo</a>";
    }
    //Zona tanto publica como privada
    include("friends.php");

}
?>
