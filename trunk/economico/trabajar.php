<?php
    
    include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");
    
    $datos = sql("SELECT id_empresa, salario, moneda FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']); //Sacar donde trabaja y su salario
    
    $empresa = sql("SELECT " . $moneda_local[$datos['moneda']] . ", raw, tipo FROM empresas WHERE id_empresa = " . $datos['id_empresa']); //Sacamos cuanto dinero y raw tiene la empresa.

    $diario = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);//Sacar si ha trabajado
    
    $producido = formula_produccion($_SESSION['id_usuario']); // Lo que va a producir
    
    $raw = $producido * raw_needed($empresa['tipo']);
    
    if($empresa[$moneda_local[$datos['moneda']]] > $datos['salario'] )
    {
        if($diario == 0)
        {
            if(type_company($empresa['tipo']) == 0  || $empresa['raw'] >= $raw)
                {
        ////Comprobamos que haya dinero Y  no haya trabajado Y (no necesite O tenga suficiente) raw.

        //Quitar dinero de la empresa y meter produccion
        sql("UPDATE empresas SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " - " . $datos['salario'] . ", stock = stock + " . $producido . " WHERE id_empresa = " . $datos['id_empresa']);
        //Darselo al trabajador
        sql("UPDATE money SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " + " . $datos['salario'] . " WHERE id_usuario = " . $_SESSION['id_usuario']);
        //Quitar raw
        if (type_company($empresa['tipo']) != 0 ){
            
            sql("UPDATE empresas SET raw = raw - " . $raw . " WHERE id_empresa = " . $datos['id_empresa']);
            
        }
        
        //Poner que has trabajado
        sql("UPDATE diario SET work = 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
        //Algun mensaje de confirmacion que se tendra que traducir xD
        echo "Has producido $producido, vuelve mañana";
             } 
             else echo "Falta raw en la empresa";
         }
         else echo "Hoy ya has trabajado";
    }
    else echo "Falta dinero en la empresa para pagarte";
?>
