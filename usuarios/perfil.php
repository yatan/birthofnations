<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once("objeto_usuario.php");
?>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<?
if(!isset($_GET['id_usuario']))
    die("Error: id no valido"); //Sustituir por error 404


$id_usuario = $_GET['id_usuario'];




$usuario = new usuario($id_usuario);
if ($usuario->id_usuario==null)
    die("No existe el usuario"); //Aqui mostrar error 404
else
{
    
?>
<div id="tabs">
	<ul>
            <li><a href="#amigos">Perfil</a></li>		
                <? 
                if($usuario->soy_yo($_SESSION['id_usuario'])==true)
                    echo "<li><a href='#economia'>Economia</a></li>";
                    echo "<li><a href='#inventario'>Inventario</a></li>";
                ?>
		
	</ul>
    
<?
echo "<h2>Perfil de $usuario->nick</h2>";
echo "<img src='$usuario->avatar'/>";

//Aqui si el perfil es el mio hace el include a
//pagina para editar cosas, sino se pagina de perfil publico
if($usuario->soy_yo($_SESSION['id_usuario'])==true)
    {
    	echo "<div id='economia'>";
		include("mi_perfil.php");
	echo "</div>";
 
    	echo "<div id='inventario'>";
		include("inventario.php");
	echo "</div>";        
    
    
    }
else
    {
    //Zona publica
    echo "<br/>";
    if($usuario->somos_amigos($_SESSION['id_usuario'])== false)
    echo "<a href='../../usuarios/add_friend.php?id=$usuario->id_usuario'><img src='/images/friend.png'/>Añadir amigo</a>";
    }
    //Zona tanto publica como privada
    	echo "<div id='amigos'>";
		include("friends.php");
	echo "</div>";
    

}
?>
</div>