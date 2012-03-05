<?php

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

/*
 * Code started by: yatan
 * Batamanta Team
 */
if(isset($_POST['id_pais']))
    $id_pais = $_POST['id_pais'];
else
    die("Error al seleccionar el pais");

$nacionalidad_actual = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");

if ($id_pais == $nacionalidad_actual)
    die("Ya tienes la nacionalidad en ese pais");

sql("UPDATE usuarios SET id_nacionalidad='$id_pais' WHERE id_usuario='".$_SESSION['id_usuario']."'");

echo "Cambio de ciudadania realizado correctamente";
?>
