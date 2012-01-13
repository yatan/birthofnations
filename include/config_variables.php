<?php

/*
 * Aquí se modifican los valores de las constantes que afecten al juego
 * (por ejemplo puntos de experiencia necesarios para subir de nivel, limite de desarrollo tecnológico...
 */

//sistema

$lenguaje_principal = "es";

//Modulo general

$friendship_expire = 86400; //Tiempo que debe transcurrir paara que puedas reenviar una peticion de amistad
$min_travel_health = 10;

//Modulo economico

$min_work_health = 10;

$precio_empresa[10] = 10; //Entre [] el tipo
$precio_empresa[1] = 10;
$precio_empresa[2] = 10;
$precio_empresa[3] = 10;
$precio_empresa[4] = 10;

function formula_produccion($id) {
    //Whatever formulica...

    return 1;
}

//Modulo político
$precio_partido = 40;

//Numero de parametros de cada ley.
function law_params($ley) {

    switch ($ley):
        case 100:
        case 101:
        case 102:
        case 105:
        case 106:
            $data = 1;
            break;
        case 103:
        case 104:
            $data = 2;
            break;
        case 201:
            $data = 3;
            break;
    endswitch;


    return $data;
}

 //Nombre de los parametros de cada ley
function law_param_names($ley){
    switch($ley):
        case 100:
        case 106:
            $f[0] = getString('new_name');
            break;
        case 105:
            $f[0] = getString('new_flag');
        case 201:
            $f[0] = getString('amount');
            $f[1] = getString('currency');
            $f[2] = getString('id_destiny');
    endswitch;
    return $f;
}

//Modulo militar

$min_train_health = 10;
?>
