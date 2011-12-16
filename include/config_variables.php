<?php

/*
 * Aquí se modifican los valores de las constantes que afecten al juego
 * (por ejemplo puntos de experiencia necesarios para subir de nivel, limite de desarrollo tecnológico...
 */

//Modulo general

$friendship_expire = 86400; //Tiempo que debe transcurrir paara que puedas reenviar una peticion de amistad
//Modulo economico

$precio_empresa[10] = 10;//Entre [] el tipo
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
function law_params($ley){
    
    switch($ley):
        case 100:
            $data = 1;
            break;
        case 101:
            $data = 1;
            break;
        case 102:
            $data = 1;
            break;
        case 103:
            $data = 2;
            break;
        case 104:
            $data = 2;
            break;
        
    endswitch;
    
    
    return $data;
}

?>
