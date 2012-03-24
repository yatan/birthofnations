<?php

require($_SERVER['DOCUMENT_ROOT'] . "/politico/clase_grafo.php");
//require($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");


// I is the infinite distance.
define('I', 1000);

// Size of the matrix (Numero de regiones del juego)
$matrixWidth = 6;

// $points is an array in the following format: (router1,router2,distance-between-them)

for ($i = 1; $i <= $matrixWidth; $i++) {

    $sql = sql("SELECT * FROM distancia_regiones WHERE id_region = " . $i);

    for ($j = $i + 1; $j <= $matrixWidth; $j++) {

        if ($sql['r' . $j] <= -1) {
            continue;
        } else {
            $points[] = array($i, $j, (int) $sql['r' . $j]);
        }
    }
}

$ourMap = array();


// Read in the points and push them into the map

foreach ($points as $point) {
    $x = $point[0];
    $y = $point[1];
    $c = $point[2];
    $ourMap[$x][$y] = $c;
    $ourMap[$y][$x] = $c;
}

// ensure that the distance from a node to itself is always zero
// Purists may want to edit this bit out.

for ($i = 0; $i < $matrixWidth; $i++) {
    $ourMap[$i][$i] = 0;
}


// initialize the algorithm class
$grafo_region = new Dijkstra($ourMap, I, $matrixWidth);

//$grafo_region->findShortestPath(2); //Origen region 2
//var_dump($grafo_region->getResults()); //Destino region 3
?>