<?php

/*
 * Aquí se modifican los valores de las constantes que afecten al juego
 * (por ejemplo puntos de experiencia necesarios para subir de nivel, limite de desarrollo tecnológico...
 */

//Modulo general

$friendship_expire = 86400; //Tiempo que debe transcurrir paara que puedas reenviar una peticion de amistad
//Modulo economico

$precio_empresa[1] = 10; //Entre [] el tipo
$precio_empresa[2] = 20;

function formula_produccion($id) {
    //Whatever formulica...

    return 1;
}


//Otra que deberia ser eliminada, ahora esto esta en la BD
function raw_needed($tipo) {

    switch ($tipo):
        case 1: // Sugus
            $ret = 1;
            break;
        case 3:
            $ret = 1;
            break;
        default:
            $ret = 0;
            break;
    endswitch;

    return $ret;
}

//Modulo político
$precio_partido = 40;

//Numero de parametros de cada ley.
function law_params($ley){
    
    switch($ley):
        case 100:
            $data = 1;
            break;
        case 101:
            $data = 2;
            break;
        case 102:
            $data = 0;
            break;
    endswitch;
    
    
    return $data;
}

?>
