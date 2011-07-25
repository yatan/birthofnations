<?
include("/index_head.php");
?>

<style>
div.ui-dialog a.ui-dialog-titlebar-close {
display: none;
}
</style>

<script>
	$(function() {
		$( "#dialog" ).dialog({draggable: false, resizable: false});
	});
</script>

<div id="dialog" title="Modo mantenimiento">
	<center><p>El juego se encuntra en mantenimiento.</p>
        <p>Para visitar el foro use el siguiente link:</p>
        <p><a href="/forum/">Acceder al foro</a></font></p>
</div>

<?
die();
?>
