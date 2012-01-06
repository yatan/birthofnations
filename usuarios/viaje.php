<?

include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_region.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
require($_SERVER['DOCUMENT_ROOT'] . "/usuarios/objeto_usuario.php");
$objeto_usuario = new usuario($_SESSION['id_usuario']); 

if (isset($_POST['region']) && $_POST['region'] != "" && strlen($_POST['region']) > 0) {

//Esta es la variable que llega como destino

    $destino = (int) $_POST['region'];

//Sacamos la region origen

    $origen = sql("SELECT salud, id_region FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);

//Comprobar que no es la misma
    if ($destino == $origen['id_region']) {
        die("Para dar vueltas en circulo te haces una noria");
    }

//Comprobamos la distancia entre las dos regiones, a ver si me acuerdo de como era:

    $region_destino = new region($destino);
    $region_origen = new region($origen['id_region']);

    $ruta = $region_origen->distance_to($destino);

// [1][0] - [1][1] es la ruta
    $distancia = (int) $ruta[$destino]['distance'];

//Ahora comprobamos que tiene suficientes objetos necesarios para viajar, cuales sean, pa probar sugus

    $tickets = sql("SELECT transporte FROM inventario WHERE id_usuario = " . $_SESSION['id_usuario']); //Comentario temporal

    if ($tickets >= $distancia && $origen['salud'] >= $min_travel_health) {//Si puede viajar
        //Quitar items y mierdas y actualizar el pais
        sql("UPDATE usuarios SET salud = salud - 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
        sql("UPDATE inventario SET transporte = transporte - " . $distancia . " WHERE id_usuario = " . $_SESSION['id_usuario']);
        $tiempo = time() + (60 * $distancia);
        sql("INSERT INTO viajes(id_usuario, hora_final, id_region_destino) VALUES('" . $_SESSION['id_usuario'] . "','$tiempo','$destino')");
        $objeto_usuario->add_status("v");
        echo"Empieza el viaje, durara $distancia minutos";
    } else {//Si no tiene objetos
        echo getString('cant_travel');
    }
} else {
    die("So quick...");
}
?>