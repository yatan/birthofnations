<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");

if (!isset($_GET['id_pais'])){
    $id_pais = $objeto_usuario->id_nacionalidad;
}else{
    $id_pais = $_GET['id_pais'];
}   

$pais = new pais($id_pais);

echo "<h3>Tecnologias</h3>";

foreach($pais->list_tech() as $id=>$lvl){
    echo getString("tech_".$id) . ": " . $lvl . " ";
    if(puedo_tech_upgrade($objeto_usuario->id_usuario,$id) == true){echo "<a href='../../politico/tecnologia.php?tech=".$id."&pais=".$id_pais."'>".getString('comprar')."</a>";}
    echo"<br>";
}
        
?>