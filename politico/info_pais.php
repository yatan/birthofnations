<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");
$dia_actual = sql("SELECT day FROM settings");

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);


$nombre_pais = $pais->nombre;
echo "<h1>$nombre_pais</h1><img alt='bandera' title='".$pais->nombre."' src='".$pais->bandera."'/>";

echo "Poblacion actual: " . $pais->population();

echo "<h3>LÃ­deres</h3>";

$cargos = $pais->list_cargos(); //Sacamos la lista de cargos del pais

echo "<table><tr><th>Nick</th><th>Posicion</th></tr>";

foreach ($cargos as $cargo) {//Para cada cargo

    $gente = list_leaders($cargo['id_cargo']); //Sacamos la lista de gente
    
    foreach($gente as $persona){//Para cada uno de ellos
    echo "<tr><td><a href='../perfil/" . $persona . "'>" . id2nick($persona) . "</a></td><td>" . $cargo['nombre'] . "</td></tr>";
    }
}

echo "</table>";

echo "<h3>Postulaciones públicas</h3>";

foreach($cargos as $cargo){
    
    //Para cada cargo vemos si hay votacion abierta
    $sql = sql("SELECT * FROM votaciones WHERE tipo_votacion = ". $cargo['id_cargo'] . " AND solved = 0");
    $data = explode('-',$cargo['votacion']);
    $data2 = explode('.',$data[1]);
    if($sql == false){//Si no hay
        echo "No hay postulaciones abiertas";
        echo "Proximas elecciones el dia: " . next_elecciones($dia_actual, $data2[0], $data2[1]);
    }else{ //Si hay
    if ($dia_actual % $data2[1] == $data2[0]) { //Dia de elecciones 
    //Sacar id de la votacion
    $time = time();
    $sql = sql("SELECT id_votacion FROM votaciones WHERE tipo_votacion = ".$cargo['id_cargo']." AND is_cargo = 1 AND fin > " . $time . " AND solved = 0");
    echo $cargo['nombre'] . '  <a href="/politico/lista_candidatos.php?id=' . $sql . '">Votar</a>';
} elseif (($dia_actual % $data2[1] == $data2[0] - 1 || $dia_actual % $data2[1] == $data2[0] - 2)) {
    //2 dias anteriores a las elecciones
    // Fecha + Postulacion
    echo "Proximas elecciones el dia: " . next_elecciones($dia_actual, $data2[0], $data2[1]);
    $time = time();
    $vot = sql("SELECT id_votacion FROM votaciones WHERE tipo_votacion = " . $cargo['id_cargo'] . " AND fin > " . $time);
    $sql = sql("SELECT * from candidatos_elecciones WHERE id_candidato = " . $_SESSION['id_usuario'] . " AND id_votacion = ".$vot);

    if ($sql == false) {//Si aun no esta postulado
        echo "[<a href='/politico/postular2.php?v=" . $cargo['id_cargo'] . "'>Postulate</a>]";
    } else {//Si ya esta postulado
        echo "[<a href='/politico/despostular2.php?v=" . $cargo['id_cargo'] . "'>Despostulate</a>]";
    }
} else {
    //Calculamos la siguiente fecha
    echo "Proximas elecciones el dia: " . next_elecciones($dia_actual, $data2[0], $data2[1]);
}
    }
}

echo "<h3>Dineros</h3>";

echo "<table><tr><th>Moneda</th><th>Cantidad</th></tr>";
$gold = sql("SELECT Gold FROM money_pais WHERE idcountry ='" . $id_pais . "'");

echo "<tr><td>" . $txt['Gold'] . "</td><td>" . $gold . "</td></tr>";
$sql = sql("SELECT * FROM money_pais WHERE idcountry = " . $id_pais);

unset($sql['idcountry'], $sql['Gold']);
arsort($sql);

foreach ($sql as $moneda => $valor) {
    if ($valor == 0) {
        continue;
    }
    echo "<tr><td>" . $moneda . "</td><td>" . $valor . "</td></tr>";
}

echo "</table>";

echo "<h3>Regiones</h3>";

$regiones = $pais->list_regions();

if ($regiones == false) {
    echo $txt['no_regions'];
} else {

    echo "<table><tr><th>Nombre</th></tr>";

    foreach ($regiones as $region) {

        echo "<tr><td><a href='../region/" . $region['idregion'] . "'>" . $region['name'] . "</a></td></tr>";
    }

    echo "</table>";
}
?>
