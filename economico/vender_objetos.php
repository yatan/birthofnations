<?php
    
    //session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
	
if (isset($_POST['cantidad']) && $_POST['cantidad'] >= 1 && $_POST['cantidad'] != "" && is_numeric($_POST['cantidad']) && isset($_POST['precio']) && $_POST['precio'] != "" && is_numeric($_POST['precio']))
{   
    //Antes de nada comprobamos que el preco sea legal
    
    if($_POST['precio'] >= 0.01){
        $_POST['precio'] = rfloor($_POST['precio'], 2);
    }else{
        echo getString('company_ups_something_is_wrong');
        die();
    }
    
    //Y redondeamos la cantidad de items a vender, antes se comprueba si hay decimales.
    $hay_decimal = strpos($_POST['cantidad'], '.');
    if ($hay_decimal === true) {
        $_POST['cantidad'] = rfloor($_POST['cantidad'], 0);
    } 
    

    
    $list_items = list_items();
    
    //Sacar datos empresa
    
    $empresa = sql("SELECT pais, stock, tipo FROM empresas WHERE id_empresa = " . $_POST['id_empresa']);
    
    //Asumimos que quiere vender el item que se crea en ella
    
    $itemavender = $empresa['tipo'];
    $nameitemavender = $list_items[$itemavender];
    //Sacar inventario
    
    $inventario = sql("SELECT * FROM inventario_empresas WHERE id_empresa = " . $_POST['id_empresa']);
    
    if ($inventario[$nameitemavender] >= $_POST['cantidad'])
        {
    // Si tiene mas objetos de los que quiere vender Y el precio es mayor
    
    sql("INSERT INTO mercado_objetos(id_pais, id_empresa, id_item, precio, cantidad) VALUES ('". $empresa['pais'] ."','". $_POST['id_empresa'] ."','". $empresa['tipo'] ."','". $_POST['precio'] ."','". $_POST['cantidad'] ."') ");

    //Quitar stock de la empresa
    
    sql("UPDATE inventario_empresas SET ".$nameitemavender." = ".$nameitemavender." - ". $_POST['cantidad'] . " WHERE id_empresa = ". $_POST['id_empresa']);
    
    echo getString('company_oferta_anyadida'); 
        }
   elseif($_POST['precio'] < 0)
       echo getString('sell_for_zero');
   elseif($inventario[$nameitemavender] < $_POST['cantidad'])
       echo getString('not_enough_stock');   
       
  } 
else {
    
    echo getString('company_ups_something_is_wrong');
}
?>
