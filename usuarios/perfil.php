<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


if(!isset($_GET['id_usuario']))
    die("Error: id no valido"); //Sustituir por error 404


$id_usuario = $_GET['id_usuario'];


class usuario
{
    public $id_usuario;
    public $nick;
    public $exp;
    public $avatar;

    
    function usuario($id){
        $usuario = sql("SELECT * FROM usuarios WHERE id_usuario='$id'");
        if ($usuario==false)
            return false;
        
        $this->id_usuario = $id;
        $this->nick = $usuario['nick'];
        $this->exp = $usuario['exp'];
        if($usuario['avatar']=="images/no_avatar.gif")
        $this->avatar = "/images/no_avatar.gif";
            else
        $this->avatar = $usuario['avatar'];
        
    }
    
}

$usuario = new usuario($id_usuario);
if ($usuario->id_usuario==null)
    die("No existe el usuario"); //Aqui mostrar error 404
else
{
echo "<h1>Perfil de $usuario->nick</h1>";
echo "<img src='$usuario->avatar'/>";
echo"<pre><code>";
var_dump($usuario);
echo"</code></pre>";
}
?>
