<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

if(isset($_GET['pais']))
    $pais = $_GET['pais'];
else
    $pais = 1;

if(isset($_GET['pag']))
    $pagina = $_GET['pag'];
else
    $pagina=0;

//$moneda = moneda_pais($pais);

?>

<link rel="stylesheet" type="text/css" href="/css/dd.css" />
<script type="text/javascript" src="/js/jquery.dd.js"></script>
<script type="text/javascript" src="/js/datepicker.js"></script>

<script type="text/javascript" >
    $(document).ready(function(e) {
        try {
            $("#pais").msDropDown();
        } catch(e) {
            alert(e.message);
        }
    });
    $(document).ready(function(e) {
        try {
            $("#region2").msDropDown();
        } catch(e) {
            alert(e.message);
        }
    });
  $(document).ready(function() {
    $("#datepicker").datepicker({
        minDate: '+1D',
        maxDate: '+2D',
        dateFormat: '@',
        onSelect: function() {
           //var fecha= new Date();
           //var hora=fecha.now().valueOf();
            alert('hora');

           //alert(hora+'--'+Math.round(document.getElementById('datepicker').value / 1000));
           // document.getElementById("hora_inicio1").value=Math.round(document.getElementById('datepicker').value / 1000);
        }
    });
  });
    function cambiar_pais(arg) {
            window.location = '/<? echo $_GET['lang']."/addwar/"; ?>'+arg;
    }
    function regioninput(arg){
        document.getElementById('region').value=document.getElementById('region2').value;
    }

document.getElementById('hora_inicio1').value=((document.getElementById('datepicker').value)/1000)+((document.getElementById('datepicker').value)/1000);
</script>
    <div style="background-color: darkred; height: 1000px;">
<div style="background-color: red;">
    <div style="width: 50%; float:left; text-align: center; background-color: darkorchid;  height: 60px;">
        <? getString('country'); ?><br><center>
        <? $sql = sql("SELECT idcountry, name, url_bandera FROM country");
        ?>
        <select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
        <?
                foreach ($sql as $pais1) {
                    if($pais1['idcountry']!=$objeto_usuario->id_nacionalidad){ //para no atacar una region de tu propio pais
                        if($pais1['idcountry']==$_GET['pais']){
                            $seleccionado = "selected='selected'";
                        }else{
                            $seleccionado = "";
                        }
                        echo "<option title='".$pais1['url_bandera']."' ".$seleccionado." value='".$pais1['idcountry']."'>".$pais1['name']."</option>";
                    }
                }
        ?>
        </select></center>
    </div>
    <div style="width: 50%; float:right; background-color: darkgoldenrod;  height: 60px;">
        <? getString('region'); ?><br>
        <?
        $sql = sql2("SELECT idregion, name FROM region WHERE idcountry=".$pais);
        $aux=0;
        echo "<select style='width:200px;' name='region2' id='region2' onchange='regioninput(this.value)' >";
                foreach ($sql as $region) {
                   echo "<option value='".$region['idregion']."'>".$region['name']."</option>";
                   if($aux==0){
                       $aux2=$region['idregion'];
                       $aux=2;
                    }
                }
        echo "</select>";
        ?>
    </div>
</div>
<div style="background-color: pink; color:black;">
    La fecha sera el dia elegido mas 24horas
</div>
<div style="background-color: green;">
    <div id="datepicker" style="background-color: blue; width: 50%; float:left; text-align: center;   height: 300px;"></div>
    <div  style="background-color: black; width: 50%; float:right;  height: 300px;">
        <form name="battle" id="battle" action="">
            pais_atacante<input type="text" id="pais_atacante" name="pais_atacante" value="<?echo $objeto_usuario->id_nacionalidad?>"><br>
            pais_defensor<input type="text" id="pais_defensor" name="pais_defensor" value="<?echo $pais?>"><br>
            region<input type="text" id="region" name="region" value="<?echo $aux2;?>"><br>
            tipo<input type="text" id="tipo" name="tipo" value="<?echo $objeto_usuario->id_nacionalidad?>"><br>
            hora_inicio<input type="text" id="hora_inicio" name="hora_inicio" value="<?echo (time()+(86400+86400)).' -- '.date('d/m/y',(time()+(86400+86400)));?>"><br>
            hora_inicio<input type="text" id="hora_inicio1" name="hora_inicio1" value=""><br>
        </form>
    </div>
</div>

<br>