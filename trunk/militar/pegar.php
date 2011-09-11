<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
$usuario = $_POST['id_usuario'];
$hit = rand(0,100);

sql("INSERT INTO log_hits(id_guerra, id_usuario, lado, hit) VALUES('1','$usuario','a','$hit')");
?>
