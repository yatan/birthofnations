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
    public $id_pais;
    public $id_region;
    
    function usuario($id){
        $usuario = sql("SELECT * FROM usuarios WHERE id_usuario='$id'");
        if ($usuario==false)
            return false;
        
        $this->id_usuario = $id;
        $this->nick = $usuario['nick'];
        $this->exp = $usuario['exp'];
        $this->id_pais = $usuario['id_pais'];
        $this->id_region = $usuario['id_region'];
        
        
        if($usuario['avatar']=="images/no_avatar.gif")
        $this->avatar = "/images/no_avatar.gif";
            else
        $this->avatar = $usuario['avatar'];
        
    }
    
    function soy_yo($mi_id)
    {
        if($this->id_usuario == $mi_id)
           return true;
        else
           return false;
    }
    
}

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
    include("mi_perfil.php");
else
    var_dump($usuario);

}
?>
