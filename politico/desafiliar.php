<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");


sql("UPDATE usuarios SET id_partido = 0, ant_partido = 0 WHERE id_usuario = " . $_SESSION['id_usuario']);
?>
