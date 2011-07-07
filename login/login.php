<?php
	include_once("./include/funciones.php");
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
                    <?php include("cabecera.php");?><br/>
                    <div id="login">
                        <form action="../login/logear.php" method="POST">
                            <h2>Login</h2>
                            <table border="0">
                                <tr>
                            <td><label for="nick">Nick:</td>
                            <td><input tabindex="1" type="text" name="nick"></label></td>
                                </tr>
                                <tr>
                            <td><label for="pass">Password:</td><td><input tabindex="2" type="password" name="pass"></label></td>
                               <tr>     
                                   <td><input type="submit" value="Login"></td>
                               </tr>
                            </table>
                        </form>
                    </div><!--login-->
                    <?php include("pie.php");?>
                </div><!-- contenido -->
            </div><!-- shadow -->
        </div><!-- blur -->
    </body>
</html>
