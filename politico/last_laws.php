<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include($_SERVER['DOCUMENT_ROOT'] . "/politico/launch_law.php");

//De momento:
check_laws();

?><h3><? echo getString('open_polls'); ?></h3><?
$time = time();

$sql = sql2("SELECT id_votacion, tipo_votacion FROM votaciones WHERE solved = 0 AND is_cargo = 0 AND fin > " . $time . " AND id_pais = " . $id_pais);

foreach ($sql as $votacion) {

    $si = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-1 AND id_votacion = " . $votacion['id_votacion']);
    $no = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-2 AND id_votacion = " . $votacion['id_votacion']);
    echo proposal_text($votacion['tipo_votacion'], $votacion['id_votacion']);
    if (puedo_votar($objeto_usuario->id_usuario, $votacion['tipo_votacion'], $votacion['id_votacion'])) {
        echo "<br><a href=/politico/votar.php?idv=" . $votacion['id_votacion'] . "&vot=-1>".getString('si').": </a>" . $si;
        echo " <a href=/politico/votar.php?idv=" . $votacion['id_votacion'] . "&vot=-2>".getString('no').": </a>" . $no;
    } else {//No puede votar pero que vea los resultados
        echo "<br>".getString('si').": " . $si;
        echo " ".getString('no').": " . $no . "<br>";
    }
}
?><h3><? echo getString('closed_polls'); ?></h3><?
$sql = sql2("SELECT id_votacion, tipo_votacion FROM votaciones WHERE solved = 1 AND is_cargo = 0 AND id_pais = " . $id_pais);
foreach ($sql as $votacion) {

    $si = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-1 AND id_votacion = " . $votacion['id_votacion']);
    $no = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato =-2 AND id_votacion = " . $votacion['id_votacion']);
    echo proposal_text($votacion['tipo_votacion'], $votacion['id_votacion']);

    echo "<br>".getString('si').": " . $si;
    echo " ".getString('no').": " . $no . "<br>";
}

function proposal_text($tipo, $id) {
    switch ($tipo):
        case 100:
            $sql = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id);
            $txt = getString('1prop_100') . " " . $sql . " " . getString('2prop_100');
            break;
        case 105:
            $sql = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id);
            $txt = getString('1prop_105') . " <img src='" . $sql . "'>";
            break;
        case 106:
            $sql = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id);
            $txt = getString('1prop_106'). ": " . $sql;
            break;
    endswitch;
    return $txt;
}
?>
