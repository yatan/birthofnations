<?
$id_guerra = $_GET['id_guerra'];
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
$ataques = sql("SELECT id_usuario, hit FROM log_hits WHERE id_guerra='$id_guerra' ORDER BY id_hit DESC LIMIT 10");
foreach ($ataques as $ataque)
    {
    echo"<p>".$ataque['id_usuario']." Daño: ".$ataque['hit'];
    }
?>
