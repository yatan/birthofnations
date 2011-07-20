<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['salario']) && $_POST['salario'] != "" && is_numeric($_POST['salario']))
{
        
    sql("UPDATE usuarios SET salario = ". $_POST['salario'] ." WHERE id_usuario = " . $_POST['id_worker'] );

    echo "Salario cambiado correctamente"; 
} else {
    
    die("Faltan datos");
}
?>