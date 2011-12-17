<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['cantidad']) && $_POST['cantidad'] != "" && is_numeric($_POST['cantidad']) && isset($_POST['precio']) && $_POST['precio'] != "" && is_numeric($_POST['precio']))
{   
    $list_items = list_items();
    
    //Sacar datos empresa
    
    $empresa = sql("SELECT pais, stock, tipo FROM empresas WHERE id_empresa = " . $_POST['id_empresa']);
    
    //Asumimos que quiere vender el item que se crea en ella
    
    $itemavender = $empresa['tipo'];
    $nameitemavender = $list_items[$itemavender];
    //Sacar inventario
    
    $inventario = sql("SELECT * FROM inventario_empresas WHERE id_empresa = " . $_POST['id_empresa']);
    
    if ($inventario[$nameitemavender] >= $_POST['cantidad'] && $_POST['precio'] >= 0){
    // Si tiene mas objetos de los que quiere vender Y el precio es mayor
    
    sql("INSERT INTO mercado_objetos(id_pais, id_empresa, id_item, precio, cantidad) VALUES ('". $empresa['pais'] ."','". $_POST['id_empresa'] ."','". $empresa['tipo'] ."','". $_POST['precio'] ."','". $_POST['cantidad'] ."') ");

    //Quitar stock de la empresa
    
    sql("UPDATE inventario_empresas SET ".$nameitemavender." = ".$nameitemavender." - ". $_POST['cantidad'] . " WHERE id_empresa = ". $_POST['id_empresa']);
    
    echo "Oferta añadida correctamente"; 
    }
} else {
    
    die("Algo falla");
}
?>
