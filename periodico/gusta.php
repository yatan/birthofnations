<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
$id_usuario = $_SESSION['id_usuario'];
if ($_GET['articulo_id'] != NULL) {
    $estearticulo = mysqli_query($link, "SELECT * FROM articulos WHERE id_articulo=$_GET[articulo_id]");
    if (mysqli_num_rows($estearticulo) > 0) {
        $estearticulov = mysqli_query($link, "SELECT * FROM articulos_votos WHERE id_articulo=$_GET[articulo_id] AND id_votador=$id_usuario");
        if (mysqli_num_rows($estearticulov) > 0) {
            if ($_GET['doing'] == 3) {
                sql("DELETE FROM  articulos_votos WHERE id_articulo=$_GET[articulo_id] AND id_votador=$id_usuario");
                echo getString('has_borrado_voto');
            } elseif ($_GET['doing'] == 4) {
                sql("DELETE FROM  articulos_votos WHERE id_articulo=$_GET[articulo_id] AND id_votador=$id_usuario");
                echo getString('has_borrado_voto');
            } else {
                echo getString('periodico_ya_has_votado');
            }
        } else {
            if ($_GET['doing'] == 1) {
                sql("INSERT INTO articulos_votos (id_articulo,id_votador,tipo) VALUES ('$_GET[articulo_id]','$id_usuario','1')");
                echo getString('has_votado_positivamente');
            } elseif ($_GET['doing'] == 2) {
                sql("INSERT INTO articulos_votos (id_articulo,id_votador,tipo) VALUES ('$_GET[articulo_id]','$id_usuario','2')");
                echo getString('has_votado_negativamente');
            }
        }
    } else {
        echo getString('periodico_articulo_no_existe');
    }
} else {
    echo getString('periodico_articulo_no_existe');
}
