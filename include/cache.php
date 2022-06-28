<?php
/*
* Clase PHP - Cache
* www.baluart.net
*/

class cache
{
    var $cache_dir; // path ó ruta donde se almacena la cache
    var $cache_time; // tiempo en que expira la cache (en segundos)
    var $caching = false; //true, para cachear
    var $cleaning = false; //true, para limpiar y actualizar
    var $file = ''; // path o ruta del script a cachear

    function iniciar($archivo = '', $time, $action = NULL)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/cache/';
        global $_SERVER;

        $this->cache_dir = $path;
        $this->cache_time = $time;
        $this->cleaning = $action;
        $this->file = $this->cache_dir . "cache_$archivo" . md5(urlencode($_SERVER['REQUEST_URI'])); //md5, encriptado por seguridad

        //condicional: Existencia del archivo, fecha expiración, acción
        if (file_exists($this->file) && (fileatime($this->file) + $this->cache_time) > time() && $this->cleaning == false) {

            readfile($this->file);
            /*
// abrimos el fichero
$handle = fopen( $this->file , "r");
do {
//leemos hasta 8192 bytes por defecto (podemos incrementarlo)
$data = fread($handle, 8192);
if (strlen($data) == 0) {
break;
}
//mostramos la cache
echo $data;
} while (true);
fclose($handle);
*/
            exit();
        } else {
            $this->caching = true;
            //grabamos buffer
            ob_start();
        }
    }

    function cerrar()
    {
        if ($this->caching) {
            //Recuperamos información del buffer
            $data = ob_get_clean();
            // mostramos información
            echo $data;
            //borramos cache si existe
            if (file_exists($this->file)) {
                unlink($this->file);
            }
            //escribimos información en cache
            $fp = fopen($this->file, 'w');
            fwrite($fp, $data);
            fclose($fp);
        }
    }
} // Fin clase Cache
