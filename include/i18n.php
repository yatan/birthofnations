<?php
    if(!isset ($_SESSION['rutai18n']) || isset($_GET['lang']))
    {   
    $flag = 0;    
    if(isset($_GET['lang']))
    {
        $ruta = './i18n/'.$_GET['lang'].'/';
        
        if(file_exists($ruta))
        {
            $_SESSION['rutai18n'] = $ruta;
            $flag = 1;
        }
    }

    if($flag == 0) //idioma por defecto
    {
        $_SESSION['rutai18n'] = './i18n/es_ES/';
    }
    $_SESSION['rutai18nDefecto'] = './i18n/es_ES/';
    unset ($flag);
    }
   $i18n = new i18n();
   include_once './modulos/archivos/Archivo.php';
   include_once './config/ObtenerPropiedades.php';
    class i18n
    {
        private $dicc;
        private $dicc_general;
        private function getRuta($archivo)
        {
            if(file_exists($_SESSION['rutai18n'].$archivo))
            {
                return $_SESSION['rutai18n'].$archivo;
            }
            else
            {
                return $_SESSION['rutai18nDefecto'].$archivo;
            }
        }
        
        public function cargarCadena($archivo)
        {
            $this->archivo = $archivo;
            $lector = new Archivo();
            $lector->setRuta($this->getRuta($archivo));
            $lector->abrirFlujo('r');
            $valores = $lector->leerTodo();
            $valores = explode(';', $valores);
            $categoria = 'general';
            foreach ($valores as $linea)
            {
                if(strlen(trim($linea)) > 0)
                {
                {
                    $aux = trim($linea);
                    if($aux[0] == '-')
                    {
                        $aux = explode('-', $linea);
                        $aux = explode(';', $aux[1]);                        
                        $categoria = trim($aux[0]);
                    }
                    else
                    {
                        $linea = explode('=', $linea);
                        $this->dicc[$categoria][trim($linea[0])] = $linea[1];
                    }
                }
                
            }
           


          $lector = new Archivo();
          $lector->setRuta($_SESSION['rutai18nDefecto'].$archivo);
          $lector->abrirFlujo('r');
            $valores = $lector->leerTodo();
            $valores = explode(';', $valores);
            $categoria = 'general';
            foreach ($valores as $linea)
            {
               
                if(strlen(trim($linea)) > 0)
                {
                    $aux = trim($linea);
                    if($aux[0] == '-')
                    {
                        $aux = explode('-', $linea);
                        $aux = explode(';', $aux[1]);
                        $categoria = trim($aux[0]);                     
                    }
                    else
                    {
                     
                        $linea = explode('=', $linea);
                        $this->dicc_general[$categoria][trim($linea[0])] = $linea[1];
                       
                    }
                }
            }

           
        }
        }

        public function getCadena($categoria, $valor)
        {
           
              if(isset($this->dicc[$categoria][$valor]))
                       return $this->dicc[$categoria][$valor];
               else
               {                   
                   return $this->dicc_general[$categoria][$valor];
               }
        }

    }
?>
