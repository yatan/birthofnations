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
for($i=1;$i<=7;$i++)
{
    for($j=1;$j<=7;$j++)
    {
        if($i==3 && $j==5)
            echo "<img src='/images/map/house.png'/>";
        else
            echo "<img src='/images/map/hierba.png'/>";
    }
    echo "<br/>";
}

?>
</div>
</div>


