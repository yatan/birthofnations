<?php
	include_once("./include/funciones.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<? include("index_head.php"); ?>
    <body> 
                <div id="contenido">
                    <?php include("cabecera.php");?><br/>
                    <div id="texto" style="color:black; font-size: large;">
                        Birth of Nations es un juego online libre de estrategia política, económica y social. El desarrollo del juego se realiza de forma comunitaria, y sus propios jugadores deciden cual es el rumbo que toma el proyecto.
                    </div>
                    <div id="login">
                        <form action="../login/logear.php" method="POST">
                            <h2>Login</h2>
                            <table border="0">
                                <tr>
                            <td><label for="nick">Nick:</label></td>
                            <td><input tabindex="1" type="text" name="nick"></td>
                                </tr>
                                <tr>
                            <td><label for="pass">Password:</label></td><td><input tabindex="2" type="password" name="pass"></td>
                               <tr>     
                                   <td><input type="submit" value="Login"></td>
                               </tr>
                            </table>
                        </form>
                    </div><!--login-->
                    <?php include("pie.php");?>
                </div><!-- contenido -->
    </body>
</html>
