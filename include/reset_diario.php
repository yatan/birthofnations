<?php
$time_start = microtime(true);
//Archivo de reset diario

include_once("/home/birthofn/public_html/include/config.php");
include_once("/home/birthofn/public_html/include/funciones.php");

sql("UPDATE settings SET mantenimiento='1'");


//Seguridad       
if (!isset($_SERVER['argv']))
    die("Error");

$pin = $_SERVER['argv'][1];
$pin2 = sql("SELECT pin FROM settings");

if ($pin != $pin2)
    die("Error");

//Economico
sql("UPDATE diario SET work = 0, train = 0");

//Actualizacion del dia
sql("UPDATE settings SET day=day+1");


//Tecnologias
//Quitar un dia a todas
for ($i = 1; $i <= 2; $i++) {
    sql("UPDATE country_tech SET tech" . $i . " = tech" . $i . " - 1");
}

//Politico

//Abrir votaciones de partidos y postulaciones de presidentes de partido
sql("UPDATE usuarios SET ant_partido = ant_partido + 1");
$DA = sql("SELECT day FROM settings");
$sql = sql2("SELECT id_partido, frec_elecciones, dia_elecciones FROM partidos");
$time = time();

foreach ($sql as $party) {
    $mod = $DA % $party['frec_elecciones']; //Modulo del dia
    if ($mod == $party['dia_elecciones'] - 2 || $mod == $party['dia_elecciones'] - 2 + $party['frec_elecciones']) { //2 dias antes de las elecciones, abrimos la votacion {
        $time2 = $time + 3 * 86400 - 100; //quitamos unos cuantos, por si da problemas al terminar el cron
        sql("INSERT INTO votaciones(tipo_votacion,is_cargo,fin,comienzo,param1) VALUES ('1','1','" . $time2 . "',' " . $time . "','" . $party['id_partido'] . "')");
    }
}

//Abrir votaciones para cargos de paises
$sql = sql("SELECT * FROM country_leaders");

foreach ($sql as $cargo) {
    $data = explode('-', $cargo['votacion']);
    if ($data[0] == 'V') { //Si hay que abrir votacion
        $data2 = explode('.', $data[1]);
        $mod = $DA % $data2[1]; //Modulo del dia
        if ($mod == $data2[0] - 2 || $mod == $data2[0] - 2 + $data2[1]) { //2 dias antes de las elecciones, abrimos la votacion {
            $data3 = explode('?', $data2[2]);
            //var_dump($data2);
            //var_dump($data3);
            $time = time();
            $time2 = $time + 3 * 86400 - 100; //quitamos unos cuantos, por si da problemas al terminar el cron
            sql("INSERT INTO votaciones(tipo_votacion,is_cargo,fin,comienzo,param1,restricciones) VALUES ('" . $cargo['id_cargo'] . "','1','" . $time2 . "',' " . $time . "','" . $data3[0] . "','" . $data3[1] . "')");
        }
    }
}

//Cerramos las votaciones que no hayan sido resueltas, que ya hayan terminado y sean de presidente de partido
$sql = sql2("SELECT * FROM votaciones WHERE solved = 0 AND fin < " . $time . " AND tipo_votacion = 1 AND is_cargo = 1");

foreach ($sql as $votacion) {
    //Ver la lista de candidatos
    $candidatos = sql2("SELECT * FROM candidatos_elecciones WHERE id_votacion = " . $votacion['id_votacion']);
    if ($candidatos != false) { //Si hay candidatos
        $winner = array('id' => 0, 'votos' => -1);
        foreach ($candidatos as $cand) { //Ver quien es el ganador
            if ($cand['votos'] > $winner['votos']) { //Comparamos los votos con los del ganador
                $winner['id'] = $cand['id_candidato'];
                $winner['votos'] = $cand['votos'];
            } elseif ($cand['votos'] == $winner['votos']) { //Si empatan utilizamos los criterios de desempate (que no tenemos)
            }
        }

        //Cambiar las casilla de lider
        sql("UPDATE partidos SET id_lider = " . $winner['id'] . " WHERE id_partido = " . $votacion['param1']);
    } else { //Si no hay candidatos
        //Todo sigue igual
    }
    //marcar como resuelta
    sql("UPDATE votaciones SET solved = 1 WHERE id_votacion = " . $votacion['id_votacion']);
}

//Ahora resolvemos las de cargos de un pais 
//Sin resolver, que hayan acabado, que sean de algun pais y que sean de cargos
$sql = sql2("SELECT * FROM votaciones WHERE solved = 0 AND fin < " . $time . " AND tipo_votacion >= 100 AND is_cargo = 1");

foreach ($sql as $votacion) {
    //Leemos cuantos hay que elegir
    $cuantos = $votacion['restricciones'];
    $cuantos = explode('!', $cuantos);
    foreach ($cuantos as $data) {
        $data2 = explode('+', $data);
        if ($data2[0] == 'S') {
            $ret = $data2[1];
            break;
        }
    }

    //Sacamos los resultados de la votacion
    //
    //Ver la lista de candidatos
    $candidatos = sql2("SELECT * FROM candidatos_elecciones WHERE id_votacion = " . $votacion['id_votacion']);
    if ($candidatos != false) { //Si hay candidatos
        // $data = '';
        foreach ($candidatos as $candidato) {
            $data[$candidato['id_candidato']] = $candidato['votos'];
        }
        //Ordenamos por el numero de votos recibidos
        arsort($data);
        $data = array_keys($data);
        //Quitamos a los lideres anteriores:
        sql("UPDATE country_leaders SET id_gente = null WHERE id_cargo = " . $votacion['tipo_votacion']);
        //Ponemos a los nuevos
        for ($i = 0; $i < $ret; $i++) {
            add_leader($votacion['tipo_votacion'], $data[$i]);
        }
    } else { //Si no hay candidatos
        //Todo sigue igual
    }
    //marcar como resuelta
    sql("UPDATE votaciones SET solved = 1 WHERE id_votacion = " . $votacion['id_votacion']);
}


/*
 * Limpieza de la DB
 */

//Eliminar log_produccion de mas de 15 dias
$dia = sql("SELECT day FROM settings") - 15;
sql("DELETE FROM log_produccion WHERE dia < $dia");
sql("DELETE FROM log_ventas WHERE dia < $dia");


sql("UPDATE settings SET mantenimiento='0'");

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Cron realizado correctamente en $time segundos\n";
