<?php

/*
 * Pagina simple de envio del email
 * para la recuperacion de password
 */
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");



if(!isset($_POST['mail']))
    echo "<p>".getString('login_reset_password_no_mail')."</p><center><img src='/images/menu/no.png'/></center>";
elseif(isset($_POST['mail']) && $_POST['mail']=="")
    echo "<p>".getString('login_reset_password_mail_sent')."</p><center><img src='/images/menu/si.png'/></center>";
else
{
    $correo = $_POST['mail'];
    reset_mail($correo);
    echo $correo_ok;
    
}
    
?>
