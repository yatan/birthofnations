<?

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

if (!isset($_GET['tipo'])) {
    $tipo = 1;
} else {
    $tipo = $_GET['tipo'];
}

if (!isset($_GET['pais'])) {
    $country = 2;
}


$empresas = sql2("SELECT empresas.id_empresa, tipo, nombre_empresa, mercado_empresas.precio FROM mercado_empresas  LEFT JOIN empresas ON empresas.id_empresa=mercado_empresas.id_empresa WHERE pais=" . $country . " AND tipo = " . $tipo . " ORDER BY precio ASC");

//Elegimos las empresas que esten en el mercado cuyo pais sea el elegido (ohh el elegido).

var_dump($empresas);

if ($empresas == null) {
    echo getString("no_selling_companies");
} else {
    echo "<table><tr><th>" . getString("type") . "</th><th>" . getString("name") . "</th><th>" . getString("precio") . "</th><th>" . getString("comprar") . "</th></tr>";
    foreach ($empresas as $empresa) {
        echo "<tr><td>".$empresa['tipo']."</td><td>".$empresa['nombre_empresa']."</td><td>".$empresa['precio']."</td><td><a href='comprar_empresa.php?id=".$empresa['id_empresa']."'>Comprar</a></td></tr>";
    }
}
?>
