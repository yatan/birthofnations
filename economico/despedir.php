<?php

//Mecanismos de seguridad, comprobar que estas logueado como admin y tal

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];

if (isset($_GET['id_worker']) && $_GET['id_worker'] != "" && strlen($_GET['id_worker'])>0 )
{

$data = sql("SELECT nombre_empresa, id_propietario FROM empresas WHERE id_empresa = (SELECT id_empresa FROM usuarios WHERE id_usuario  = ".$_GET['id_worker']." )");

if($data==NULL)
{
    incidencia($id_usuario, 1, "Intento de despedir a alguien");
    die("ERROR notificado a un administrador");
}    

$propietario = $data['id_propietario'];
$empresa = $data['nombre_empresa'];

if($id_usuario != $propietario)
{
    if($id_usuario != $_SESSION['id_usuario']){
    incidencia($id_usuario, 1, "Intento de despedir a alguien");
    die("ERROR notificado a un administrador");
    }
}

send_alert($id_usuario, $_GET['id_worker'], 7, $empresa);

//Mecanismo del despido
sql("UPDATE usuarios SET id_empresa = 0, salario = 0 WHERE id_usuario = " . $_GET['id_worker']);

}
?>
<script>
    window.history.go(-1);
</script>