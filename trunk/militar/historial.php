<style>
.tio {
  position:absolute;
  background-color:#cba;
  left:50px;
  width:90px;
  height:90px;
  margin:5px;
  display: none;
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
    $x = $n*75;
    $y = $x * 1000;
        ?>
        <div id ='<? echo $n; ?>' class='tio' style="left:<? echo $x; ?>;"></div>
        <script>
                function heroi(nick, hit, avatar)
                {
                    $("#<? echo $n; ?>").append(nick+' Daño:'+hit, avatar);
                    $("#<? echo $n; ?>").animate({"left": "+=50", "opacity": 1},{duration: <? echo $x*10;?>});
                    $("#<? echo $n; ?>").show("slow");
                }
            avatar='<img width=32 height=32 src=<? echo $avatar; ?>/>';
            setTimeout(heroi('<? echo id2nick($ataque['id_usuario'])."','".$ataque['id_usuario'];?>',avatar),<? echo $y; ?>);
        </script>
        

        <?
    $n++;
        
    }
?>




