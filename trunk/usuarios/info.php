<?php

/*
 * Code started by: yatan
 * Batamanta Team
 */
$cantidad = sql("SELECT COUNT(*) FROM votaciones WHERE id_pais='$objeto_usuario->id_nacionalidad' AND solved='0'");
if($cantidad>0)
    echo <<<EOT

<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
    <p><span class="ui-icon ui-icon-info" style="float: left;"></span>
    <strong>Hey!</strong> Hay una votacion disponible en <? echo $objeto_usuario->get_n_nacionalidad(); ?></p>
</div>
EOT;

?>