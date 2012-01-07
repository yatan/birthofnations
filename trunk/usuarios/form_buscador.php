<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/usuarios/buscar.php?lang=<? echo $_GET['lang']; ?>" method="post">
    <img src="/images/lupa.png"/>
    <input type="text" name="nick" size="10" style="text-align: right;" />
    <input type="submit" value="Ok" />
</form>
