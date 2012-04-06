<?php


include_once("include/funciones.php");
//Comprobacion del servidor mysql
if(mysql_online2()==false)
    die("Hay un fallo en los servidores. Intentalo mas tarde");
//Comprobacion si el juego esta en mantenimiento
if(sql("SELECT mantenimiento FROM settings")=="1" && !isset($_SESSION['is_admin']))
{
    include($_SERVER['DOCUMENT_ROOT']."/login/mantenimiento.php");
    die();    
}
elseif(isset($_SESSION['is_admin']) && $_SESSION['is_admin']!="1")
{
    include($_SERVER['DOCUMENT_ROOT']."/login/mantenimiento.php");
    die();    
}
if(!isset($_SESSION['id_usuario']))
{
    include("login/login.php");
    exit;
}
else
{

    
require("usuarios/objeto_usuario.php");
$objeto_usuario = new usuario($_SESSION['id_usuario']);

//Si existe el idioma normalmente en la url del tipo /es/ lo establece como
//variable que se carga al principio '''$idioma'''
if(isset($_GET['lang']))
    $idioma = $_GET['lang'];

//Se mira si es el primer login, por lo que no tendra ninguna ciudad asignada
if($objeto_usuario->id_region==null)
    header("Location: /login/primer_login.php"); //<-- Redireccion a la pagina del primer login

if($objeto_usuario->check_travel() ==true)
    if(!isset($_GET['mod']))
        header("Location: /es/viajando"); //<-- Redireccion a la pagina mientras se vuela (TEMPORAL)
    elseif($_GET['mod'] == 'entrenar' || $_GET['mod'] == 'empresa' ){
        header("Location: /es/viajando");
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<?php 
include("index_head.php"); 

?>
    
    <body> 
        <div class="blur">
            <div class="shadow">
                <div id="contenido">
                    <?php include("cabecera.php"); ?><br>
                    <div id="status">
                        <center>
                            <? include("status.php"); ?>
                        </center>
                    </div>
                    <div id="menu">
                        <? include("menu.php"); ?>  
                    </div><!--menu-->
                    <div id="cuerpo">
                        <center>
                        <?
                        
                        if(isset($_GET['mod']))
                        {    
                            switch($_GET['mod'])
                            {
                            case "crear_empresa":
                                include("economico/form_crear_empresa.php");
                                break;
                            case "empresa":
                                include("economico/empresa.php");
                                break;
                            case "articulo":
                                include("periodico/articulo.php");
                                break;  
                            case "perfil":
                                include("usuarios/perfil.php");
                                break;   
                            case "mercado_laboral":
                                include("economico/mercado_trabajo.php");
                                break;  
                            case "mercado_empresas":
                                include("economico/mercado_empresas.php");
                                break;  
                             case "empresas":
                                include("economico/empresas.php");
                                break;
                            case "trabajar":
                                include("economico/trabajar.php");
                                break;
                            case "mensajes":
                                include("usuarios/mensajes.php");
                                break;
                            case "alertas":
                                include("usuarios/alerts.php");
                                break;      
                            case "mercado":
                                include("economico/mercado_objetos.php");
                                break;      
                            case "info_pais":
                                include("politico/info_pais.php");
                                break;           
                            case "buscador":
                                include("usuarios/buscador.php");
                                break;         
                            case "info_region":
                                include("politico/info_region.php");
                                break; 
                            case "info_partido":
                                include("politico/info_partido.php");
                                break;   
                            case "tecnologia":
                                include("politico/tecnologia_pais.php");
                                break;   
                            case "lista_partidos":
                                include("politico/list_party.php");
                                break;                             
                            case "guerra":
                                include("militar/guerra.php");
                                break; 
                            case "entrenar":
                                include("militar/entrenar.php");
                                break;
                            case "nacionalidad":
                                include("usuarios/change_nacionalidad.php");
                                break;
                            case "viajando":
                                include("usuarios/viajando.php");
                                break;
                            case "laws":
                                include("politico/last_laws.php");
                                break;
                            case "addwar":
                                include("militar/aniadir_guerra.php");
                                break;
                            case "lista_guerras":
                                include("militar/lista_guerras.php");
                                break;                        
                            case "mercado_economico":
                                include("economico/mercado_economico.php");
                                break;                            
                            case "candidatos":
                                include("politico/lista_candidatos.php");
                                break;       
                            case "ayuntamiento":
                                include("map/ayuntamiento.php");
                                break;      
                            case "zona":
                                include("map/zona.php");
                                break;          
                            case "ciudadania":
                                include("usuarios/ciudadania.php");
                                break;                             
                            default :
                                die($_GET['mod']); //Default por si se pone algo incorrecto. Al futuro hay que cambiarlo
                            }
                        }
                        else
                        {
                            //Aqui va lo del centro de la pagina principal
                            ?>
                            <div id="columnas" style="padding: 10px; width: 58.4em; height: 25em;">
                                <div id="columna1" style="float: right; width: 41em; height: 25em;">
                                   <? include("columna1.php"); ?>
                                </div>

                                <div id="columna2" style="float: left; height: 25em; width: 17em;">
                                   <? include("columna2.php"); ?>
                                </div>
                            </div><!-- columnas -->
                                <div id="fila2" style="width: 59.6em; height: 14.5em;">
                                    <div id="periodicos_login" style="float: left; width: 29.5em; height: 14.5em;">
                                        <div class="ultimos_articulos" style="float: left; width:300px;">
                                        <h2><li><? echo getString('periodico_ultimos'); ?></li></h2>
                                            <? 
$nuevosarticulosw = mysql_query("SELECT * FROM articulos ORDER by fecha DESC LIMIT 5");
echo "<div style='text-align: left; margin-left: 5px;'>";
while($nuevosarticulos = mysql_fetch_array($nuevosarticulosw))  {
    $autor= id2nick($nuevosarticulos['id_autor']);
    $voto_articulo = sql("SELECT ((SELECT COUNT(*) FROM articulos_votos WHERE id_articulo = '".$nuevosarticulos['id_articulo']."' AND tipo=1) - (SELECT COUNT(*) FROM articulos_votos WHERE id_articulo = '".$nuevosarticulos['id_articulo']."' AND tipo=2))");
echo <<< HTML
    <div style='text-align: center; background: blue; color: white; width:25px; height: 25px; padding-top: 5px; float:left;'>$voto_articulo</div> <a style='margin-left:15px;' href="/es/articulo/$nuevosarticulos[id_articulo]">$nuevosarticulos[titulo]</a><br><a style='font-size:12px; margin-left:15px;'>By: $autor</a><br>
HTML;
}
echo "</div>";
                                            ?>
                                    </div>
                                        <div class="ultimos_articulos" style="float: right;">
                                        <h2><li><? echo getString('periodico_top'); ?></li></h2>
                                            <? 
                                            $fechalimite=(time()-(((60*60)*24)*5));
                                            $artivotos=array( 'articuloid' => array( ), 'numvotos' => array( ), 'nombre' => array( ));
$nuevosarticulosw = mysql_query("SELECT * FROM articulos WHERE fecha>$fechalimite ORDER by fecha DESC");
while($nuevosarticulos = mysql_fetch_array($nuevosarticulosw))  {
$nuevosarticuloswv = mysql_query("SELECT * FROM articulos_votos WHERE id_articulo='".$nuevosarticulos['id_articulo']."' AND tipo=1");
array_push($artivotos['articuloid'], $nuevosarticulos['id_articulo']);
array_push($artivotos['nombre'], $nuevosarticulos['titulo']);
array_push($artivotos['numvotos'], mysql_num_rows($nuevosarticuloswv));
}
array_multisort($artivotos['numvotos'],SORT_DESC, $artivotos['articuloid'], $artivotos['nombre']);

if(isset($artivotos['articuloid'][0])){
$artiarti0 = $artivotos['articuloid'][0];
$artivot0 = $artivotos['numvotos'][0];
$artinom0 = $artivotos['nombre'][0];
}
if(isset($artivotos['articuloid'][1])){
$artiarti1 = $artivotos['articuloid'][1];
$artivot1 = $artivotos['numvotos'][1];
$artinom1 = $artivotos['nombre'][1];
}
if(isset($artivotos['articuloid'][2])){
$artiarti2 = $artivotos['articuloid'][2];
$artivot2 = $artivotos['numvotos'][2];
$artinom2 = $artivotos['nombre'][2];
}
if(isset($artivotos['articuloid'][3])){
$artiarti3 = $artivotos['articuloid'][3];
$artivot3 = $artivotos['numvotos'][3];
$artinom3 = $artivotos['nombre'][3];
}
if(isset($artivotos['articuloid'][4])){
$artiarti4 = $artivotos['articuloid'][4];
$artivot4 = $artivotos['numvotos'][4];
$artinom4 = $artivotos['nombre'][4];
}
if(isset($artiarti0))
echo <<< HTML
        <a href="/es/articulo/$artiarti0">$artinom0 - $artivot0</a>
HTML;
if(isset($artiarti1))
echo <<< HTML
    <br><a href="/es/articulo/$artiarti1">$artinom1 - $artivot1</a>
HTML;
if(isset($artiarti2))
echo <<< HTML
    <br><a href="/es/articulo/$artiarti2">$artinom2 - $artivot2</a>
HTML;
if(isset($artiarti3))
echo <<< HTML
    <br><a href="/es/articulo/$artiarti3">$artinom3 - $artivot3</a>
HTML;
if(isset($artiarti4))
echo <<< HTML
    <br><a href="/es/articulo/$artiarti4">$artinom4 - $artivot4</a>
HTML;
                                            ?>
                                    </div>
                                    </div>
                                    <div id="guerras_login" style="float: right; width: 30em; height: 14.5em;">
                                        <h2><?echo getString('last_wars');?></h2><p>pais de las piruletas ha perdido contra pais del regaliz</p>
                                    </div>
                                </div>
                             
                            <?
                        }
                        ?>
                        </center>
                    </div><!--cuerpo-->
                    <?php include("pie.php");?>
                </div><!-- contenido -->
            </div><!-- shadow -->
        </div><!-- blur -->

  <?
}
?>
