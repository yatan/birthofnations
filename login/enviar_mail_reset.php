<?php

/*
 * Pagina simple de envio del email
 * para la recuperacion de password
 */
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$falta_email = "<p>Sin email no se podra recuperar nada</p><center><img src='/images/menu/no.png'/></center>";
$correo_ok = "<p>Se ha enviado el email con las instrucciones.</p><center><img src='/images/menu/si.png'/></center>";

if(!isset($_POST['mail']))
    echo $falta_email;
elseif(isset($_POST['mail']) && $_POST['mail']=="")
    echo $falta_email;
else
{
    $correo = $_POST['mail'];
    reset_mail($correo);
    echo $correo_ok;
    
}
    
?>
