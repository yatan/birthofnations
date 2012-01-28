<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
/*
 * Code started by: yatan
 * Batamanta Team
 */

if(!isset($_POST['id_articulo']))
    die("Error");

if(!isset($_POST['comentario']))
    die("Error");

if(strlen($_POST['comentario'])<=0)
    die("Escribe algo");

$comentario = htmlentities($_POST['comentario'], ENT_QUOTES | ENT_IGNORE, "UTF-8");


$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'http://birthofnations.com/js/markitup/sets/bbcode/parser.php');
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, 'data='.$comentario);
curl_setopt($c, CURLOPT_HEADER, 0);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

$respuesta = curl_exec ($c);
curl_close ($c); 


//$comentario = nl2br($c);
sql("INSERT INTO comentarios_articulos (id_autor, comentario, id_articulo, fecha) VALUES ('{$_SESSION['id_usuario']}','$respuesta','{$_POST['id_articulo']}','".time()."')");

echo getString('comentario_publicado');

?>
