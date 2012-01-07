<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/objeto_pais.php");


//Temporal hasta que se ponga en el hta
$_GET['id_pais']=2;

if (!isset($_GET['id_pais']))
    die("Error: id no valido"); //Substituir por error 404

$country = $_GET['id_pais'];
$country = new pais($country);


$cargos = $country->list_cargos();//Sacamos la lista de cargos del pais

?><h2> <? getString('leaders');?> </h2>
<table><tr><th><?getString('position');?></th><th><?getString('nick');?></th></tr>
<?
foreach($cargos as $cargo){//Para cada cargo
    
    $name = sql("SELECT nombre FROM country_leaders WHERE id_cargo = " . $cargo['id_cargo']); //Sacamos el nombre de la BD
    
    $leaders = list_leaders($cargo['id_cargo']); //Y la lista de gente con ese cargo
    
    foreach($leaders as $leader){
    
    $nick = id2nick($leader);
echo <<<EOT

<tr><td>$name</td><td> $nick </td></tr>   

EOT;
        
    }
}//Cuando acabamos de escribir los rangos

echo "</table>";


?><h2> <?php getString('available_laws');?> </h2>
<table><tr><th>Posicion</th><th>Ley</th><th>Detalles</th></tr>
    
    
<?

foreach($cargos as $cargo){
    $laws = list_laws($cargo['id_cargo']);//Sacamos los datos de las leyes que puede lanzar
    $cargo_name = $cargo['nombre'];
    
    foreach($laws as $law){
        
        $law_name = getString('law_'.$law[0]);
        
echo <<<EOT
   <tr><td> $cargo_name </td><td>$law_name</td><td>TBD</td></tr>     
   
EOT;
    }
}

echo "</table>";

?>
