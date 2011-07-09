<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_pais = 1; //Sea como sea que se seleccione

$ofertas = sql("SELECT * FROM mercado_trabajo WHERE id_pais = " . $id_pais);

echo "<table><tr><th>Salario</th><th>Puestos</th></tr>";

foreach ($ofertas as $oferta){
    
    echo "<tr><td>". $oferta['salario'] ."</td><td>". $oferta['cantidad'] ."</td><td>[Aceptar]</td></tr>";
    
}
echo "</table>";
?>
