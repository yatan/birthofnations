<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("include/funciones.php");
//Comrpobacion si el juego esta en mantenimiento
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
    if(sql("SELECT id_pais FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'")==null)
        header("Location: /login/primer_login.php"); //<-- Redireccion a la pagina principal
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <?php include("index_head.php"); ?>
    <body> 
        <div class="blur">
            <div class="shadow">
                <div id="contenido">
                    <?php include("cabecera.php"); ?><br/>
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
                            case "redactar":
                                include("periodico/redactar.php");
                                break; 
                            case "buscador":
                                include("usuarios/buscador.php");
                                break;                             
                            default :
                                die($_GET['mod']); //Default por si se pone algo incorrecto. Al futuro hay que cambiarlo
                            }
                        }
                        else
                        {
                            //Aqui va lo del centro de la pagina principal
                            ?>
                            <table border="0">
                            <tr><td><div id="columna1">
                               <? include("columna1.php"); ?>
                            </div></td>

                            <td><div id="columna2">
                               <? include("columna2.php"); ?>
                            </div></td></tr>
                            <tr>
                                <td><h2>Periodicos</h2><p>Articulo misterioso</p></td>
                                <td><h2>Ultimas guerras</h2><p>pais de las piruletas ha perdido contra pais del regali</p></td>
                            </tr>
                            </table>
                            <?
                        }
                        ?>
                        </center>
                    </div><!--menu-->
                    <?php include("pie.php");?>
                </div><!-- contenido -->
            </div><!-- shadow -->
        </div><!-- blur -->

  <?
}
?>