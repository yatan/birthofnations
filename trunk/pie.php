<?
if(isset($_SESSION['id_usuario']))
{
    sql("UPDATE usuarios SET ultima_accion='".time()."' WHERE id_usuario='".$_SESSION['id_usuario']."'");
}
//Se calcula como maximo 15 minutos para diferenciar la gente online de la offline
$calculo_minutos = time()-(60*15);
$online = sql("SELECT COUNT(*) FROM usuarios WHERE ultima_accion >= '$calculo_minutos'");
?>

<div id="pie"> 
    <br><center>Hay: <? echo $online; ?> usuarios online Estado mysql: <? mysql_online(); ?> <a href="/COPYRIGHT">Copyright 2011 Batamanta Team</a> r278<g:plusone size="small" count="false" href="birthofnations.com"></g:plusone><iframe src="http://www.facebook.com/plugins/like.php?app_id=192573380805156&amp;href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FBirth-of-Nations%2F134127996678808&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></center> 
</div> <!--pie-->