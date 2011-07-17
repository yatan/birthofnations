<?php
/* 
   * Aquí se modifican los valores de las constantes que afecten al juego
 * (por ejemplo puntos de experiencia necesarios para subir de nivel, limite de desarrollo tecnológico...
 */

//Modulo economico

$precio_empresa[1] = 10; //Entre [] el tipo
$precio_empresa[2] = 20;
function formula_produccion($id){
    //Whatever formulica...
    
    return 1;
    
}

function raw_needed($tipo){
    
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

//Modulo pol�tico
$precio_partido = 40;



?>
