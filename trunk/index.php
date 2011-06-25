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
	
	<script type="text/javascript">
			$(function(){


				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					draggable: false,
					resizable: false
					
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});
			});
	</script>
  </head>
  <body>
  
    <div id="top"> 
    </br>
    </div>
    
    <p>TODO write content</p>
	
	<br/>
	<p><a href="#" id="dialog_link" class="ui-state-default ui-corner-all">Registro</a></p>
	
	
	<div id="dialog" title="Registro usuario nuevo">
	<? include("registro.php"); ?>
	</div>
	
        <br><br>
        
        <div id="login" style="margin-left:50%;">
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <label for="nick">Nick:<input type="text" name="nick"></label>
                <label for="pass">Password:<input type="password" name="pass"></label>
                <input type="submit">
            </form>
        </div>
        
	<div id="pie"> 
		<center>Estado mysql: <? online(); ?> Copyright 2011 Batamanta Team</center> 
	</div> 
  </body>
</html>
