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


echo "<table><tr><td>Objeto</td><td>Cantidad</td><td>Usar</td></tr>";
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
        echo "<tr><td>" . item2img($id) . "</td><td class='item_$id'> $cantidad  </td><td> [<a class='usar' id='$id' href='#'>Usar</a>] </td></tr>";
    else
        echo "<tr><td>" . item2img($id) . "</td><td> $cantidad  </td><td>  </td></tr>";

    
}

echo "</table>";

?>

<script type="text/javascript">
$('.usar').click(function() {
        var element = $(this);
        var Id = element.attr("id");
        
        
        var notice = $.pnotify({
        pnotify_title: "<? echo getstring('use_item'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.get("/usuarios/usar_item.php", {id: Id},
         function(data) {
          var options = {
                pnotify_text: data
            };
            notice.pnotify(options);
         });
         
         
    });
</script>
    