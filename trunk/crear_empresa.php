<?php
    
    session_start();
    include_once("funciones.php");
    include_once("config_variables.php");
    
if (isset($_POST['tipo']) && $_POST['tipo'] != "" && strlen($_POST['tipo'])){

    $creador = $_SESSION['id_usuario'];
    
    
    $gold = sql("SELECT gold FROM usuario WHERE id_usuario = " . $creador); //Vemos cuanto dinero tiene
    
    if ($gold >= $precio_empresa[$tipo]){ //Si tiene mas gold del que cuesta crearla
        sql("UPDATE usuarios SET gold = gold - " . $precio_empresa[$tipo] . " WHERE id_usuario = " . $creador ); //Se quita el gold
        sql("INSERT INTO empresas(id_propietario, tipo) VALUES $creador, $tipo"); //se crea
    }
    

}
?>
