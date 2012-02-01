<?php
    
    include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
    
    if(!isset($_GET['id'])){
        //GTFO
        die();
    }else{
        $id_empresa = $_GET['id'];
    }
    
    //Comprobar gold del comprador
    
    $gold_comprador = sql("SELECT Gold FROM money WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    //Sacar precio de la emrpesa
    
    $precio = sql("SELECT precio FROM mercado_empresas WHERE id_empresa = ".$id_empresa);
    
    //Comprobar
    
    if($gold_comprador >= $precio){
        
        //Coger id del vendedor
        $id_vendedor = sql("SELECT id_propietario FROM empresas WHERE id_empresa = ".$id_empresa);
        //Quitar la pasta al comprador
        sql("UPDATE money SET Gold = Gold - ".$precio." WHERE id_usuario = " . $_SESSION['id_usuario']);
        //Dar moneda al dueño
        sql("UPDATE money SET Gold = Gold + ".$precio." WHERE id_usuario = " . $id_vendedor);
        //Poner de propietario al comprador
        sql("UPDATE empresas SET id_propietario = ". $_SESSION['id_usuario']. " WHERE id_empresa = ". $id_empresa);
        //Borrar la oferta
        sql("DELETE FROM mercado_empresas WHERE id_empresa = ". $id_empresa);
        
    }else{
        getString("not_enough_money");
    }
    
?>
