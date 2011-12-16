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

//Se mira si es el primer login, por lo que no tendra ninguna ciudad asignada
if($objeto_usuario->id_region==null)
    header("Location: /login/primer_login.php"); //<-- Redireccion a la pagina del primer login

if($objeto_usuario->estoy_viajando==true && !isset($_GET['mod']))
    header("Location: /es/viajando"); //<-- Redireccion a la pagina mientras se vuela (TEMPORAL)

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
                            case "perfil":
                                include("usuarios/perfil.php");
                                break;   
                            case "mercado_laboral":
                                include("economico/mercado_trabajo.php");
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
                                        <h2>Periodicos</h2><p>Articulo misterioso</p>
                                    </div>
                                    <div id="guerras_login" style="float: right; width: 30em; height: 14.5em;">
                                        <h2>Ultimas guerras</h2><p>pais de las piruletas ha perdido contra pais del regaliz</p>
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