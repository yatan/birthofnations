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

function nombre_item($tipo){
    
    switch ($tipo):
        case 1:
            $ret = "sugus";
            break;
        case 2:
            $ret = "azucar";
            break;
        case 3:
            $ret = "droga";
            break;
        
    endswitch;
    
    return $ret;
}
function obj_to_id ($obj){
    
    switch($obj):
        case 'sugus':
            $ret = 1;
            break;
        case 'azucar':
            $ret = 2;
            break;
    endswitch;
    
    return $ret;
}

//Modulo pol�tico
$precio_partido = 40;



?>
