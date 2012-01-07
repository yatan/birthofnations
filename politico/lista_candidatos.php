<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$votacion = sql("SELECT tipo_votacion FROM votaciones WHERE id_votacion = ". $_GET['id']);
$candidatos = sql2("SELECT * FROM candidatos_elecciones WHERE id_votacion = " . $_GET['id']);

foreach($candidatos as $cand){
    echo getString('candidate') . id2nick($cand['id_candidato']) . "<br> ". getString('votes') . $cand['votos'] . "<br>";
    if(puedo_votar($_SESSION['id_usuario'],$votacion,$_GET['id']) == true){
        echo '<a href="votar.php?idv='.$_GET['id'].'&vot='.$cand['id_candidato'].'">'.getString('votar').'</a><br>';
    }
}

?>