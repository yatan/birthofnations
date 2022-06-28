<?php

include_once 'fb.php';

if (!isset($_GET['access_token'])) {
    echo "Se va a proceder a asociar tu cuenta en Birh of Nations con tu cuenta de facebook.";
    echo '<a href="https://graph.facebook.com/oauth/authorize?type=user_agent&client_id=215454291835577&redirect_uri=http://www.birthofnations.com/snetworks/facebook/index.php&scope=offline_access,manage_pages">clic aquí</a>';
} else {

    $url_json = "https://graph.facebook.com/me?access_token=" . $_GET['#access_token'];
    $datos_usuario = json_decode(file_get_contents($url_json));


    $fb = new Fb($_GET['#access_token'], $datos_usuario->id);

    echo "Tu usario en Facebook es " . $datos_usuario->first_name . " y tu id es {$datos_usuario->id}";

    if ($fb->publicarNota($datos_usuario->first_name . "prueba enlace API-PHP"))
        echo "Tu cuenta de Facebook se ha asociado a Birth of Nations correctamente";
    else
        echo "Se produjo un error al publicar en tu muro";
}
