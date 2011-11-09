<?

/*
 * Hay que añadir la comprobacion de que las ids que llegan por
 * POST pertenecen a su dueño
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

//session_start();
//echo "nick: ".$_SESSION['id_usuario'];

$contador = 0;


if (isset($_POST['alertas']))
{
foreach ($_POST['alertas'] as $alerta) {
    sql("UPDATE alertas SET tipo='0' WHERE id_alerta='$alerta'");
    $contador += 1;
}
}
echo "Alertas eliminadas: $contador";
?>
