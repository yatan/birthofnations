<?php

//Mecanismos de seguridad, comprobar que estas logueado como admin y tal

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];

if (isset($_GET['id']) && $_GET['id'] != "" && strlen($_GET['id'])>0 ){

sql("UPDATE messages SET deleted = '1' WHERE id = " . $_GET['id']);

}
?>
<script>
    window.history.go(-1);
</script>