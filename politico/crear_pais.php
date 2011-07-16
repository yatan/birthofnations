<?php

    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");

    var_dump(isset($_POST['name']));
    
if (isset($_POST['name']) && $_POST['name'] != "" && strlen($_POST['name']) != 0 && isset($_POST['moneda']) && strlen($_POST['moneda']) == 3 ) {
echo "A";
    $creador = $_SESSION['id_usuario'];
    $name = $_POST['name'];
    
    sql("INSERT INTO country(name, fundador, date_of_birth) VALUES ('$name', '$creador', Now() )"); 
    sql("ALTER TABLE money ADD COLUMN ". $_POST['moneda'] ." int(11) NOT NULL DEFAULT 0");
    sql("ALTER TABLE empresas ADD COLUMN ". $_POST['moneda'] ." int(11) NOT NULL DEFAULT 0");
    
    //Aqui falta añadirla a la lista de monedas de moneda_local.php
    
} else { echo"B"; }
?>