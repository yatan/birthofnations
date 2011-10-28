<h1>Entrenamiento Militar</h1>

  
<?

$militar = sql("SELECT fuerza, rango, p_combat FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");

$fuerza = $militar['fuerza'];
$rango = $militar['rango'];
$p_combat = $militar['p_combat'];

echo <<<EOT

<p>Fuerza: $fuerza</p>
<p>Rango: $rango</p>
<p>Puntos de combate: $p_combat</p>

EOT;

?>
