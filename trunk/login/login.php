<?php
	include_once("./include/funciones.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<? include("index_head.php"); ?>
    <style type="text/css">
label
{
width: 4em;
float: left;
text-align: right;
margin-right: 0.5em;
display: block;
font-size: 18px;
}

.submit input
{
margin-left: 4.5em;
} 
input
{
color: #781351;
background: #fee3ad;
border: 1px solid #781351
}

.submit input
{
color: #000;
background: #ffa20f;
border: 2px outset #d7b9c9
} 
fieldset
{
border: 1px solid #781351;
width: 20em
}

legend
{
color: #fff;
background: #ffa20c;
border: 1px solid #781351;
padding: 2px 6px;
font-size: 24px;
} 

.recover
{
    text-decoration: none;
    display: block;
    color: #000;
    background: #ffa20f;
    border: 2px outset #d7b9c9;
    width: 150px;
    float:right;
}

#login
{
    margin-top: 70px;
}
    </style>
    <body> 
                <div id="contenido">
                    <?php include("cabecera.php");?><br/>
                    <div id="texto" style="color:black; font-size: large;">
                       <?echo getString("login_texto");?>
                    </div>
                    
                    <div id="login">
                        <form action="/login/logear.php" method="POST">
                            <fieldset>
                                <legend>Login</legend>
                            <p><label for="nick" style="color:#781351;">Nick:</label><input tabindex="1" type="text" name="nick"></p>
                            <p><label for="pass" style="color:#781351;">Password:</label><input tabindex="2" type="password" name="pass"></p>
                            <p class="submit"><input type="submit" value="Login">
                            <a class="recover" href="/login/recuperar.php" style="text-align: center; color:black;"><?echo getString("login_recovery");?></a></p>
                            </fieldset>
                        </form>
                        
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
