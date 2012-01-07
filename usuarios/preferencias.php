<?php

/*
 * Code started by: yatan
 * Batamanta Team
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if(isset($_POST['url']) && $_POST!="")
{
    $avatar = htmlentities($_POST['url']);
    sql("UPDATE usuarios SET avatar='$avatar' WHERE id_usuario='".$_SESSION['id_usuario']."'");
    echo "Avatar actualizado correctamente";
}
else
    die("Falta url")
?>
