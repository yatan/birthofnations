<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
    
	
if (isset($_POST['nuevo_nombre']) && $_POST['nuevo_nombre'] != "" && strlen($_POST['nuevo_nombre'])>0) 
{
    
    $_POST[nuevo_nombre]=htmlentities($_POST[nuevo_nombre], ENT_QUOTES | ENT_IGNORE, "UTF-8");   
    $sql = sql("SELECT id_empresa FROM empresas WHERE nombre_empresa = '" . $_POST['nuevo_nombre'] ."'");//Comprobamos que no este el nombre cogido.
    
    if($sql != false )
        die("El nombre esta cogido");
    else
        sql("UPDATE empresas SET nombre_empresa = '". $_POST['nuevo_nombre'] ."' WHERE id_empresa = ". $_POST['id_empresa']);
    
    
    echo getString("name_changed");


}
else
die(getString("not_enough_data"));
?>
