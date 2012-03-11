<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
/*
 * Code started by: yatan
 * Batamanta Team
 */

$id = 1;

$guerra = sql("SELECT total_atacantes, total_defensores, estado FROM wars WHERE id_guerra = $id");
$estado = $guerra['estado'];
$total_atacantes = $guerra['total_atacantes'];
$total_defensores = $guerra['total_defensores'];


$muro = ( $total_atacantes / ($total_atacantes + $total_defensores )) * 100;
$muro = rfloor($muro, 0);
$muro = str_replace(".", "", $muro);

$top_a = sql("SELECT id_usuario, SUM(hit) FROM log_hits WHERE id_guerra = 1 AND lado='a' GROUP BY id_usuario DESC LIMIT 1");
$top_a_nick = id2nick($top_a['id_usuario']);
$top_a_dano = $top_a['SUM(hit)'];

$top_d = sql("SELECT id_usuario, SUM(hit) FROM log_hits WHERE id_guerra = 1 AND lado='d' GROUP BY id_usuario DESC LIMIT 1");
$top_d_nick = id2nick($top_d['id_usuario']);
$top_d_dano = $top_d['SUM(hit)'];


$arr = array('top_a' => "$top_a_nick", 'top_d' => "$top_d_nick", 'dano_a' => "$top_a_dano", 'dano_d' => "$top_d_dano", 'muro' => "$muro", 'estado' => "$estado");

echo json_encode($arr);


?>
