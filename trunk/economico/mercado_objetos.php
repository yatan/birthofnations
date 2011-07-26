<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

if(isset($_GET['pais']))
    $pais = $_GET['pais']; 
else
    $pais = sql("SELECT id_pais FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");

//$objeto = $_GET['producto'];

echo "<h1>Mercado de objetos de: ".sql("SELECT name FROM country WHERE idcountry='$pais'")."</h1>";
$objeto="sugus";

$ofertas = sql2("SELECT * FROM mercado_objetos WHERE id_pais = " . $pais . " AND objeto = '". $objeto ."' ORDER BY precio ASC");

echo "<table><tr><th>Empresa</th><th>Precio</th><th>Cantidad</th><th>Comprar</th></tr>";

foreach ($ofertas as $oferta){
    
    $empresa = sql("SELECT nombre_empresa FROM empresas WHERE id_empresa = '" . $oferta['id_empresa']."'");
    
    echo " <tr><td>". $empresa ."</td><td>". $oferta['precio'] ."</td><td>". $oferta['cantidad'] .'</td><td>
<form action="../economico/comprar.php"  method="POST">
            <label for="cantidad"><input tabindex="1" type="text" name="cantidad"></label>
            <label for="id_oferta"><input tabindex="1" type="hidden" name="id_oferta" value = "'. $oferta['id_oferta'] .'"></label>
            <input type="submit" value="Comprar">
        </form>
</td> </tr>'  ;
    
}

echo "</table>";
?>
