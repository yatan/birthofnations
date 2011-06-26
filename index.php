<?

include_once("include/funciones.php");

?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
	<link type="text/css" href="css/css.css" rel="Stylesheet" /> 
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	

  </head>
  <body>
  
    <div id="top"> 
    </br>
    </div>
    
    <p>TODO write content</p>
	
	<br/>

	
        <br><br>
        
        <div id="login" style="margin-left:50%;">
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <label for="nick">Nick:<input tabindex="1" type="text" name="nick"></label><br>
                <label for="pass">Password:<input tabindex="2" type="password" name="pass"></label><br>
                <input type="submit">
            </form>
        </div>
        
	<div id="pie"> 
		<center>Estado mysql: <? online(); ?> Copyright 2011 Batamanta Team</center> 
	</div> 
  </body>
</html>
