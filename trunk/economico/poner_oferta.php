<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['salario']) && $_POST['salario'] != "" && is_numeric($_POST['salario']) && isset($_POST['cantidad']) && $_POST['cantidad'] != "" && is_numeric($_POST['cantidad']))
{
    if($_POST['salario'] >= 0){
        $_POST['cantidad'] = rfloor($_POST['cantidad'], 0);//Por si las moscas 
        $_POST['salario'] = rfloor($_POST['salario'], 2);//Por si las moscas 
    sql("INSERT INTO mercado_trabajo(id_pais, id_empresa, id_jefe, salario, cantidad) VALUES ('".$_POST['id_pais']."','".$_POST['id_empresa']."', '". $_SESSION['id_usuario'] ."', '".$_POST['salario']."','".$_POST['cantidad']."') ");

    echo getString('company_oferta_anyadida'); 
    }
} else {
    
    die(getString('not_enough_data'));
}
?>
