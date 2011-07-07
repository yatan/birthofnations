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
    <head>
        <title>Birth Of Nations</title>
        <link type="text/css" href="/css/css.css" rel="Stylesheet" />
        <link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
        <link type="text/css" href="/css/menu_style.css" rel="stylesheet" />
        <script type="text/javascript" src="/js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.13.custom.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body> 
        <div class="blur">
            <div class="shadow">
                <div id="contenido">
                    <?php include("cabecera.php"); echo "<center>Mi id:".$_SESSION['id_usuario']; echo "<br>Idioma: ".$_GET['lang']."</center>"; ?><br/>
                    <div id="menu">
                        <h2>Menu</h2>
                        
                        <p><a href="./">Inicio</a> - Economia - Militar - Politica - Perfil - <a href="/logout">Logout</a></p>
                        <p><a href="./crear_empresa">Crear Empresa</a>
                        
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
