<?
include("../index_head.php");
?>
<style type="text/css">
.menu_izq {
	float: left;
}
.pagina {
	height: 400px;
	width: 600px;	
}
.mapa {
	float: left;
        margin-left: 50px;
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
<div class="pagina">
    <center><h1>Mapa Zona 1</h1></center>
<div class="menu_izq">
  <p>Menu</p>
  <p>Precio:</p>
  <p>100$</p>
  <p>Propietario:</p>
  <p id="propietario"></p>
</div>
<div class="mapa">
    <?
   include "../include/funciones.php";
    
for($y=1;$y<=7;$y++)
{
    for($x=1;$x<=7;$x++)
    {
        $tipo = sql("SELECT tipo FROM map_zonas WHERE x='$x' AND y='$y' AND id_zona='1'");
        
        if($tipo==1)
            echo "<img class='elemento1' propietario='fraasas' src='/images/map/house.png'/>";
        elseif($tipo==2)
            echo "<img class='elemento1' propietario='erwewrer' src='/images/map/car.png'/>";
        else
            echo "<img src='/images/map/hierba.png'/>";
        
    }
    echo "<br/>";
}

?>
</div>
</div>


