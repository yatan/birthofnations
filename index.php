<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("include/funciones.php");

if(!isset($_SESSION['id_usuario']))
{
    include("login/login.php");
    exit;
}
else
{
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
                            default :
                                die($_GET['mod']); //Default por si se pone algo incorrecto. Al futuro hay que cambiarlo
                            }
                        }
                        else
                        {
                            //Aqui va lo del centro de la pagina principal
                            ?>
                            <div id="columna1">
                               <? include("columna1.php"); ?>
                            </div>

                            <div id="columna2">
                               <? include("columna2.php"); ?>
                            </div>
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