<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");

if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id'])>0 ){
    
    //Comprobar que tiene
    
    $nombre = nombre_item($_GET['id']);
    
    $cantidad = sql("SELECT ". $nombre ." FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    if($cantidad == 0){
        
        die("No tienes");
        
    }else{
        //Quitar uno
        sql("UPDATE inventario SET ". $nombre . " = " . $nombre ." - 1");

        switch($_GET['id']):
            case 1:
                sql("UPDATE usuarios SET salud = salud - 2, vitalidad = vitalidad + 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                echo "Sugus usado";
                break;
        endswitch;
    }
    
}

?>