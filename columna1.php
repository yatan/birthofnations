<h1>Noticias</h1>
<div style="float:left; width:400px; text-align: left;">
    <ul>
        <?php

        $noticias = sql("SELECT tipo, msg FROM noticias ORDER BY id_noticia DESC LIMIT 3");
        foreach ($noticias as $noticia) {
            echo "<li>" . $noticia['msg'] . "</li>";
        }

        ?>
    </ul>
</div>
<div style="float:right; width: 225px;">
    <?php
    include("usuarios/info.php");
    ?>
</div>