<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
    
	
if (isset($_POST['nuevo_nombre']) && $_POST['nuevo_nombre'] != "" && strlen($_POST['nuevo_nombre'])>0) 
{
    
    $sql = sql("SELECT id_empresa FROM empresas WHERE nombre_empresa = '" . $nombre ."'");//Comprobamos que no este el nombre cogido.
    
    if($sql != false )
        die("El nombre esta cogido");
    else
        sql("UPDATE empresas SET nombre_empresa = '". $_POST['nuevo_nombre'] ."' WHERE id_empresa = ". $_POST['id_empresa']);
    
    
    echo "Nombre cambiado";


}
else
die("faltan datos");
?>
