<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include($_SERVER['DOCUMENT_ROOT']."/index_head.php");
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

<div id="dialog" title="<? echo $txt['mantenimiento_1']; ?>">
	<center><p><? echo $txt['mantenimiento_2']; ?></p>
        <p><? echo $txt['mantenimiento_3']; ?></p>
        <p><a href="/forum/"><? echo $txt['mantenimiento_4']; ?></a></p>
</div>

<?
die();
?>
