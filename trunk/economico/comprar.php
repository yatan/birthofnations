<?php
    
    include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");
    
    if (isset($_POST['cantidad']) && $_POST['cantidad'] != "" && strlen($_POST['cantidad'])>0 ){
        
        //Sacamos los datos de la oferta 
        $oferta = sql("SELECT * FROM mercado_objetos WHERE id_oferta = ". $_POST['id_oferta']);
       
        //Sacamos la cantidad de dinero que tiene el usuario
        $dinero = sql("SELECT ". $moneda_local[$oferta['id_pais']] ." FROM money WHERE id_usuario = ". $_SESSION['id_usuario']);
        
        //Comprobamos que tiene suficiente Y quiero menos de los que hay        
        if ( $dinero >= $oferta['precio']*$_POST['cantidad'] && $_POST['cantidad'] <= $oferta['cantidad'] ){
            
            //Los quitamos de la oferta
            if($oferta['cantidad'] == $_POST['cantidad']){//Si no hay mas borramos
                
                sql("DELETE FROM mercado_objetos WHERE id_oferta = ". $_POST['id_oferta']);
                
            }else{//Si quedan quitamos los comprados
                
                sql("UPDATE mercado_objetos SET cantidad = cantidad - ". $_POST['cantidad'] ." WHERE id_oferta = ". $_POST['id_oferta']);
                
            }
            
            //Quitar dinero al user
            sql("UPDATE money SET ". $moneda_local[$oferta['id_pais']] . " = ". $moneda_local[$oferta['id_pais']] ." - ". $oferta['precio']*$_POST['cantidad'] ." WHERE id_usuario = ". $_SESSION['id_usuario']);
            //Meter en la empresa
            sql("UPDATE empresas SET ". $moneda_local[$oferta['id_pais']] . " = ". $moneda_local[$oferta['id_pais']] ." + ". $oferta['precio']*$_POST['cantidad'] ." WHERE id_empresa = ". $oferta['id_empresa']);
            //Dar objeto al user
            sql("UPDATE inventario SET ". $oferta['objeto'] . " = " . $oferta['objeto'] . " + " . $_POST['cantidad'] ." WHERE id_usuario = ". $_SESSION['id_usuario']);
            
        }else{
            die("No tienes suficiente dinero");
        }
        
        
    }
?>
