<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

echo "<h1>" .  getString('company_my_companies') . "</h1>";

//$cantidad_empresas = sql("SELECT COUNT(id_empresa) FROM empresas WHERE id_propietario='".$_SESSION['id_usuario']."'");

$sql = sql2("SELECT * FROM empresas WHERE id_propietario='" . $_SESSION['id_usuario'] . "'");

//if($cantidad_empresas == 1)
//echo "<a href='/".$_GET['lang']."/empresa/".$sql['id_empresa']."'>".$sql['nombre_empresa']."</a><br/>";
//else {

if(count($sql) > 0) {

  echo "<table><tr><th>Tipo</th><th>" .  getString('company_list_name') . "</th></tr>";
  
  foreach ($sql as $empresa) {
    echo '<tr><td><img width="33" height="33" src="..' .  id2itemimg($empresa['tipo']) . '" title="' .  id2item($empresa['tipo']) . '">';
    echo "</td><td><a href='/" . $_GET['lang'] . "/empresa/" . $empresa['id_empresa'] . "'>" . $empresa['nombre_empresa'] . "</a></td></tr>";
  }

  echo "</table>";
}
?>
<br />
<a style=" background-color:#1E679A ; border: 1px solid #1E679A;" href="<?php echo "/" . $_GET['lang'] . "/crear_empresa"; ?>">
  <font color="#FFFFFF" face="arial, verdana, helvetica"><?php echo getString('company_create_bussiness'); ?></font>
</a>
<br />
<br />