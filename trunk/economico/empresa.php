<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once("objeto_empresa.php");

if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Substituir por error 404


$id_empresa = $_GET['id_empresa'];


$empresa = new empresa($id_empresa);

echo "<h1>Empresa</h1>";

//Mostrar link para trabajar si es en esta empresa donde trabajo
$donde_trabajo = sql("SELECT id_empresa FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
if($id_empresa==$donde_trabajo)
    echo "<a href='/".$_GET['lang']."/trabajar'>Trabajar</a>";
//Ahora es un link, pero mas tarde se podria mostrar con show dialog los resultados del trabajo


if($empresa->id_propietario == $_SESSION['id_usuario'])
{   //Se envia por get la id para el include
   $var = $_GET['id_empresa']=$empresa->id_empresa;
   include("admin_empresa.php");
}
else
{
//Aqui se mostrara publicamente a todo el mundo
    //var_dump($empresa);
    echo "<p>Propietario: ".$empresa->get_nick_propietario()."</p>";
    echo "<p>Tipo:".$empresa->get_tipo()."</p>";
       
}
?>