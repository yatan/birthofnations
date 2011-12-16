<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
echo"<html>";
include($_SERVER['DOCUMENT_ROOT']."/index_head.php");
?>
<script type="text/javascript" src="/js/countdown/jquery.countdown.js"></script>

<style>
div.ui-dialog a.ui-dialog-titlebar-close {
display: none;
}
</style>

<script>
	$(function() {
            	var austDay = "<? 
                $hora = sql("SELECT hora_final FROM viajes WHERE id_usuario='{$_SESSION['id_usuario']}'");
                echo date("M j, Y H:i:s O", $hora); ?>";
	
		$( "#dialog" ).dialog({draggable: false, resizable: false});
                $('#contador').countdown({until: austDay, compact: true, 
    description: ''});
	});
        
</script>

<div id="dialog" title="Viaje">
    <p>Tiempo restante de viaje:</p>
    <div id="contador"></div>
</div>

</body>
</html>