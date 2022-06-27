<?php
include_once("include/funciones.php");
$id = $_SESSION['id_usuario'];
echo "Tu id: " . $id;
?>

<form id="invitar_form" name="invitar_form" method="post" action="">
    Email: <input type="text" name="mail" /><br />
    <?php
    // if (smtp_online() == false)
    echo "<input id='b_invitar' type='button' value='" .  getString('enviar_invitacion') . "' />";
    /* else
        echo "<p>" .  getString('mail_server_error') . "</p>"; */
    ?>
</form>
<br>
<h3>Tus referidos:</h3>
<?php
$referidos = sql("SELECT nick FROM usuarios WHERE id_referer='$id'");

if (!is_array($referidos)) {
    echo $referidos;
} else {
    foreach ($referidos as $referido) {
        echo $referido['nick'] . "<br>";
    }
}

?>

<script type="text/javascript">
    $('#b_invitar').click(function() {
        $('#b_invitar').hide();
        var notice = $.pnotify({
            pnotify_title: "<?php echo getstring('comprar'); ?>",
            pnotify_type: 'info',
            pnotify_info_icon: 'picon picon-throbber',
            pnotify_hide: false,
            pnotify_sticker: false,
            pnotify_width: "275px",
            pnotify_text: "<center><img src='/images/loading.gif'/></center>"
        });


        $.post("/form_referer1.php", $('#invitar_form').serialize(),
            function(data) {
                var options = {
                    pnotify_text: data
                };
                notice.pnotify(options);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            });


    });
</script>