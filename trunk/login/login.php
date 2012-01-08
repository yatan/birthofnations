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
                       <?echo getString("login_texto");?>
                    </div>
                    <div id="login">
                        <form action="/login/logear.php" method="POST">
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
                        <a href="/login/recuperar.php"><?echo getString("login_recovery");?></a>
                    </div><!--login-->
                    <div id="publi" style="position: absolute; left: 50%; margin-left: -364px; top: 50%; margin-top: 150px;">
                        <script type="text/javascript">
                            <!-- 
                        google_ad_client = "ca-pub-3976033733199023";
                        /* birthofn login */
                        google_ad_slot = "1937910781";
                        google_ad_width = 728;
                        google_ad_height = 90;
                        //-->
                        </script>
                        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
                    </div>
                    <?php include("pie.php");?>
                </div><!-- contenido -->
    </body>
</html>
