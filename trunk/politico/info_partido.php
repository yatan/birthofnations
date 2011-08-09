<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if (!isset($_GET['id_partido']))
    die("Error: id no valido"); //Substituir por error 404

$party = sql("SELECT * FROM partidos WHERE id_partido = " . $_GET['id_partido']);
$leader = sql("SELECT nick, avatar FROM usuarios WHERE id_usuario = " . $party['id_lider']);
$user = sql("SELECT id_partido, id_nacionalidad FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);

echo "<h1>" . '<img src="' . $party['url_bandera'] . '">';
echo $party['nombre_partido'] . "</h1>";

if ($user['id_nacionalidad'] == $party['id_pais'] && $user['id_partido'] == 0) {//Condiciones para poder afiliarse
    echo '<a href="afiliar.php?af=' . $party['id_partido'] . '">Afiliar</a>';
} elseif ($user['id_partido'] == $_GET['id_partido']) {//Condiciones para desafiliarse
    echo '<a href="desafiliar.php?af=' . $party['id_partido'] . '">Afiliar</a>';
}

echo "Jefe actual: " . $leader['nick'] . '<img src="' . $leader['avatar'] . '">';

$sql = sql("SELECT COUNT(*) FROM usuarios WHERE id_partido = " . $_GET['id_partido']);

echo "<h2> Lista de miembros (" . $sql . ")</h2>";

$sql = sql2("SELECT id_usuario, nick FROM usuarios WHERE id_partido = " . $_GET['id_partido']);

foreach ($sql as $miembro) {
    echo '<a href="../perfil/' . $miembro['id_usuario'] . '">' . $miembro['nick'] . '</a><br>';
}
?>