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

$currency_per_gold = 100;

$min_work_health = 10;

$precio_empresa[10] = 10; //Entre [] el tipo
$precio_empresa[1] = 10;
$precio_empresa[2] = 10;
$precio_empresa[3] = 10;
$precio_empresa[4] = 10;



//Modulo político
$precio_partido = 40;

//Exp para cambiar de gobierno

$gov_exp[0] = 20;
$gov_exp[1] = 999999999999;

//Militar
$battle_lenght = 18*60*60; //18 horas

//Numero de parametros de cada ley.
function law_params($ley) {

    switch ($ley):
        case 100:
        case 101:
        case 102:
        case 105:
        case 106:
        case 200:
        case 300:
            $data = 1;
            break;
        case 103:
        case 104:
        case 301:
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
            break;
        case 200:
            $f[0] = getString('amount');
            break;
        case 201:
            $f[0] = getString('amount');
            $f[1] = getString('currency');
            $f[2] = getString('id_destiny');
            break;
        case 300:
            $f[0] = getString('country');
            break;
        case 301:
            $f[0] = getString('id_attacking_region');
            $f[1] = getString('id_defense_region');
            break;
    endswitch;
    return $f;
}

//Modulo militar

$min_train_health = 10;
?>
