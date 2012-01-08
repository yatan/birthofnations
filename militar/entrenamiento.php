<?

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");

$diario = sql("SELECT train FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']); //Sacar si ha entrenado

if($diario==0)
{
    sql("UPDATE diario SET train = 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
    sql("UPDATE usuarios SET exp = exp+1, fuerza = fuerza+1 WHERE id_usuario = " . $_SESSION['id_usuario']);
    
echo getString('more_strenght'). "<br>";
echo getString('more_exp');
}
else
    echo getString('military_you_have_trained');
?>
