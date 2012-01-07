<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$cargo=sql("SELECT tipo_votacion FROM votaciones WHERE id_votacion = ".$_GET['v']);

if(puedo_postularme($_SESSION['id_usuario'],$cargo,$_GET['v']) == true){
    
     sql("INSERT INTO candidatos_elecciones(id_votacion,id_candidato,tipo_elecciones,votos) VALUES ('".$_GET['v']."','" . $_SESSION['id_usuario'] . "','".$cargo."','0')");
    
}else{
    die(getString('you_cant'));
}
?>
