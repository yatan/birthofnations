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
    <br><center>Hay: <? echo $online; ?> usuarios online Estado mysql: <? mysql_online(); ?> <a href="/COPYRIGHT">Copyright 2011 Batamanta Team</a> r278 <g:plusone size="small" count="false" href="birthofnations.com"></g:plusone></center> 
</div> <!--pie-->