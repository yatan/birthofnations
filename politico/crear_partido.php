<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
    
	
if (isset($_POST['nombre']) && $_POST['nombre'] != "" && strlen($_POST['nombre'])>0)
{
    $creador = $_SESSION['id_usuario'];
    $nombre = $_POST['nombre'];
    
    $sql = sql("SELECT id FROM partidos WHERE nombre_partido = '" . $nombre ."'");//Comprobamos que no este el nombre cogido.
    
    if($sql != false )
        die("El nombre esta cogido");
    else
        $gold = sql("SELECT gold FROM money WHERE id_usuario = " . $creador); //Vemos cuanto dinero tiene
    
    if ($gold < $precio_partido) //Si tiene menos gold del que cuesta crearla
        die("No hay sugus");
    else 
	{
        sql("UPDATE money SET gold = gold - " . $precio_partido . " WHERE id_usuario = " . $creador ); //Se quita el gold
        $id_pais = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario = " . $creador);
        $id_pais = $id_pais['nacionalidad']; //Sacamos la id del pais de su nacionalidad
        sql("INSERT INTO partidos(id_lider, id_pais, nombre_partido) VALUES ('$creador', '$id_pais', '$nombre') "); //se crea
    }

}
else
die("faltan datos");
?>
