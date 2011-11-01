<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

//Temporal hasta que se ponga en el hta
$_GET['id_pais'] = 2;

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$id_pais = $_GET['id_pais'];

$pais = new pais($id_pais);

//Buscamos los cargos que tiene en el pais seleccionado

if (!isset($_GET['f'])) {
    $cargos = $pais->list_cargos();

    foreach ($cargos as $cargo) {

        if (check_leader($cargo['id_cargo'], $_SESSION['id_usuario']) == true) {
            $position[] = $cargo['id_cargo'];
        }
    }

//Ya tenemos la lista de cargos de una persona, ahora sacamos la lista de leyes.

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
    <form id="ley" method ="POST" action="./launch_law.php">
        <select name='f'>
            <?
            foreach ($leyes2 as $ley) {

                echo "<option value='" . $ley[0] . "-" . $ley[1] . "'>" . $txt['law_' . $ley[0]] . " (" . $ley[1] . ")</option>";
            }
            ?>
        </select>
        <input type="submit" id="enviar" value="Enviar"></input>
    </form>

    <?
}

if (isset($_POST['f'])) {
    $ley = explode('-',$_GET['f']);
    ?>
    <form id="ley" action="../politico/launcher.php" method ="POST">
    <?
        echo "<input type='hidden' value='" . $ley[0] . "-" . $ley[1] . "'>";
        for($i=1;$i<=law_params($ley[0]);$i++){
            echo "<input name='p".$i."'><br>";
        }
    ?>
    
    <input type="button" id="enviar" value="Enviar"></input>
</form>
<?
}
?>