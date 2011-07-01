<?php
    
    session_start();
    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");
    
if (isset($_POST['tipo']) && $_POST['tipo'] != "" && strlen($_POST['tipo']) && isset($_POST['nombre']) && $_POST['nombre'] != "" && strlen($_POST['nombre'])){

    $creador = $_SESSION['id_usuario'];
    $nombre = $_POST['nombre'];
    $sql = sql("SELECT id FROM empresas WHERE nombre_empresa = '" . $nombre ."'");//Comprobamos que no este el nombre cogido.
    
    if($sql != false )
        die("El nombre esta cogido");
    else
        $gold = sql("SELECT gold FROM money WHERE id_usuario = " . $creador); //Vemos cuanto dinero tiene
    
    if ($gold < $precio_empresa[$tipo]) //Si tiene menos gold del que cuesta crearla
        die("No hay sugus");
    else {
        sql("UPDATE money SET gold = gold - " . $precio_empresa[$tipo] . " WHERE id_usuario = " . $creador ); //Se quita el gold
        sql("INSERT INTO empresas(id_propietario, tipo, nombre_empresa) VALUES $creador, $tipo, '$nombre' "); //se crea
    }

}
?>
