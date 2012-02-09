<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <h1>Noticias</h1>
    <div style="float:left; width:400px; text-align: left;">
        <ul>
    <?
    
    $noticias = sql("SELECT tipo, msg FROM noticias ORDER BY id_noticia DESC LIMIT 3");
    foreach ($noticias as $noticia) {
        echo "<li>".$noticia['msg']."</li>";
    }
    
    ?>
        </ul>
    </div>
    <div style="float:right; width: 225px;">
        <?
        include("usuarios/info.php");
        ?>
    </div>

