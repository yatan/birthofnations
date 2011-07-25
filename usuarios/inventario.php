<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$inventario = sql("SELECT * FROM inventario WHERE id_usuario = ". $_SESSION['id_usuario']);

echo "<table><tr><td>Cantidad</td><td>Objeto</td><td>Usar</td></tr>";
unset($inventario['id_usuario']);

foreach($inventario as $objeto => $cantidad){

    if($cantidad == 0 ) { continue; }
    
    echo <<<EOT
    <tr><td> $cantidad </td><td> $objeto </td><td> [<a href="../usuarios/usar_objeto.php?obj=$objeto ">Usar</a>] </td></tr>
EOT;
    
}

echo "</table>";

?>