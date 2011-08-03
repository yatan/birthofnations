<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include/config_variables.php");
select_lang();


class item
{

    public $nombre;
    public $is_raw;
    public $raw_necesario;
    
    function item($tipo)
    {
        
        $this->nombre = nombre_item($tipo);
        $this->raw_necesario = raw_needed($tipo);
        
        if($this->raw_necesario==0)
            $this->is_raw=true;
        else
            $this->is_raw=false;        
    }
    
   
    
}

?>
