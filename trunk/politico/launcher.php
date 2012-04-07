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

$rest = explode('.', $data[1]);

//Sacados los datos aqui hay que comprobar si se puede lanzar la ley acualmente:



//Si el modo es automatico (A), ponemos una votacion, que gane 1-0, cerrada y los efectos son inmediatos.

switch ($rest[0]):
    case 'A':
        $time = time();
        $time2 = $time + 86400;
        sql("INSERT INTO votaciones(tipo_votacion, id_pais, comienzo, fin, restricciones, param1, solved) 
        VALUES('" . $data[0] . "','" . $_POST['id_pais'] . "','" . $time . "','" . $time2 . "','" . $data[1] . "','" . $p . "','1')");
        $sql = sql("SELECT id_votacion FROM votaciones WHERE comienzo = " . $time . " AND fin = " . $time2 . " AND param1 = '" . $p . "'");
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('".$sql."','-1','".$data[0]."','1','1')");//"Candidato si con 1 voto"
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('".$sql."','-2','".$data[0]."','0','1')");//"Candidato no con 0 votos"
        apply_law($sql);
        break;
    case 'V': //Votaciones chachis
        $time = time();
        $time2 = $time + 86400;
        sql("INSERT INTO votaciones(tipo_votacion, id_pais, comienzo, fin, restricciones, param1, solved) 
        VALUES('" . $data[0] . "','" . $_POST['id_pais'] . "','" . $time . "','" . $time2 . "','" . $rest[1] . "','" . $p . "','0')");//A�adimos la votacion
        $sql = sql("SELECT id_votacion FROM votaciones WHERE comienzo = " . $time . " AND fin = " . $time2 . " AND param1 = '" . $p . "'");
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('".$sql."','-1','".$data[0]."','0','0')");//"Candidato si"
        sql("INSERT INTO candidatos_elecciones(id_votacion, id_candidato, tipo_elecciones, votos, solved) 
            VALUES ('".$sql."','-2','".$data[0]."','0','0')");//"Candidato no"
        break;
    default:
endswitch;
?>