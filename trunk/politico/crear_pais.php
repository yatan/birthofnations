<?php

    include_once("../include/funciones.php");
    include_once("../include/config_variables.php");


    
if (isset($_POST['name']) && $_POST['name'] != "" && strlen($_POST['name']) != 0 && isset($_POST['moneda']) && strlen($_POST['moneda']) == 3 ) {

    $creador = $_SESSION['id_usuario'];
    $name = $_POST['name'];
    
    //Miramos si ya existe el nombre
    $monedas = sql("SELECT moneda FROM country");

            $flag = true;
            $p[1] = strtoupper($name);

            foreach ($monedas as $coin) {
                if ($p[1] == $coin['moneda']) {//Su nombre es el de alguna moneda
                    $flag = false;
                    break;
                }
            }
            if($flag == true){
    sql("INSERT INTO country(name, fundador, date_of_birth) VALUES ('$name', '$creador', Now() )"); 
    sql("ALTER TABLE money ADD COLUMN ". $_POST['moneda'] ." decimal(11, 3) NOT NULL DEFAULT 0");
    sql("ALTER TABLE empresas ADD COLUMN ". $_POST['moneda'] ." decimal(11, 3) NOT NULL DEFAULT 0");
    sql("ALTER TABLE money_pais ADD COLUMN ". $_POST['moneda'] ." decimal(11, 3) NOT NULL DEFAULT 0");
            }
    //Aqui falta a�adirla a la lista de monedas de moneda_local.php
    
} else { echo"Faltan datos"; }
?>