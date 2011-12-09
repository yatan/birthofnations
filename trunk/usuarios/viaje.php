<?

include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_region.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

//Esta es la variable que llega como destino:

$destino = (int)$_POST['region'];

//Sacamos la region origen

$origen = sql("SELECT salud, id_region FROM usuarios WHERE id_usuario = ". $_SESSION['id_usuario']);

//Comprobar que no es la misma
if($destino == $origen['id_region']){die("Para dar vueltas en circulo te hacesd una noria");}

//Comprobamos la distancia entre las dos regiones, a ver si me acuerdo de como era:

$region_destino = new region($destino);
$region_origen = new region($origen['id_region']);

$ruta = $region_origen->distance_to($destino);

// [1][0] - [1][1] es la ruta
$distancia = (int)$ruta[$destino]['distance'];


//Ahora comprobamos que tiene suficientes objetos necesarios para viajar, cuales sean, pa probar sugus

$tickets = sql("SELECT sugus FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']);

if($tickets >= $distancia && $origen['salud'] > 0 ){//Si puede viajar
    //Quitar items y mierdas y actualizar el pais
    sql("UPDATE usuarios SET salud = salud - 1, id_region = ". $destino . ", id_pais = ".$region_destino->owner_id()." WHERE id_usuario = " . $_SESSION['id_usuario']);
    sql("UPDATE inventario SET sugus = sugus - " . $distancia . " WHERE id_usuario = " . $_SESSION['id_usuario']);
    echo"Has viajado correctamente";
}else{//Si no tiene objetos
    echo "No cumples los requisitos necesarios para viajar, revisa tu existencia, mortal.";
    
}

?>