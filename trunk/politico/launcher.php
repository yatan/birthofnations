<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

//Cuando alguien lanza una ley hay dos opciones, se sea automatica o que necesite votacion.
//$data = $_POST['data'];
//Data -> info sobre la ley
//P -> Parametros que se rellenan


$data = $_POST['data'];

if (is_array($_POST['p'])) {
    $p = implode('.', $_POST['p']);
} else {
    $p = $_POST['p'][0];
}

$data = explode('-', $data);
//data[0] = tipo de votacion
$rest = explode('.', $data[1]);


//rest[0], rest[1], los diferentes parametros que han insertado al abrir la votacion
//Sacados los datos aqui hay que comprobar si se puede lanzar la ley acualmente:

$flag = true;

//Leyes especiales. En realidad esto es para comprobaciones previas. Corta leyes que no cumplan requisitos.
switch ($data[0]):
    case 301://Abrir batalla
    
        $at_region = (int)$_POST['p'][0];
        $def_region = (int)$_POST['p'][1];
        
        
        //0: Que la region atacante sea del pais que lanza la ley
        $region_country = sql("SELECT idcountry FROM region WHERE idregion = ". $at_region);
        if($region_country != $_POST['id_pais']){
            echo "not your country";
            $flag = false;
            break;
        }
        
        //1: Regiones limítrofes
        //$attacking region = $rest[0];
        //$defending region = $rest[1];

        include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_region.php");
        $region = new region($at_region);
        $ruta = $region->distance_to($def_region);
        
        if (count($ruta[$def_region]) != 3) {//Si no son colindantes
            echo "non colindant regions";
            $flag = false;
            break;
        }

        //2: Guerra abierta entre los paises implicados

        $at_country = region2country($at_region);
        $def_country = region2country($def_region);
        //Ver id guerra
        $id_war = sql("SELECT id_war FROM wars WHERE pais_atacante = " . $at_country . " AND pais_defensor = " . $def_country . " AND hora_fin = 0");
        if($id_war == false){
            echo "no active war";
            $flag = false;
            break;
        }
        
        break;
        endswitch;

if ($flag == false) {
    die(getString('smth_failed'));
}

//Si el modo es automatico (A), ponemos una votacion, que gane 1-0, cerrada y los efectos son inmediatos.

switch ($rest[0]):
    case 'A':
        $time = time();
        $time2 = $time + 86400;
        sql("INSERT INTO votaciones(tipo_votacion, id_pais, comienzo, fin, restricciones, param1, solved) 
        VALUES('" . $data[0] . "','" . $_POST['id_pais'] . "','" . $time . "','" . $time2 . "','" . $data[1] . "','" . $p . "','1')");
        $sql = sql("SELECT id_votacion FROM votaciones WHERE comienzo = " . $time . " AND fin = " . $time2 . " AND param1 = '" . $p . "'");
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('" . $sql . "','-1','" . $data[0] . "','1','1')"); //"Candidato si con 1 voto"
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('" . $sql . "','-2','" . $data[0] . "','0','1')"); //"Candidato no con 0 votos"
        apply_law($sql);
        break;
    case 'V': //Votaciones chachis
        $time = time();
        $time2 = $time + 86400;
        sql("INSERT INTO votaciones(tipo_votacion, id_pais, comienzo, fin, restricciones, param1, solved) 
        VALUES('" . $data[0] . "','" . $_POST['id_pais'] . "','" . $time . "','" . $time2 . "','" . $rest[1] . "','" . $p . "','0')"); //A�adimos la votacion
        $sql = sql("SELECT id_votacion FROM votaciones WHERE comienzo = " . $time . " AND fin = " . $time2 . " AND param1 = '" . $p . "'");
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('" . $sql . "','-1','" . $data[0] . "','0','0')"); //"Candidato si"
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('" . $sql . "','-2','" . $data[0] . "','0','0')"); //"Candidato no"
        break;
    default:
endswitch;
?>