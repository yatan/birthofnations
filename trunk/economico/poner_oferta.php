<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['salario']) && $_POST['salario'] != "" && is_numeric($_POST['salario']) && isset($_POST['cantidad']) && $_POST['cantidad'] != "" && is_numeric($_POST['cantidad']))
{
    
    sql("INSERT INTO mercado_trabajo(id_pais, id_empresa, salario, cantidad) VALUES ('".$_POST['id_pais']."','".$_POST['id_empresa']."','".$_POST['salario']."','".$_POST['cantidad']."') ");
    echo "Oferta añadida correctamente"; 
} else {
    
    die("Faltan datos");
}
?>
