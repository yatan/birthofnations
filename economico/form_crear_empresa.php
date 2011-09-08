
<div id="crear_empresa">
    <form id="empresa" action="../economico/crear_empresa.php" method="POST">
        <h2>Creacion de empresas:</h2>
        <label for="nombre">Nombre:<input tabindex="1" type="text" name="nombre"></label><br>
        <label for="pass">Tipo:<select name="tipo">
<?
$sql = sql("SELECT id_item FROM items WHERE empresable = 1");
foreach ($sql as $item){
    echo "<option value=".$item['id_item'].">".$txt['item'.$item['id_item']]."</option>";
}
?>
        </label><br>
        <input type="button" id="enviar" value="Enviar">
    </form>
</div><!--form de creacion de empresas-->
<script>
    $('#enviar').click(function() {
        $.post("../economico/crear_empresa.php", $("#empresa").serialize(),
        function(data){
            alert(data);
        } );
   
    });

</script>