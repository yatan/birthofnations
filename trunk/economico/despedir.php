<?php

//Mecanismos de seguridad, comprobar que estas logueado como admin y tal

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];

if (isset($_GET['id_worker']) && $_GET['id_worker'] != "" && strlen($_GET['id_worker'])>0 ){

//Mecanismo del despido
sql("UPDATE usuarios SET id_empresa = 0, salario = 0 WHERE id_usuario = " . $_GET['id_worker']);

}
?>
<script>
    window.history.go(-1);
</script>