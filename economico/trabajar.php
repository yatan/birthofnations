<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/produccion.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/economico/moneda_local.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/usuarios/objeto_usuario.php");

$objeto_usuario = new usuario($_SESSION['id_usuario']);

$datos = sql("SELECT id_empresa, salario, moneda FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']); //Sacar donde trabaja y su salario

$empresa = sql("SELECT " . $moneda_local[$datos['moneda']] . ", raw, tipo FROM empresas WHERE id_empresa = " . $datos['id_empresa']); //Sacamos cuanto dinero y raw tiene la empresa.

$diario = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']); //Sacar si ha trabajado

$item = sql("SELECT * FROM items WHERE id_item = " . $empresa['tipo']);

//id del dueño de la empresa
$duenyo = sql("SELECT id_propietario FROM empresas WHERE id_empresa = {$datos['id_empresa']}");

$list_items = list_items();

$producido = formula_produccion($_SESSION['id_usuario'],$empresa['tipo'],$item['is_raw']); // Numero de items que va a producir
//Condiciones que ha de cumplir el trabajador

if ($objeto_usuario->salud < $min_work_health) {
    die($txt['cant_work']);
}

if ($empresa[$moneda_local[$datos['moneda']]] > $datos['salario']) { //Si hay sueldo suficiente
    if ($diario == 0) { //Si aun no ha trabajado
        $hay_raw = true;
        if ($item['is_raw'] != 1) { //Comprobamos que haya todo el raw necesario.
            $raw_needed = parse_raw($empresa['tipo']);

            //Multiplicamos por la cantidad que se necesite de cada uno.

            foreach ($raw_needed as $item => $value) {
                $raw_needed[$item] = $producido * $value;
            }

            //Comprobamos si la empresa tiene los items necesarios para este trabajador.
            $hay_raw = true;
            foreach ($raw_needed as $item => $value) {
//Acceso de los items raw al inventario empresa
//$sql = sql("SELECT " . $list_items[$item] . " FROM inventario_empresas WHERE id_empresa = " . $datos['id_empresa']);
//Acceso de los items raw desde el inventario del jugador
                $sql = sql("SELECT " . $list_items[$item] . " FROM inventario WHERE id_usuario = $duenyo");
                if ($sql < $value) {
                    $hay_raw = false;
                    break;
                }
            }
        }



        if ($item['is_raw'] == 1 || $hay_raw == true) {
            ////Comprobamos que no necesite O tenga suficiente raw.
            //Quitar dinero de la empresa 
            sql("UPDATE empresas SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " - " . $datos['salario'] . " WHERE id_empresa = " . $datos['id_empresa']);
            //Darselo al trabajador
            sql("UPDATE money SET " . $moneda_local[$datos['moneda']] . " = " . $moneda_local[$datos['moneda']] . " + " . $datos['salario'] . " WHERE id_usuario = " . $_SESSION['id_usuario']);
            // Meter produccion
            sql("UPDATE inventario_empresas SET " . $list_items[$empresa['tipo']] . " = " . $list_items[$empresa['tipo']] . " + " . $producido . " WHERE id_empresa = " . $datos['id_empresa']);
            //Quitar raw

            if ($item['is_raw'] == 0) { //Si no es de raw, quitamos el raw que necesitaba
                foreach ($raw_needed as $item => $value) {
                    //Se quita el raw del inventario del jugador
                    sql("UPDATE inventario SET " . $list_items[$item] . " = " . $list_items[$item] . " - " . $value . " WHERE id_usuario = $duenyo");
                }
            }

            //Poner que has trabajado
            sql("UPDATE diario SET work = 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
            //Dar +1 exp por trabajar
            sql("UPDATE usuarios SET exp = exp+1 WHERE id_usuario = " . $_SESSION['id_usuario']);
            //Subir skill
            $aumento = aumento_work_skill($objeto_usuario->id_usuario);
            sql("UPDATE skills SET work = work + " .  $aumento . " WHERE id_usuario = ".$objeto_usuario->id_usuario);
            //Se guarda en el log de produccion
            $dia = sql("SELECT day FROM settings");
            sql("INSERT INTO log_produccion(id_usuario,id_empresa,producido,dia) VALUES('" . $_SESSION['id_usuario'] . "','" . $datos['id_empresa'] . "','$producido','$dia')");
            //Algun mensaje de confirmacion que se tendra que traducir xD
            echo getString('company_you_have_produced') . $producido . getString('company_come_again_tomorrow') . "<br>";
            echo getString('company_exp');
        } else {
            echo getString('company_not_enough_raw');
            send_alert($objeto_usuario->id_usuario, $duenyo, 4, $datos['id_empresa']);
        }
    }
    else
        echo getString('company_you_have_worked');
}
else {
    echo getString('company_not_enough_salary');
    send_alert($objeto_usuario->id_usuario, $duenyo, 5, $datos['id_empresa']);
}
?>
