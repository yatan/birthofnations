<?php

require_once 'api/facebook.php';
require_once("../include/snetworks.php");
/**
 * Clase para facilitar el trabajo con Facebook. Proporciona métodos para
 * publicar imágenes en un álbum, notas en el muro, y eventos
 *
 * Ejemplos de uso:
 * $fb = new Fb();
 * $fb->publicarNota('Prueba');
 * $fb->publicarImagen('/home/zootropo/html/imagenes/mi-imagen.jpg');
 * $fb-gt;publicarEvento('Prueba de evento', 'Descripción del evento', '2011-03-08');
 */
class Fb {
    
    private $ACCESS_TOKEN;
    private $ID_ALBUM; // De momento, sin uso
    private $ID_USUARIO;
    private $fb;


    function __construct(){
          $this->fb = new Facebook(array(
          'appId'  => $ID_APP,
          'secret' => $SECRETO,
          'cookie' => true
        ));

    }
    /**
     * Constructor de la clase. Crea el objeto Facebook que utilizaremos
     * en los métodos que interactúan con la red social
     */


    /**
     * Publica un evento
     * @param string $titulo Título del evento
     * @param string $descripcion Descripción del evento
     * @param string $inicio Fecha o fecha y hora de inicio del evento, en formato ISO-8601 o timestamp UNIX
     * @return bool Indica si la acción se llevó a cabo con éxito
     */
    function publicarEvento($titulo, $descripcion, $inicio) {
        $params = array(
            'access_token' => $this->ACCESS_TOKEN,
            'name' => $titulo,
            'description' => $descripcion,
            'start_time' => $inicio,
        );
        $res = $this->fb->api('/'.$this->ID_USUARIO.'/events', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    /**
     * Publica una nota en el muro de la página
     * @param string $mensaje
     * @return bool Indica si la acción se llevó a cabo con éxito
     */
    function publicarNota($mensaje) {
        $params = array(
            'access_token' => $this->ACCESS_TOKEN,
            'message' => $mensaje
        );
        $res = $this->fb->api('/'.$this->ID_USUARIO.'/feed', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    /**
     * Publica una imagen en el álbum de la página
     * @param string $ruta Ruta absoluta a la imagen en nuestro servidor
     * @param string $mensaje Mensaje a mostrar en el muro, si queremos avisar
     * de la subida de la imagen
     * @return bool Indica si la acción se llevó a cabo con éxito
     */
    function publicarImagen($ruta, $mensaje='') {
        $this->fb->setFileUploadSupport(true);

        $params = array(
            'access_token' => $this->ACCESS_TOKEN,
            'source' => "@$ruta"
        );
        if($mensaje) $params['message'] = $mensaje;

        $res = $this->fb->api('/'.$this->ID_ALBUM.'/photos', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }


function getToken(){
    return $this->fb->getAccessToken();
}
  function getUsuario(){
      return $this->fb->getUser();


  }


}