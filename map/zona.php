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
<div class="pagina">
    <center><h1>Mapa</h1></center>
<div class="menu_izq">
  <p>Menu</p>
  <p>Precio:</p>
  <p>100$</p>
  <p>Propietario:</p>
  <p>yatan</p>
</div>
<div class="mapa">
    <?
    
    $mapa = array(
        0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,
        0,1,0,0,0,0,0,
        0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,
        0,0,0,1,0,0,0,
        0,0,0,0,0,0,0
       );
    $posicion = 0;
    
for($i=1;$i<=7;$i++)
{
    for($j=1;$j<=7;$j++)
    {
        if($mapa[$posicion]==1)
            echo "<img src='/images/map/house.png'/>";
        else
            echo "<img src='/images/map/hierba.png'/>";
        $posicion++;
    }
    echo "<br/>";
}

?>
</div>
</div>


