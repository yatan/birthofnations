<script type="text/javascript" src="/js/countdown/jquery.countdown.js"></script>

<style>
    div.ui-dialog a.ui-dialog-titlebar-close {
        display: none;
    }
</style>

<script>
    $(function() {
        $("#dialog").dialog({
            draggable: false,
            resizable: false
        });
        $('#contador').countdown({
            until: <?php
                    $hora = sql("SELECT hora_final FROM viajes WHERE id_usuario='{$_SESSION['id_usuario']}'");
                    $hora2 = $hora - time();
                    echo "$hora2"; ?>,
            expiryUrl: "/",
            compact: true,
            description: ''
        });
    });
</script>

<div id="dialog" title="Viaje">
    <p>Tiempo restante de viaje:</p>
    <div id="contador"></div>
</div>