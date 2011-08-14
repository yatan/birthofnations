<style>
.tio {
  position:absolute;
  background-color:#cba;
  left:50px;
  width:90px;
  height:90px;
  margin:5px;
}
</style>

<?
 $n = 0;
$id_guerra = $_GET['id_guerra'];
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
$ataques = sql("SELECT id_usuario, hit FROM log_hits WHERE id_guerra='$id_guerra' ORDER BY id_hit DESC LIMIT 5");
foreach ($ataques as $ataque)
    {
$avatar=sql("SELECT avatar FROM usuarios WHERE id_usuario='".$ataque['id_usuario']."'");
    $x = $n*100;
    echo "<div id ='$n' class='tio'></div>";
        echo "<script>";
        echo "avatar='<img width=32 height=32 src=$avatar/>';";
        echo "$('#$n').append('".id2nick($ataque['id_usuario'])." Daño: ".$ataque['hit']."'+avatar);";
        echo "$('#$n').animate({'left': '+=".$x."px'}, {duration:2000});";
        echo "</script>";
    $n++;
        
    }
?>




