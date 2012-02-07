<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

if (!isset($_GET['id_pais'])) {
    $_GET['id_pais'] = $objeto_usuario->id_nacionalidad;
}

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);

//Buscamos los cargos que tiene en el pais seleccionado

if (!isset($_POST['f'])) {
    $cargos = $pais->list_cargos();//Sacamos la lista de cargos del pais

    foreach ($cargos as $cargo) {//PAra cada uno de ellos

        if (check_leader($cargo['id_cargo'], $_SESSION['id_usuario']) == true) {//Si el usuario lo tiene
            $position[] = $cargo['id_cargo'];//Lo añadimos a esta lista
        }
    }

//Ya tenemos la lista de cargos de una persona, ahora sacamos la lista de leyes.

    if (!isset($position)) {//Si no tiene cargos
        //Nada xD
    } else {//EL resto
        foreach ($position as $pos) {

            $leyes[] = list_laws_raw($pos);
        }
//Filtramos
//Bajamos un nivel el array

        foreach ($leyes as $ley) {

            foreach ($ley as $data) {
                $leyes2[] = $data;
            }
        }

        $leyes = array_unique($leyes2); //Quitamos duplicados y ordenamos alfabeticamente
        asort($leyes);

        $leyes2 = "";
//Explotamos
        foreach ($leyes as $ley) {
            $leyes2[] = explode('-', $ley);
        }
        ?>
        <form id="ley" method ="POST" action="">
            <select name='f'>
                <?
                foreach ($leyes2 as $ley) {

                    echo "<option value='" . $ley[0] . "-" . $ley[1] . "'>" . getString('law_' . $ley[0]) . "</option>";//" (" . $ley[1] . ")</option>";
                }
                ?>
            </select>
            <input type="submit" id="enviar" value="Enviar"></input>
        </form>

        <?
    }
}

if (isset($_POST['f'])) {
    $ley = explode('-', $_POST['f']);
    ?>
    <form id="ley" action="/politico/launcher.php" method ="POST">
        <?
        $f = law_param_names($ley[0]);
        echo "<input type='hidden' name='data' value='" . $ley[0] . "-" . $ley[1] . "'>";
        echo "<input type='hidden' name='id_pais' value='" . $_GET['id_pais'] . "'>";
        for ($i = 0; $i < law_params($ley[0]); $i++) {
            echo "<input name='p[" . $i . "]' value='". $f[$i] ."'><br>"; //Tiene ese nombre para que la siguiente pagina puedo leerlo como un array
        }
        ?>

        <input type="submit" id="enviar" value="Enviar"></input>
    </form>
    <?
}
?>