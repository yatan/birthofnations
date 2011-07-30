<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");

$inventario = sql("SELECT * FROM inventario WHERE id_usuario = ". $_SESSION['id_usuario']);

echo "<table><tr><td>Cantidad</td><td>Objeto</td><td>Usar</td></tr>";
unset($inventario['id_usuario']);

foreach($inventario as $item => $cantidad){

    if($cantidad == 0 ) { continue; }
    
    $id = obj_to_id($item);
    
    echo <<<EOT
    <tr><td> $cantidad </td><td> $item </td><td> [<a href="../usuarios/usar_item.php?id=$id ">Usar</a>] </td></tr>
EOT;
    
}

echo "</table>";

?>