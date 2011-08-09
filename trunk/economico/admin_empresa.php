<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/economico/moneda_local.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Sustituir por error 404


$id_empresa = $_GET['id_empresa'];

//var_dump($empresa);

//El objeto empresa ya esta declarado ya que este script se llama con include
$empresa = new empresa($id_empresa);

echo "<br>Empresa: " . $empresa->nombre_empresa . " (" . $empresa->get_tipo() . ")";

echo <<<EOT
<form id="cambiar_nombre_empresa" action="/economico/cambiar_nombre_empresa.php"  method="POST">
            <label for="nuevo_nombre"><input tabindex="1" type="text" name="nuevo_nombre" align="right" value="$empresa->nombre_empresa"></label>
            <label for="empresa"><input tabindex="1" type="hidden" name="id_empresa" value=" $empresa->id_empresa "></label>
            <input type="button" id="cambiar_nombre" value="Cambiar">
        </form>
EOT;

echo "<br>Stock: " .$empresa->stock;
if (type_company($empresa->tipo) != 0) { echo " Raw: " . $empresa->raw; }

//Vender stock
if ($empresa->stock != 0){
    
    echo <<<EOT
   <h3>Vender stock</h3>
<table id="v_stock"><tr><td>Cantidad</td><td>Precio</td></tr>
<form id="f_v_stock">
            <tr><td><label for="cantida"><input tabindex="1" type="text" name="cantidad"></label></td>
            <td><label for="precio"><input tabindex="1" type="text" name="precio"></label></td>
            <td><label for="empresa"><input tabindex="1" type="hidden" name="id_empresa" value=" $empresa->id_empresa "></label></td>
            <td><input type="button" id="vender_stock" value="Vender"></td></tr>
        </form>
        </table>
        
EOT;
    ?>
        <script>
    $('#vender_stock').click(function() {
    $.post("/economico/vender_objetos.php", $("#f_v_stock").serialize(),
    function(data){
                    alert(data);
                    $('#v_stock').hide();
                  } );
    });   
    </script>
<?
    
}

//Mostrar que estamos vendiendo actualmente

echo "<h3>Ventas</h3>";
$ventas = sql2("SELECT id_pais, cantidad, precio, id_oferta FROM mercado_objetos WHERE id_empresa='".$id_empresa."'");

echo "<table align='center' border='0'><tr align='center'><td>Pais</td><td>Cantidad</td><td>Precio</td><td>Cancelar</td></tr>";

foreach ($ventas as $venta) {
   echo "<tr align='center'><td>".sql("SELECT name FROM country WHERE idcountry='".$venta['id_pais']."'")."</td><td>".$venta['cantidad']."</td><td>".$venta['precio']."</td><td><a href='/economico/quitar_venta.php?id_oferta=".$venta['id_oferta']."'><img src='/images/cancel.png'/></a></td></tr>";
}

echo "</table>";


// Mostrar trabajadores
$empleados = array();
$work = sql2("SELECT id_usuario, nick, salario FROM usuarios WHERE id_empresa = " . $id_empresa);

echo "<br/><h3>Empleados</h3><table><tr><td>Nick</td><td>Salario</td></tr>";

foreach ($work as $worker) 
    {
    //Se guardan los nicks de los trabajadores en un array externo
    //$empleados[] = $worker['id_usuario'];
    $empleados[$worker['id_usuario']] = $worker['nick'];
    
    echo "<tr><td>" . $worker['nick'] . '</td><td>'. $worker['salario'] .'</td><td>[<a href="/economico/despedir.php?id_worker='.$worker['id_usuario'].'">Despedir</a>]</td>
<td>
<form action="/economico/cambiar_salario.php"  method="POST">
            <label for="salario"><input tabindex="1" type="text" size="5" align="right" value="'.$worker['salario'].'" name="salario"></label>
            <label for="cantidad"><input tabindex="1" type="hidden" name="worker" value="'. $worker['id_usuario'] .'"></label>
            
            <input type="submit" value="Cambia salario">
        </form>
</td>        
</tr>';
}
echo "</table>";

echo "<h2>".$txt['Poner_ofertas_trabajo']."</h2>" ;
?>
    <div id="ofertas_trabajo">
        <form action="/economico/poner_oferta.php"  method="POST">
            <label for="salario2">Salario:<input id="salario2" tabindex="1" type="text" name="salario"></label><br>
            <label for="cantidad2">Cantidad:<input id="cantidad2" tabindex="2" type="text" name="cantidad"></label><br>
            <input type="hidden" name="id_empresa" value="<?php echo $empresa->id_empresa; ?>">
            <input type="hidden" name="id_pais" value="<?php echo $empresa->pais; ?>">
            <input type="submit">
        </form>
    </div><!--form de ofertas de trabajo-->
    <hr>
    <h3>Puestos ofertados</h3>
    <table border="0">
        <tr>
            <td>Salario</td><td>Cantidad</td>
        </tr>
    <?
    $cantidad = sql("SELECT COUNT(id_empresa) FROM mercado_trabajo WHERE id_empresa ='".$_GET['id_empresa']."'");
    
    $sql = sql("SELECT id_oferta, salario, cantidad FROM mercado_trabajo WHERE id_empresa = '".$_GET['id_empresa']."' ORDER BY salario DESC");
    if($cantidad > 1)
    {
    foreach($sql as $oferta){
        echo "<tr><td>". $oferta['salario'] ."</td><td>". $oferta['cantidad'] .'</td><td>[<a href="/economico/quitar_oferta.php?id_oferta='.$oferta['id_oferta'].'">Quitar</a>]</td></tr>';
        
        }
    }
    elseif($cantidad==0)
        echo "<p>".$txt['no_ofertas_trabajo']."</p>";
    elseif($cantidad==1)
        echo "<tr><td>". $sql['salario'] ."</td><td>". $sql['cantidad'] .'</td><td>[<a href="/economico/quitar_oferta.php?id_oferta='.$sql['id_oferta'].'">Quitar</a>]</td></tr>';
        
    
    ?>
    </table>
    
    <h3>Historial produccion</h3>
    <table width="75%" border="1" align="center" style="text-align:center;" >

      <tr style="font-size:24px; background-color:#09C; color:#930;">
        <td>Empleado</td>
        <td><? echo($dia-3); ?></td>
        <td><? echo($dia-2); ?></td>
        <td><? echo($dia-1); ?></td>
        <td><? echo($dia); ?></td>
      </tr>
  <?
      foreach ($empleados as $empleado => $e_nick) {
          echo "<tr>";
          echo "<td>$e_nick</td>";
          
          for($d=$dia-3;$d<=$dia;$d++)
          {
              $prod = sql("SELECT producido FROM log_produccion WHERE id_usuario='$empleado' AND id_empresa='$id_empresa' AND dia='$d'");
              if($prod==false)
                  echo "<td><img src='/images/cancel.png'/></td>";
              else
                   echo "<td>$prod</td>";
          }
          echo "</tr>";
      }
  ?>
    </table>
    
    <h2>Economia</h2>
    <table border="0">
        <tr>
            <td>Moneda</td><td>Cantidad</td>
        </tr>
       <?
       $sql = sql("SELECT * FROM empresas WHERE id_empresa = '$empresa->id_empresa'");
       foreach ($moneda_local as $id => $nombre) {
           
       if ($sql[$nombre] == 0 ) {continue; }    
           
       echo"
        <tr>
            <td>$nombre</td><td>$sql[$nombre]</td>
        </tr>";  
       }

       ?>
    </table>
    
    <h3>Dineros</h3>
    <form id="dineros" method="POST" action="<? echo $_SERVER['REQUEST_URI']; ?>">
        <label for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" id="cantidad" maxlength="6" width="50%"/>
        <label for="moneda">Moneda:</label>
         <select id="moneda" name="moneda">
          <? 
          
          $sql = mysql_query("SELECT * FROM money");
          for($n=1;$n<mysql_num_fields($sql);$n++) {
              
              $mon = mysql_field_name($sql,$n);
              echo"<option value='$n'> $mon </option>";
              
          }
          
          
          ?>
         </select></br>
        <input type="submit" name="metodo" id="retirar" value="Retirar"/>
        <input type="submit" name="metodo" id="ingresar" value="Ingresar"/>
    </form>
    <!--
    <script>
    $('#retirar').click(function() {
    $.post("dineros_e.php", $("#dineros").serialize()+"&"+"id:<?  ?>",
    function(data){
                    alert(data);
                    window.location.reload();
                  } );
    });   
    
    $('#ingresar').click(function() {
    $.post("dineros_e.php", $("#viaje").serialize(),
    function(data){
                    alert(data);
                    window.location.reload();
                  } );
    });  
    </script>
    -->
    <?
    if(isset($_POST['metodo']))
    {
        if(!isset($_POST['cantidad'])||$_POST['cantidad']==""||$_POST['cantidad']<=0)
            echo $txt['no_cantidad'];
        else
        {
            $cantidad = $_POST['cantidad'];    
            $moneda = $_POST['moneda'];
            $nombre_moneda = $moneda_local[$moneda-1];
            if($_POST['metodo']=="Ingresar")
            {
                if($cantidad<=sql("SELECT $nombre_moneda FROM money WHERE id_usuario='".$_SESSION['id_usuario']."'"))
                {
                    //Si el usuario dispone del suficiente dinero, se restara de su monedero y se ingresara en la empresa
                    sql("UPDATE money SET $nombre_moneda = $nombre_moneda-$cantidad WHERE id_usuario='".$_SESSION['id_usuario']."'");
                    sql("UPDATE empresas SET $nombre_moneda = $nombre_moneda+$cantidad WHERE id_empresa=$empresa->id_empresa");
                    echo $txt['operacion_ok'];
                    echo "<script type='text/javascript'>setTimeout('window.location=\"".$_SERVER['REQUEST_URI']."\"',1000);</script>";
                }
                else
                    echo "<p style='color:red;'>".$txt['me_falta_dinero']."</p>";
            }
            elseif($_POST['metodo']=="Retirar")
            {
              if($cantidad<=sql("SELECT $nombre_moneda FROM empresas WHERE id_empresa='$empresa->id_empresa'"))
                {
                    //Si el usuario dispone del suficiente dinero, se restara de su monedero y se ingresara en la empresa
                    sql("UPDATE money SET $nombre_moneda = $nombre_moneda+$cantidad WHERE id_usuario='".$_SESSION['id_usuario']."'");
                    sql("UPDATE empresas SET $nombre_moneda = $nombre_moneda-$cantidad WHERE id_empresa=$empresa->id_empresa");
                    echo $txt['operacion_ok'];
                    echo "<script type='text/javascript'>setTimeout('window.location=\"".$_SERVER['REQUEST_URI']."\"',1000);</script>";
                }
                else
                    echo "<p style='color:red;'>".$txt['me_falta_dinero']."</p>";
            }
        }
    }
    
    ?>