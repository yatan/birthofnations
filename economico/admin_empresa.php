<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/economico/moneda_local.php");
global $link;

if (!isset($_GET['id_empresa']))
    die(getString("company_error_not_valid")); //Sustituir por error 404


$id_empresa = $_GET['id_empresa'];

//var_dump($empresa);
//El objeto empresa ya esta declarado ya que este script se llama con include
$empresa = new empresa($id_empresa);

//echo "<br>".getString ("company").": ".$empresa->nombre_empresa . " (" . getString('empresa_tipo'. $empresa->get_tipo() ) . ")";

echo <<<EOT
<form id="cambiar_nombre_empresa" action="/economico/cambiar_nombre_empresa.php"  method="POST">
            <label for="nuevo_nombre"><input tabindex="1" type="text" name="nuevo_nombre" align="right" value="$empresa->nombre_empresa"></label>
            <label for="empresa"><input tabindex="1" type="hidden" name="id_empresa" value=" $empresa->id_empresa "></label>
            <input type="submit" id="cambiar_nombre" value="Cambiar">
        </form>
EOT;
echo "<table border='1' style='width=100%;'>";
echo "<td style='width: 300px' valign='top' align='center'>";
echo getString("company_inventory") . "<br>";
$sql = sql("SELECT * FROM inventario_empresas WHERE id_empresa = " . $empresa->id_empresa);
unset($sql['id_empresa']);


?>
<style>
    div.ui-dialog a.ui-dialog-titlebar-close {
        display: none;
    }

    .ui-dialog .ui-dialog-buttonpane {
        text-align: center;
    }

    .ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {
        float: none;
    }
</style>

<script>
    $(function() {
        $("#dialog").dialog({
            draggable: false,
            resizable: false,
            autoOpen: false,
            buttons: [{
                text: "Aceptar",
                click: function() {
                    $(this).dialog("close");
                    window.location.reload();
                }
            }]
        });
    });
</script>

<div id="dialog" title="<?php getString("use_item") ?>">

</div>


<?php

foreach ($sql as $item => $value) {
    if ($value > 0) {
        echo $item . ": " . $value . "<br>";
        //Para cuando esten los objetos usables en las empresas
        //echo $item . ": " . $value . " [<a href='#' class='click_item' id='" . item2id($item) . "'>".  getString('company_item_use')."</a>]<br>";
    }
}

?>
<script>
    $('.click_item').click(function() {


        $.post("../../economico/empresa_item.php?emp=<?php echo $empresa->id_empresa; ?>&item=" + $(this).attr("id"),
            function(data) {
                $("#dialog").append(data);
                $("#dialog").dialog('open');
            });

    });
</script>

<?php

echo <<<EOT
   <h3>Vender stock</h3>
<table id="v_stock"><tr><td>Cantidad</td><td>Precio</td></tr>
<form id="f_v_stock">
            <tr><td><label for="cantida"><input tabindex="1" size='10' type="text" name="cantidad"></label></td>
            <td><label for="precio"><input tabindex="1" size='10' type="text" name="precio"></label></td>
            <td><label for="empresa"><input tabindex="1" type="hidden" name="id_empresa" value=" $empresa->id_empresa "></label></td>
            <td><input type="button" id="vender_stock" value="Vender"></td></tr>
        </form>
        </table>
        
EOT;
?>
<script>
    $('#vender_stock').click(function() {
        $.post("/economico/vender_objetos.php", $("#f_v_stock").serialize(),
            function(data) {
                alert(data);
                $('#v_stock').hide();
            });
    });
</script>
<?php
//Mostrar que estamos vendiendo actualmente

echo "<h3>" .  getString("sales") . "</h3>";
$ventas = sql2("SELECT id_pais, cantidad, precio, id_oferta FROM mercado_objetos WHERE id_empresa='" . $id_empresa . "'");

echo "<table align='center' border='0'><tr align='center'><td>Pais</td><td>Cantidad</td><td>Precio</td><td>Cancelar</td></tr>";

foreach ($ventas as $venta) {
    echo "<tr align='center'><td>" . sql("SELECT name FROM country WHERE idcountry='" . $venta['id_pais'] . "'") . "</td><td>" . $venta['cantidad'] . "</td><td>" . $venta['precio'] . "</td><td><a href='/economico/quitar_venta.php?id_oferta=" . $venta['id_oferta'] . "'><img src='/images/cancel.png'/></a></td></tr>";
}

echo "</table>";


// Mostrar trabajadores
$empleados = array();
$work = sql2("SELECT id_usuario, nick, salario FROM usuarios WHERE id_empresa = " . $id_empresa);

echo "<br/><h3>Empleados</h3><table><tr><td>Nick</td><td>Salario</td></tr>";

foreach ($work as $worker) {
    //Se guardan los nicks de los trabajadores en un array externo
    //$empleados[] = $worker['id_usuario'];
    $empleados[$worker['id_usuario']] = $worker['nick'];

    echo "<tr><td>" . $worker['nick'] . '</td><td>' . $worker['salario'] . '</td><td>[<a href="/economico/despedir.php?id_worker=' . $worker['id_usuario'] . '">Despedir</a>]</td>
<td>
<form action="/economico/cambiar_salario.php"  method="POST">
            <label for="salario"><input tabindex="1" type="text" size="5" align="right" value="' . $worker['salario'] . '" name="salario"></label>
            <label for="worker"><input tabindex="1" type="hidden" name="worker" value="' . $worker['id_usuario'] . '"></label>
            
            <input type="submit" value="' . getString('button_change_salary') . '">
        </form>
</td>        
</tr>';
}
echo "</table>";

echo "<h2>" . getString('Poner_ofertas_trabajo') . "</h2>";
?>
<div id="ofertas_trabajo">
    <form action="/economico/poner_oferta.php" method="POST">
        <label for="salario2">Salario:<input id="salario2" tabindex="1" type="text" name="salario"></label><br>
        <label for="cantidad2">Cantidad:<input id="cantidad2" tabindex="2" type="text" name="cantidad"></label><br>
        <input type="hidden" name="id_empresa" value="<?php echo $empresa->id_empresa; ?>">
        <input type="hidden" name="id_pais" value="<?php echo $empresa->pais; ?>">
        <input type="submit">
    </form>
</div>
<!--form de ofertas de trabajo-->


</td>
<td style='width: 300px;' valign='top' align="center">


    <h3>Puestos ofertados</h3>
    <table border="0">
        <tr>
            <td><?php echo getString('salary'); ?></td>
            <td><?php echo getString('cantidad'); ?></td>
        </tr>
        <?php
        $cantidad = sql("SELECT COUNT(id_empresa) FROM mercado_trabajo WHERE id_empresa ='" . $_GET['id_empresa'] . "'");

        $sql = sql("SELECT id_oferta, salario, cantidad FROM mercado_trabajo WHERE id_empresa = '" . $_GET['id_empresa'] . "' ORDER BY salario DESC");
        if ($cantidad > 1) {
            foreach ($sql as $oferta) {
                echo "<tr><td>" . $oferta['salario'] . "</td><td>" . $oferta['cantidad'] . '</td><td>[<a href="/economico/quitar_oferta.php?id_oferta=' . $oferta['id_oferta'] . '">Quitar</a>]</td></tr>';
            }
        } elseif ($cantidad == 0)
            echo "<p>" . getString('no_job_offers') . "</p>";
        elseif ($cantidad == 1)
            echo "<tr><td>" . $sql['salario'] . "</td><td>" . $sql['cantidad'] . '</td><td>[<a href="/economico/quitar_oferta.php?id_oferta=' . $sql['id_oferta'] . '">Quitar</a>]</td></tr>';
        ?>
    </table>

    <!--    <h3>Historial produccion</h3>
    <table width="75%" border="1" align="center" style="text-align:center;" >

      <tr style="font-size:24px; background-color:#09C; color:#930;">
        <td>Empleado</td>
        <td><?php echo ($dia - 3); ?></td>
        <td><?php echo ($dia - 2); ?></td>
        <td><?php echo ($dia - 1); ?></td>
        <td><?php echo ($dia); ?></td>
      </tr>-->
    <?php
    //      foreach ($empleados as $empleado => $e_nick) {
    //          echo "<tr>";
    //          echo "<td>$e_nick</td>";
    //          
    //          for($d=$dia-3;$d<=$dia;$d++)
    //          {
    //              $prod = sql("SELECT producido FROM log_produccion WHERE id_usuario='$empleado' AND id_empresa='$id_empresa' AND dia='$d'");
    //              if($prod==false)
    //                  echo "<td><img src='/images/cancel.png'/></td>";
    //              else
    //                   echo "<td>$prod</td>";
    //          }
    //          echo "</tr>";
    //      }
    ?>
    <!--    </table>-->

    <h2><?php echo getString("economy"); ?></h2>
    <table border="0">
        <tr>
            <td><?php echo getString("salary"); ?></td>
            <td><?php echo getString("cantidad"); ?></td>
        </tr>
        <?php
        $sql = sql("SELECT * FROM empresas WHERE id_empresa = '$empresa->id_empresa'");
        foreach ($moneda_local as $id => $nombre) {

            if ($sql[$nombre] == 0) {
                continue;
            }

            echo "
        <tr>
            <td>$nombre</td><td>$sql[$nombre]</td>
        </tr>";
        }
        ?>
    </table>

    <h3><?php echo getString("company_money"); ?></h3>
    <form id="dineros" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <label for="cantidad"><?php echo getString("cantidad"); ?></label>
        <input type="text" name="cantidad" id="cantidad" maxlength="6" width="50%" /><br>
        <label for="moneda"><?php echo getString("coin"); ?></label>
        <select id="moneda" name="moneda">
            <?php
            $n = 0;
            foreach ($moneda_local as $moneda) {
                echo "<option value='" . $n . "'>" . $moneda . "</option>";
                $n++;
            }




            // for ($n = 1; $n < mysqli_num_fields($sql); $n++) {
            //     $mon = mysqli_fetch_column($sql, $n);
            // }
            ?>
        </select></br>
        <input type="submit" name="metodo" id="retirar" value="<?php echo getString("retirar"); ?>" />
        <input type="submit" name="metodo" id="ingresar" value="<?php echo getString("ingresar"); ?>" />
    </form>
    <!--
<script>
$('#retirar').click(function() {
$.post("dineros_e.php", $("#dineros").serialize()+"&"+"id:<?php ?>",
function(data){
                alert(data);
                window.location.reload();
              } );
});   

$('#ingresar').click(function() {
$.post("dineros_e.php", $("#viaje").serialize(),
function(data){
                alert(data);
                window.location.reload();
              } );
});  
</script>
-->
    <?php
    if (isset($_POST['metodo'])) {
        if (!isset($_POST['cantidad']) || $_POST['cantidad'] == "" || $_POST['cantidad'] <= 0)
            echo $txt['no_cantidad'];
        else {
            $cantidad = $_POST['cantidad'];
            $moneda = $_POST['moneda'];
            $nombre_moneda = $moneda_local[$moneda];
            if ($_POST['metodo'] == "Ingresar") {
                if ($cantidad <= sql("SELECT $nombre_moneda FROM money WHERE id_usuario='" . $_SESSION['id_usuario'] . "'")) {
                    //Si el usuario dispone del suficiente dinero, se restara de su monedero y se ingresara en la empresa
                    sql("UPDATE money SET $nombre_moneda = $nombre_moneda-$cantidad WHERE id_usuario='" . $_SESSION['id_usuario'] . "'");
                    sql("UPDATE empresas SET $nombre_moneda = $nombre_moneda+$cantidad WHERE id_empresa=$empresa->id_empresa");
                    echo getString('operacion_ok');
                    echo "<script type='text/javascript'>setTimeout('window.location=\"" . $_SERVER['REQUEST_URI'] . "\"',1000);</script>";
                } else
                    echo "<p style='color:red;'>" . $txt['me_falta_dinero'] . "</p>";
            } elseif ($_POST['metodo'] == "Retirar") {
                if ($cantidad <= sql("SELECT $nombre_moneda FROM empresas WHERE id_empresa='$empresa->id_empresa'")) {
                    //Si el usuario dispone del suficiente dinero, se restara de su monedero y se ingresara en la empresa
                    sql("UPDATE money SET $nombre_moneda = $nombre_moneda+$cantidad WHERE id_usuario='" . $_SESSION['id_usuario'] . "'");
                    sql("UPDATE empresas SET $nombre_moneda = $nombre_moneda-$cantidad WHERE id_empresa=$empresa->id_empresa");
                    echo $txt['operacion_ok'];
                    echo "<script type='text/javascript'>setTimeout('window.location=\"" . $_SERVER['REQUEST_URI'] . "\"',1000);</script>";
                } else
                    echo "<p style='color:red;'>" . $getString('me_falta_dinero') . "</p>";
            }
        }
    }
    ?>


    <button id="vender_empresa"><?php echo getString("vender_empresa"); ?></button>

    <div id="vender_empresa2" style="display: none">
        <form action="../../economico/vender_empresa.php" method="POST">
            <?php echo getString("precio_empresa") ?>:<input type="text" name="precio" value="<?php echo $empresa->precio_empresa; ?>" style="text-align:right;" />
            <input type="hidden" name="id" value="<?php echo $empresa->id_empresa; ?>">
            <input type="submit" value="Vender" />
        </form>
    </div>


    <script>
        $("#vender_empresa").click(function() {
            $("#vender_empresa2").show("slow");
        });
    </script>


    <hr noshade>
    <h3 style="background-color:#396; text-align:center;">Historial de produccion</h3>

    <table width="75%" border="1" align="center" style="text-align:center;">

        <tr style="font-size:24px; background-color:#09C; color:#930;">
            <td>Empleado</td>
            <td><?php echo ($dia - 3); ?></td>
            <td><?php echo ($dia - 2); ?></td>
            <td><?php echo ($dia - 1); ?></td>
            <td><?php echo ($dia); ?></td>
        </tr>

        <?php



        $sql = mysqli_query($link, "SELECT u.id_usuario, u.nick
							FROM usuarios u
							 WHERE u.id_empresa='$empresa->id_empresa'");
        while ($listado = mysqli_fetch_array($sql)) {
            echo "<tr>";
            $trabajador = $listado['nick'];
            $id_trabajador = $listado['id_usuario'];
            echo "<td>$trabajador</td>";

            $result = mysqli_query($link, "SELECT l.producido
							FROM log_produccion l
							 WHERE l.id_usuario='$id_trabajador'  AND id_empresa='$empresa->id_empresa' AND l.dia=$dia-3");
            $array = mysqli_fetch_array($result);

            if ($array == false)
                echo ("<td><img src='/images/mini_error.gif' /></td>");
            else {
                $producido = $array['producido'];
                echo "<td>$producido</td>";
            }

            $result = mysqli_query($link, "SELECT l.producido
							FROM log_produccion l
							 WHERE l.id_usuario='$id_trabajador' AND id_empresa='$empresa->id_empresa' AND l.dia=$dia-2");
            $array = mysqli_fetch_array($result);

            if ($array == false)
                echo ("<td><img src='/images/mini_error.gif' /></td>");
            else {
                $producido = $array['producido'];
                echo "<td>$producido</td>";
            }


            $result = mysqli_query($link, "SELECT l.producido
							FROM log_produccion l
							 WHERE l.id_usuario='$id_trabajador' AND id_empresa='$empresa->id_empresa' AND l.dia=$dia-1");
            $array = mysqli_fetch_array($result);
            if ($array == false)
                echo ("<td><img src='/images/mini_error.gif' /></td>");
            else {
                $producido = $array['producido'];
                echo "<td>$producido</td>";
            }

            $result = mysqli_query($link, "SELECT l.producido
							FROM log_produccion l
							 WHERE l.id_usuario='$id_trabajador' AND id_empresa='$empresa->id_empresa' AND l.dia=$dia");
            $array = mysqli_fetch_array($result);
            if ($array == false)
                echo ("<td><img src='/images/mini_error.gif' /></td>");
            else {
                $producido = $array['producido'];
                echo "<td>$producido</td>";
            }

            echo "</tr>";
        }


        ?>

    </table>

    <hr noshade>
    <h3 style="background-color:#396; text-align:center;">Historial de ventas</h3>
    <?php
    $sql = mysqli_query($link, "SELECT * FROM log_ventas WHERE id_empresa='$empresa->id_empresa' ORDER BY dia DESC LIMIT 10");
    while ($listado = mysqli_fetch_array($sql)) {
        $cantidad = $listado['cantidad'];
        $dia_v = $listado['dia'];
        echo ("<hr><p><b>Cantidad:</b> $cantidad - <b>Dia: </b>$dia_v</p>");
    }

    ?>

</td>
</table>