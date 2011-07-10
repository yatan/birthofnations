<?php
    
    include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");
    
    $datos = sql("SELECT id_empresa, salario, moneda FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']); //Vemos donde trabaja y su salario
    
    $dinero = sql("SELECT " . $moneda_local[$datos['moneda']] . " FROM empresas WHERE id_empresa = " . $datos['id_empresa']); //Sacamos cuanto dinero tiene la empresa.

    $diario = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
    
    if($dinero > $datos['salario'] && $diario == 0){//Comprobamos que haya dinero y que no haya trabajado
        $producido = formula_produccion($_SESSION['id_usuario']);
        //Quitar dinero de la empresa y meter produccion
        sql("UPDATE empresas SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " - " . $datos['salario'] . ", stock = stock + " . $producido . " WHERE id_empresa = " . $datos['id_empresa']);
        //Darselo al trabajador
        sql("UPDATE money SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " + " . $datos['salario'] . " WHERE id_usuario = " . $_SESSION['id_usuario']);
        //Añadir stock a la empresa
    } else {
        echo"no";
    }
?>
