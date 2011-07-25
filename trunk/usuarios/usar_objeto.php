<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

if (isset($_GET['obj']) && $_GET['obj'] != "" && strlen($_GET['obj'])>0 ){
    
    //Comprobar que tiene
    
    $cantidad = sql("SELECT ". $_GET['obj'] ." FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    if($cantidad == 0){
        
        die("No tienes");
        
    }else{
        
        $cantidad = obj_to_id($_GET['obj']);
        
        switch($cantidad):
            case 1:
                sql("UPDATE usuarios SET salud = salud - 2, vitalidad = vitalidad + 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                break;
        endswitch;
    }
    
}

?>