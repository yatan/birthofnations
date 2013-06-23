<?
//include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
//include_once($_SERVER['DOCUMENT_ROOT'] . "/index_head.php");
if (!isset($_GET['id_zona']))
    die("But duuuude...");
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
            var cuanto;
		
            $(".elemento1").mouseenter(function(e){
                quien = $(this).attr("propietario");
                cuanto = $(this).attr("precio");
                $('#propietario').text(quien);
                $('#precio').text(cuanto);
      
            });
   
            $(".elemento1").mouseleave(function(e){
                $('#propietario').text("");
                $('#precio').text("-");
            });
   
  
        })	
	
    </script>
    <?
    $zona = sql("SELECT name,id_region FROM zona_data WHERE id_zona='$id_zona'");
    ?>
<center><h1><? echo $zona['name'] . " - " . region2name($zona['id_region']) ?></h1></center>
<div class="menu_izq">
    <p>Menu</p>
    <p>Precio:</p>
    <p id="precio"></p>
    <p>Propietario:</p>
    <p id="propietario"></p>
</div>

<div class="mapa">
    <?
    $cuadros = sql("SELECT * FROM map_zonas WHERE id_zona='$id_zona'");
    $cantidad = sql("SELECT COUNT(*) FROM map_zonas WHERE id_zona='$id_zona'");


    for ($y = 0; $y < 11; $y++) {
        for ($x = 0; $x < 11; $x++) {
            //$cuadro = sql("SELECT tipo, propietario FROM map_zonas WHERE x='$x' AND y='$y' AND id_zona='1'");
            for ($n = 0; $n < $cantidad; $n++) {
                if ($x == $cuadros[$n]['x'] && $y == $cuadros[$n]['y']) {
                    $tipo = $cuadros[$n]['tipo'];
                    $id_prop = $cuadros[$n]['id_prop'];
                    $tipo_prop = $cuadros[$n]['tipo_prop'];
                    $en_venta = $cuadros[$n]['en_venta'];
                    $precio = $cuadros[$n]['precio'];
                    $n++;

                    //Sacar el nombre del propietario
                    if ($tipo_prop == 1) {
                        $nombre_prop = country_name($id_prop);
                    } elseif ($tipo_prop == 2) {
                        $nombre_prop = id2nick($id_prop);
                    }

                    if ($en_venta == 0) {
                        if ($tipo == 0)
                            echo "<a href='/es/ayuntamiento'><img class='elemento1' propietario='" . $nombre_prop . "' src='/images/map/ayuntamiento.jpg'/></a>";
                        elseif ($tipo == 1)
                            echo "<img class='elemento1' src='/images/map/hierba.png' propietario='" . $nombre_prop . "'/>";
                        elseif ($tipo == 2)
                            echo "<img class='elemento1' propietario='" . $nombre_prop . "' src='/images/map/house.png'/>";
                        elseif ($tipo == 3)
                            echo "<img class='elemento1' propietario='" . $nombre_prop . "' src='/images/map/car.png'/>";
                    }elseif ($en_venta == 1) {
                        $url = "/map/buy_lot.php?x=$x&y=$y&zone=$id_zona";
                        echo "<a id='comprar' href='".$url."'><img class='elemento1' precio='".$precio."' propietario='" . $nombre_prop . "' src='/images/map/venta.png'/></a>";
                    }
                }
            }
        }


        echo "<br/>";
    }
    ?>
</div>

<br/>