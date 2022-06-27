<?php

$pos = 1;

if (isset($_GET['nick'])) {
    $nick = $_GET['nick'];
    echo "<h1>Usuarios</h1>";
} else {
    $nick = "";
    echo "<h1>Top 10</h1>";
}

if (isset($_GET['pag']))
    $pagina = $_GET['pag'];
else
    $pagina = 0;

$pag_resultados = $pagina * 10;
$resultado = sql2("SELECT * FROM usuarios WHERE nick LIKE '%$nick%' ORDER BY exp DESC LIMIT $pag_resultados, 10");
?>

<table width="75%" border="0" align="center" style="text-align:center;">
    <tr style="font-size:20px; color:#930;">
        <!--<td>Pos.<hr noshade></td>-->
        <td>Avatar
            <hr noshade>
        </td>
        <td>Nick
            <hr noshade>
        </td>
        <td>Nivel
            <hr noshade>
        </td>
        <td>EXP
            <hr noshade>
        </td>
    </tr>

    <?php

    foreach ($resultado as $jugador) {

        echo ("<tr>");
        //echo "<td>$pos</td>";
        echo ("
<td><a href='/es/perfil/" . $jugador['id_usuario'] . "'><img src='" . $jugador['avatar'] . "' style='max-height: 64px; max-width: 64px; overflow: hidden;' /></a></td>
<td><a href='/es/perfil/" . $jugador['id_usuario'] . "'>" . $jugador['nick'] . "</a></td>
<td>" . $jugador['level'] . "</td>
<td>" . $jugador['exp'] . "</td>
</tr>
<tr>
<td colspan='5'><hr /></td>
</tr>
  ");
        $pos++;
    }

    ?>

</table>



<?php

if (isset($_GET['nick'])) {
    $max_paginas = sql("SELECT COUNT(*) FROM usuarios WHERE nick LIKE '%$nick%'") / 10 + 1;
    for ($i = 1; $i <= $max_paginas; $i++) {
        $pag = $i - 1;
        echo "<a href='/" . $_GET['lang'] . "/buscador/" . $nick . "/" . $pag . "'>$i </a>";
    }
}

?>