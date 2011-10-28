<?

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$diario = sql("SELECT train FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']); //Sacar si ha entrenado

if($diario==0)
{
    sql("UPDATE diario SET train = 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
    sql("UPDATE usuarios SET exp = exp+1, fuerza = fuerza+1 WHERE id_usuario = " . $_SESSION['id_usuario']);
    
echo "Has subido fuerza +1<br>";
echo "Has subido +1 de experiencia";
}
else
    echo "Hoy ya has entrenado, intentalo mañana";
?>
