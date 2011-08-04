<h1>Usuarios</h1>

<?
    $pos = 1;
    $nick = ""; //$_GET['nick'];
    $resultado=sql("SELECT * FROM usuarios WHERE nick LIKE '%$nick%' ORDER BY exp DESC LIMIT 25");
?>

<table width="75%" border="0" align="center" style="text-align:center;" >
  <tr style="font-size:20px; color:#930;">
    <td>Pos.<hr noshade></td>
     <td>Avatar<hr noshade></td>
    <td>Nick<hr noshade></td>
    <td>Nivel<hr noshade></td>
    <td>EXP<hr noshade></td>
  </tr>

<?

foreach ($resultado as $jugador) 
    {

echo("<tr>");
echo("
<td>$pos</td>
<td><a href='/es/perfil/".$jugador['id_usuario']."'><img src='".$jugador['avatar']."' /></a></td>
<td><a href='/es/perfil/".$jugador['id_usuario']."'>".$jugador['nick']."</a></td>
<td>1</td>
<td>".$jugador['exp']."</td>
</tr>
<tr>
<td colspan='5'><hr /></td>
</tr>
  ");
  $pos++;
    }

?>

</table>



