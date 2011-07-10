<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_pais = 1; //Sea como sea que se seleccione

$ofertas = mysql_query("SELECT * FROM mercado_trabajo WHERE id_pais = " . $id_pais);

echo "<table><tr><th>Salario</th><th>Puestos</th></tr>";

while ($oferta = mysql_fetch_array($ofertas)){
    
    echo "<tr><td>". $oferta['salario'] ."</td><td>". $oferta['cantidad'] .'</td><td>[<a href="/economico/aceptar_trabajo.php?oferta='.$oferta['id_oferta'].'">Aceptar</a>]</td></tr>';
        
}
echo "</table>";
?>
