<div id="crear_empresa">
    <form id="empresa" action="../economico/crear_empresa.php" method="POST">
        <h2>Creacion de empresas:</h2>
        <label for="nombre">Nombre:<input tabindex="1" type="text" name="nombre"></label><br>
        <label for="pass">Tipo:<select name="tipo">
                <?php
                $sql = sql("SELECT id_item FROM items WHERE empresable = 1");
                foreach ($sql as $item) {
                    echo "<option value=" . $item['id_item'] . ">" . ucfirst(id2item($item['id_item'])) . "</option>";
                }
                ?>
            </select></label><br>
        <input type="button" id="enviar" value="<?php echo getString('company_create_send'); ?>">
    </form>
    <p>Coste 10 <img src="/images/status_bar/gold.gif" /> <? echo getString('golds'); ?></p>
</div>
<!--form de creacion de empresas-->
<script>
    $('#enviar').click(function() {
        $.post("../economico/crear_empresa.php", $("#empresa").serialize(),
            function(data) {
                alert(data);
            });

    });
</script>