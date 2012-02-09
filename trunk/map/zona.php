<?
//include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
//include_once($_SERVER['DOCUMENT_ROOT'] . "/index_head.php");
$id_zona = $_GET['id_zona'];
?>
<style type="text/css">
.menu_izq {
	float: left;
        width: 80px;
        text-align: center;
        margin-left: 20px;
}

.mapa {
        margin-left: 100px;
        width: 700px;
}
</style>
</head>

<body>
    
<script type="text/javascript">

$(document).ready(function(){

var quien;
		
   $(".elemento1").mouseenter(function(e){
    quien = $(this).attr("propietario");
	 
    $('#propietario').text(quien);
      
   });
   
  $(".elemento1").mouseleave(function(e){
  $('#propietario').text("");
  });
   
  
})	
	
</script>

    <center><h1>Mapa Zona <? echo sql("SELECT name FROM region WHERE idregion='$id_zona'"); ?></h1></center>
<div class="menu_izq">
  <p>Menu</p>
  <p>Precio:</p>
  <p>100$</p>
  <p>Propietario:</p>
  <p id="propietario"></p>
</div>
<div class="mapa">
    <?
  
$cuadros = sql("SELECT * FROM map_zonas WHERE id_zona='$id_zona'");
$cantidad = sql("SELECT COUNT(*) FROM map_zonas WHERE id_zona='$id_zona'");


for($y=0;$y<10;$y++)
{
    for($x=0;$x<10;$x++)
    {
        //$cuadro = sql("SELECT tipo, propietario FROM map_zonas WHERE x='$x' AND y='$y' AND id_zona='1'");
      $algo = false;  
       for($n=0;$n<$cantidad;$n++)     
       {
        if( $x == $cuadros[$n]['x'] && $y == $cuadros[$n]['y'] )
        {
        $tipo = $cuadros[$n]['tipo'];
        $propietario = $cuadros[$n]['propietario'];
        $n++;
        
        if($tipo==1)
            echo "<img class='elemento1' propietario='".id2nick($propietario)."' src='/images/map/house.png'/>";
        elseif($tipo==2)
            echo "<img class='elemento1' propietario='".id2nick($propietario)."' src='/images/map/car.png'/>";
        elseif($tipo==3)
            echo "<a href='/es/ayuntamiento'><img class='elemento1' propietario='Pais' src='/images/map/ayuntamiento.jpg'/></a>";        
        elseif($tipo==4)
            echo "<img class='elemento1' propietario='En venta' src='/images/map/venta.png'/>";         
        
        $algo = true;
        }
       }
        if($algo==false)
            echo "<img src='/images/map/hierba.png'/>";
       
        
        
   }
   
    echo "<br/>";
}

?>
</div>

<br/>