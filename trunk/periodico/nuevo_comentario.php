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
$comentario = nl2br($comentario);

sql("INSERT INTO comentarios_articulos (id_autor, comentario, id_articulo, fecha) VALUES ('{$_SESSION['id_usuario']}','$comentario','{$_POST['id_articulo']}','".time()."')");

echo getString('comentario_publicado');

?>
