<?php

echo sql("SELECT Gold FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'")." ". getString('Gold') ." <br/>";
$sql = sql("SELECT * FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'");

arsort($sql);
foreach ($sql as $moneda => $valor) {
    if($moneda!="id_usuario" && $moneda!="Gold" && $valor>0)
    echo $valor." ".$moneda."<br/>";
}
