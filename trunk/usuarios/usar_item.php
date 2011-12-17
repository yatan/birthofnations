<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT']."/usuarios/objeto_usuario.php");
if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id'])>0 ){
    
    //Comprobar que tiene
    
    $nombre = nombre_item($_GET['id']);
    $usuario = new usuario($_SESSION['id_usuario']);
    $cantidad = sql("SELECT ". $nombre ." FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    if($cantidad <= 0){
        
        die("No tienes");
        
    }else{
        

        switch($_GET['id']):
                case 1:
                    if($usuario->salud == 99){
                      sql("UPDATE usuarios SET salud = 100 WHERE id_usuario = " . $_SESSION['id_usuario']);
                      echo "Pan usado, se ha restaurado 1 punto de salud";
                      //Quitar uno
        sql("UPDATE inventario SET ". $nombre . " = " . $nombre ." - 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                    }elseif($usuario->salud==100){
                      echo "No tienes salud que recuperar";
                    }else{
                        sql("UPDATE usuarios SET salud = salud + 2 WHERE id_usuario = " . $_SESSION['id_usuario']);
                      echo "Pan usado, se han restaurado 2 puntos de salud";
                      //Quitar uno
                      sql("UPDATE inventario SET ". $nombre . " = " . $nombre ." - 1 WHERE id_usuario = ". $_SESSION['id_usuario']);
                    }
                    
                    break;
        endswitch;
    }
    
}

?>
<br>
<a href="javascript:history.back(1)">Volver</a>