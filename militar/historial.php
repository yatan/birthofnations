<?
 $n = 0;
$id_guerra = $_GET['id_guerra'];
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_hit=rand(1,10);
$html = "<div style='margin: auto; width: 100px;'>holaaaaa<br><img widht='50px' height='50px' src='/images/no_avatar.gif'/><div style='color:red;'>".rand(0, 1000)."</div></div>";

$arr = array('id_hit' => $id_hit, 'html' => $html);

echo json_encode($arr);
?>