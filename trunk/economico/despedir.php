<?php
if(!isset($_POST['id_worker']))
    die("Who?");
    
//Mecanismos de seguridad, comprobar que estas logueado como admin y tal


//Mecanismo del despido
sql("UPDATE usuarios SET id_empresa = 0 WHERE id_usuario = " . $_POST['id_worker']);

?>