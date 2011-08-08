<?php

require($_SERVER['DOCUMENT_ROOT'] . "/politico/clase_grafo.php");


// I is the infinite distance.
define('I', 1000);

// Size of the matrix
$matrixWidth = 3;

// $points is an array in the following format: (router1,router2,distance-between-them)
$points = array(
    array(1, 2, 1),
    array(1, 3, 2),
);

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