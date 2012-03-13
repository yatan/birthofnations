<?
 $n = 0;
$id_guerra = $_GET['id_guerra'];
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$sql = sql("
SELECT id_usuario, hit, id_hit 
FROM log_hits 
WHERE id_guerra = 1 AND lado='a' 
ORDER BY id_hit DESC LIMIT 5 ");

$arr = array();
$arr['last_a'] = $sql[4]['id_hit'];
$posicion = 0;

foreach ($sql as $hit) {
   
   $html = "<div style='margin: auto; width: 100px;'>".  id2nick($hit['id_usuario'])."<br><img widht='50px' height='50px' src='/images/no_avatar.gif'/><div style='color:red;'>".$hit['hit']."</div></div>";
   $arr['a_'.$posicion] = array('html' => $html, 'id' => $hit['id_hit']);
   $posicion++;
}

//$arr = array('id_hit' => $id_hit, 'html' => $html);

echo json_encode($arr);
?>