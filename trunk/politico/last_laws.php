<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

include($_SERVER['DOCUMENT_ROOT'] . "/politico/launch_law.php");

?><h3><?echo getString('open_polls');?></h3><?
$time = time();

$sql = sql2("SELECT * FROM votaciones WHERE solved = 0 AND is_cargo = 0 AND id_pais = " . $id_pais);

//var_dump($sql);
?><h3><?echo getString('closed_polls');?></h3><?

?>
