<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
?>
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>

<?php
if (!isset($_GET['id_usuario']))
    die("Error: id no valido"); //Sustituir por error 404


$id_usuario = $_GET['id_usuario'];
if ($id_usuario != $objeto_usuario->id_usuario) {
    $usuario = new usuario($id_usuario);
} else {
    $usuario = $objeto_usuario;
}
if ($usuario->id_usuario == null)
    die("No existe el usuario"); //Aqui mostrar error 404
else {
?>
    <div id="tabs">
        <ul class="ui-tabs">
            <li><a href="#amigos">Perfil</a></li>
            <?php
            if ($usuario->soy_yo($_SESSION['id_usuario']) == true) {
                //echo "<li><a href='#economia'>Economia</a></li>";
                echo "<li><a href='#inventario'>Inventario</a></li>";
                echo "<li><a href='#viajar'>Viajar</a></li>";
                echo "<li><a href='#periodico'>Periodico</a></li>";
                echo "<li><a href='#invitar'>Invitar</a></li>";
            }
            ?>

        </ul>

        <?php
        echo "<div style='height: 500px; width: 940px;'>";
        echo "<div style='float: left; width: 15em; height: 28.45em;'>";
        echo "<h2>Perfil de $usuario->nick </h2>";
        echo "<img src='$usuario->avatar' style='max-height: 128px; max-width: 128px; overflow: hidden;'/><br>";
        echo "<p style='font-size: 14px; text-align: left; margin: 10px;'>Pais: <a href='/$idioma/pais/{$usuario->id_pais}'>{$usuario->get_n_pais()}</a></p>";
        echo "<p style='font-size: 14px; text-align: left; margin: 10px;'>Region: <a href='/$idioma/region/{$usuario->id_region}'>{$usuario->get_n_region()}</a></p>";
        echo "<p style='font-size: 14px; text-align: left; margin: 10px;'>Nacionalidad: <a href='/$idioma/pais/{$usuario->id_nacionalidad}'>{$usuario->get_n_nacionalidad()}</a>";
        if ($usuario->soy_yo($_SESSION['id_usuario']) == true)
            echo "<a href='/{$_GET['lang']}/ciudadania' style='font-size: 14px; text-align: left; margin: 10px;'>(Cambiar)</a></p>";
        else
            echo "</p>";
        echo "<div style='font-size: 12px; text-align: left; margin: 10px; height: 29em;'>";
        echo "<center><strong>Descripci&oacute;n</strong></center>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        echo "</div>";
        echo "</div>";


        //Aqui si el perfil es el mio hace el include a
        //pagina para editar cosas, sino se pagina de perfil publico


        if ($usuario->soy_yo($_SESSION['id_usuario']) == true) {
        ?>
            <div id="newavatar" style="float:right; ">
                <fieldset>
                    <legend>Preferencias:</legend>
                    <form action="/usuarios/preferencias.php" method="post">
                        Url avatar: <input type="text" name="url" />
                        <br>
                        <p>Maximo recomendado 64x64</p>
                        <input type="submit" value="Actualizar" />
                    </form>
                </fieldset>
            </div>
    <?php
            /*echo "<div id='economia'>";
                include("mi_perfil.php");
                echo "</div>";*/
            echo "<div id='inventario'>";
            echo "<div style='float:left;'>";
            echo "<h2>Inventario</h2>";
            include("inventario.php");
            echo "</div>";
            echo "<div style='float:right;'>";
            include("mi_perfil.php");
            echo "</div>";
            echo "</div>";
            echo "<div id='viajar'>";
            include("viajar.php");
            echo "</div>";
            echo "<div id='periodico'>";
            include("periodico/redactar.php");
            echo "</div>";
            echo "<div id='invitar'>";
            include("form_referer.php");
            echo "</div>";
        } else {
            //Zona publica
            echo "<div>";
            if ($usuario->somos_amigos($_SESSION['id_usuario']) == false)
                echo "<a href='../../usuarios/add_friend.php?id=$usuario->id_usuario'><img src='/images/friend.png'/>Añadir amigo</a>";
            echo "</div>";
        }
        //Zona tanto publica como privada
        //Maquetacion
        if ($usuario->soy_yo($_SESSION['id_usuario']) == true)
            echo "<div id='amigos' style='width:200px; float: right; height: 26.45em;'>";
        else
            echo "<div id='amigos' style='float: right; height: 26.45em; width: 34em;'>";

        include("friends.php");
        echo "</div>";
    }
    echo "</div>";
    ?>
    </div>

    <br>