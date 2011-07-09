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
                    <?php include("cabecera.php"); echo "<center>Mi id:".$_SESSION['id_usuario']; echo "<br>Idioma: ".$_GET['lang']."</center>"; ?><br/>
                    <div id="menu">
                        <? include("menu.php"); ?>  
                    </div><!--menu-->
                    <div id="cuerpo">
                        <center>
                        <?
                        
                        if(isset($_GET['mod']))
                            
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
                            default :
                                die($_GET['mod']); //Default por si se pone algo incorrecto. Al futuro hay que cambiarlo
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