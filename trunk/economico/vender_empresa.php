<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	$precio = $_POST['precio'];
        $id = $_POST['id'];
        
        if($precio >= 0){
            sql("INSERT INTO mercado_empresas(id_empresa, precio) VALUES (".$id.",".$precio.")");
        }
        
        if($precio == 0){
            sql("DELETE FROM mercado_empresas WHERE id_empresa = ".$id);
        }
?>
