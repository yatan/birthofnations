<?

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");

$inventario = sql("SELECT * FROM inventario WHERE id_usuario = ". $_SESSION['id_usuario']);

/*
_________uu$$$$$$$$$$$$$$$$$uu__________
_________u$$$$$$$$$$$$$$$$$$$$$u_________
________u$$$$$$$$$$$$$$$$$$$$$$$u________
_______u$$$$$$$$$$$$$$$$$$$$$$$$$u_______
_______u$$$$$$$$$$$$$$$$$$$$$$$$$u_______
_______u$$$$$$”___”$$$”___”$$$$$$u________
_______”$$$$”______u$u_______$$$$”________
________$$$———u$u_______u$$$________
________$$$u______u$$$u______u$$$________
_________”$$$$uu$$$___$$$uu$$$$”_________
__________”$$$$$$$”___”$$$$$$$”__________
____________u$$$$$$$u$$$$$$$u____________
_____________u$”$”$”$”$”$”$u______________
__uuu________$$u$_$_$_$_$u$$_______uuu__
_u$$$$________$$$$$u$u$u$$$_______u$$$$_
__$$$$$uu______”$$$$$$$$$”_____uu$$$$$$__
u$$$$$$$$$$$uu____”"”"”____uuuu$$$$$$$$$$
$$$$”"”$$$$$$$$$$uuu___uu$$$$$$$$$”"”$$$”
_”"”______”"$$$$$$$$$$$uu_”"$”"”___________
___________uuuu_”"$$$$$$$$$$uuu___________
__u$$$uuu$$$$$$$$$uu_”"$$$$$$$$$$$uuu$$$__
__$$$$$$$$$$”"”"___________”"$$$$$$$$$$$”__
___”$$$$$”______________________”"$$$$”"__
 
  
Sustituir el array de abajo cuando haya mas de 1 item usable 
 */

//$items_usables = sql("SELECT nombre FROM items WHERE usable='1'");
$items_usables = array("0" => array('nombre'=>'pan'));


echo "<table><tr><td>Cantidad</td><td>Objeto</td><td>Usar</td></tr>";
unset($inventario['id_usuario']);

foreach($inventario as $item => $cantidad){
    //Suponemos que cada item no se puede usar, hasta comprobacion
    $usable = false;

    if($cantidad == 0 ) { continue; }
    
    $id = obj_to_id($item);
    
    //Recorremos los items que son usables y asignamos si se puede usar o no
    foreach ($items_usables as $usado) {
        if($item == $usado['nombre'])
            $usable = true;
    }
    
    if($usable==true)
    echo <<<EOT
    <tr><td> $cantidad </td><td> $item </td><td> [<a href="/usuarios/usar_item.php?id=$id ">Usar</a>] </td></tr>
EOT;
    else
            echo <<<EOT
    <tr><td> $cantidad </td><td> $item </td><td>  </td></tr>
EOT;
    
}

echo "</table>";

?>