<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
    
	
if (isset($_POST['msj']) && $_POST['msj'] != "" && strlen($_POST['msj'])>0 && isset($_POST['nombre']) && $_POST['nombre'] != "" && strlen($_POST['nombre'])>1)
{
    $msj = $_POST['msj'];
    $emisor = $_SESSION['id_usuario'];
    $receptor = $_POST['nombre'];
    $sql = sql("SELECT nick FROM usuarios WHERE nick = '" . $receptor ."'");//Comprobamos que existe el receptor
    
    if($sql != false )
        sql("INSERT INTO messages (id_emisor, nick_emisor, id_receptor, mensaje, fecha) VALUES ('". $_SESSION['id_usuario'] ."','". $_POST['nombre'] ."','". $sql['id']  ."','". $_POST['msj'] ."', GETDATE() )");
    else{
        die("No existe ese usuario");
    }
    
echo "Mensaje enviado con exito";
}
else
die("faltan datos");
?>
