<?php

$dia = sql("SELECT day FROM settings");
$gold = $objeto_usuario->gold;
$mensajes = sql("SELECT COUNT(*) FROM messages WHERE id_receptor='" . $_SESSION['id_usuario'] . "' AND leido='0' AND deleted='0'");
$alertas = sql("SELECT COUNT(*) FROM alertas WHERE id_receptor='" . $_SESSION['id_usuario'] . "' AND leido='0'");
$pais = sql("SELECT name, url_bandera FROM country WHERE idcountry='{$objeto_usuario->id_pais}'");


$nick = $objeto_usuario->nick;
$estado = $objeto_usuario->status;
$salud = $objeto_usuario->salud;

if ($estado != null) {
    $a_estado = explode(",", $estado);
    $i_estado = "";
    foreach ($a_estado as $estado2) {
        switch ($estado2) {
            case "a":
                $i_estado = $i_estado . "<img title='" . getString('stat_a') . "' src='/images/status_bar/status/2.png'/> ";
                break;
            case "b":
                $i_estado = $i_estado . "<img title='" . getString('stat_b') . "' src='/images/status_bar/status/3.png'/> ";
                break;
            case "c":
                $i_estado = $i_estado . "<img title='" . getString('stat_c') . "' src='/images/status_bar/status/4.png'/> ";
                break;
            case "v":
                $i_estado = $i_estado . "<img title='" . getString('stat_v') . "' src='/images/status_bar/status/viaje.gif'/> ";
                break;
            case "S":
                $i_estado = $i_estado . "<img title='" . getString('stat_S') . "' src='/images/status_bar/status/5.png'/> ";
                break;
            default:
                $i_estado = $i_estado . "";
        }
    }
} else
    $i_estado = "<img src='/images/status_bar/status/1.png'/>";

echo "$i_estado - <a style='text-decoration:none;' href='/" . $_GET['lang'] . "/perfil/" . $_SESSION['id_usuario'] . "'><b>$nick</b></a>"
    . " - "
    . "Level: $objeto_usuario->level - Exp: $objeto_usuario->exp"
    . " - "
    . "<img alt='bandera' title='" . $pais['name'] . "' src='" . $pais['url_bandera'] . "'>"
    . " - "
    . "<img alt='vida'  src='/images/status_bar/life.gif'> $salud"
    . " - "
    . "<img alt='gold' src='/images/status_bar/gold.gif'> $gold golds"
    . " - ";
echo "<a style='text-decoration:none;' href='/" . $_GET['lang'] . "/mensajes'>";
if ($mensajes == 0 || $mensajes == false)
    echo "<img alt='no_mail' src='/images/status_bar/no_mail.gif' > <b>0</b>";
elseif ($mensajes == 1)
    echo "<img alt='mail' src='/images/status_bar/mail.gif' > <b>1</b>";
elseif ($mensajes > 1)
    echo "<img alt='/mail' src='/images/status_bar/mail.gif' > <b>$mensajes</b>";
echo "</a>";

echo " - ";


echo "<a style='text-decoration:none;' href='/" . $_GET['lang'] . "/alertas'>";
if ($alertas == 0 || $alertas == false)
    echo "<img src='/images/status_bar/no_alert.png' alt='no_alert'> <b>0</b>";
elseif ($alertas >= 1)
    echo "<img alt='alert' src='/images/status_bar/alert.png'> <b>$alertas</b>";
echo "</a>";
echo "<a style='padding-left: 3em; text-align:right;'>Dia: $dia</a>";

?>

<div id="buscador" style="float:right;">
    <?php
    include("usuarios/form_buscador.php");
    ?>
</div>


<div id="barra_derecha" style="position: absolute; left:100%; top:50%; margin-left: -35px;">
    <img id="flecha" src="/images/side/flecha.gif" />
    <div id="monedas_barra" style="z-index: 5; background-color: #1c94c4; position:absolute; display: none; top:50%; width:75px; left:100%;margin-top: 0px; margin-left: 0px;">
        <?php include("usuarios/dinero.php"); ?>
    </div>
</div>

<script>
    $("#barra_derecha").hover(
        function() {
            $("#flecha").hide();
            $("#monedas_barra").show();
        },
        function() {
            $("#flecha").show('fast');
            $("#monedas_barra").hide('fast');
        }
    );
</script>