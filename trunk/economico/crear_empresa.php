<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
    include_once("../usuarios/objeto_usuario.php");
    
	
if (isset($_POST['tipo']) && $_POST['tipo'] != "" && strlen($_POST['tipo'])>0 && isset($_POST['nombre']) && $_POST['nombre'] != "" && strlen($_POST['nombre'])>1)
{
    $tipo = $_POST['tipo'];
    $creador = $_SESSION['id_usuario'];
    $nombre = $_POST['nombre'];
    $user = new usuario($creador);
    
    $sql = sql("SELECT id_empresa FROM empresas WHERE nombre_empresa = '" . $nombre ."'");//Comprobamos que no este el nombre cogido.
    
    if($sql != false )
        die("El nombre esta cogido");
    else
    {
        $gold = sql("SELECT gold FROM money WHERE id_usuario = " . $creador); //Vemos cuanto dinero tiene
    
    if ($gold < $precio_empresa[$tipo]) //Si tiene menos gold del que cuesta crearla
        die("No hay sugus");
    else 
	{
        sql("UPDATE money SET gold = gold - " . $precio_empresa[$tipo] . " WHERE id_usuario = " . $creador ); //Se quita el gold
        sql("INSERT INTO empresas(id_propietario, tipo, nombre_empresa, pais, region) VALUES ('$creador', '$tipo', '$nombre','".$user->id_pais."','".$user->id_region."') "); //se crea
        $sql = sql("SELECT id_empresa FROM empresas WHERE nombre_empresa = '".$nombre."'");
        sql("INSERT INTO inventario_empresas(id_empresa) VALUES ('$sql') "); //se crea el ivnentario
    
        echo "Empresa creada con exito";
        //echo "<script language='JavaScript'>window.location = '/{$_GET['lang']}/empresas'</script>";
        }
    }
}
else
die("faltan datos");
?>
