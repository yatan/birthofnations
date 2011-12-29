<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

include($_SERVER['DOCUMENT_ROOT'] . "/politico/launch_law.php");
?><h3><? echo getString('open_polls'); ?></h3><?
$time = time();

$sql = sql2("SELECT id_votacion, tipo_votacion FROM votaciones WHERE solved = 0 AND is_cargo = 0 AND fin > " . $time . " AND id_pais = " . $id_pais);

foreach ($sql as $votacion) {

    $si = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-1 AND id_votacion = " . $votacion['id_votacion']);
    $no = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-2 AND id_votacion = " . $votacion['id_votacion']);
    echo proposal_text($votacion['tipo_votacion'],$votacion['id_votacion']);
    if (puedo_votar($objeto_usuario->id_usuario, $votacion['tipo_votacion'], $votacion['id_votacion'])) {
        echo "<br><a href=../politico/votar.php?idv=" . $votacion['id_votacion'] . "&vot=-1>Si: </a>" . $si;
        echo " <a href=../politico/votar.php?idv=" . $votacion['id_votacion'] . "&vot=-2>No: </a>" . $no;
    } else {//No puede votar pero que vea los resultados
        echo "Si: " . $si;
        echo "No: " . $no;
    }
}
?><h3><? echo getString('closed_polls'); ?></h3><?

function proposal_text($tipo,$id){
    switch($tipo):
        case 100:
            $sql = sql("SELECT param1 FROM votaciones WHERE id_votacion = ".$id);
            $txt = getString('1prop_100') ." ". $sql ." ". getString('2prop_100');
            break;
    endswitch;
    return $txt;
}



?>
