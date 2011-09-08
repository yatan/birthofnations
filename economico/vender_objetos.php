<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['cantidad']) && $_POST['cantidad'] != "" && is_numeric($_POST['cantidad']) && isset($_POST['precio']) && $_POST['precio'] != "" && is_numeric($_POST['precio']))
{
 
    //Sacar datos empresa
    
    $empresa = sql("SELECT pais, stock, tipo FROM empresas WHERE id_empresa = " . $_POST['id_empresa']);
    
    if ($empresa['stock'] >= $_POST['cantidad']){
    
    sql("INSERT INTO mercado_objetos(id_pais, id_empresa, id_item, precio, cantidad) VALUES ('". $empresa['pais'] ."','". $_POST['id_empresa'] ."','". $empresa['tipo'] ."','". $_POST['precio'] ."','". $_POST['cantidad'] ."') ");

    //Quitar stock de la empresa
    
    sql("UPDATE empresas SET stock = stock - ". $_POST['cantidad'] . " WHERE id_empresa = ". $_POST['id_empresa']);
    
    echo "Oferta añadida correctamente"; 
    }
} else {
    
    die("Faltan datos");
}
?>
