<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");

if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id'])>0 ){
    
    //Comprobar que tiene
    
    $nombre = nombre_item($_GET['id']);
    
    $cantidad = sql("SELECT ". $nombre ." FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    if($cantidad <= 0){
        
        die("No tienes");
        
    }else{
        //Quitar uno
        sql("UPDATE inventario SET ". $nombre . " = " . $nombre ." - 1 WHERE id_usuario = ". $_SESSION['id_usuario']);

        switch($_GET['id']):
            case 1:
                sql("UPDATE usuarios SET salud = salud - 2, vitalidad = vitalidad + 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                echo "Sugus usado";
                break;
            case 3:
                sql("UPDATE usuarios SET salud = 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                echo "<img alt='Logro Suicida' title='Logro' src='../images/Achievement.gif'>";
                add_stat('S',$_SESSION['id_usuario']);
        endswitch;
    }
    
}

?>