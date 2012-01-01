<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo "<h2>Mi economia</h2>";

echo sql("SELECT Gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'"). getString('Gold') ." <br/>";
$sql = sql("SELECT * FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");

arsort($sql);
foreach ($sql as $moneda => $valor) {
    if($moneda!="id_usuario" && $moneda!="Gold" && $valor>0)
    echo $valor." ".$moneda."<br/>";
}

?>

