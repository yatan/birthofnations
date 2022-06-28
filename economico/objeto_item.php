<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");

class item
{

    public $nombre;
    public $is_raw;
    public $raw_needed;

    function __construct($tipo)
    {
        $item = sql("SELECT * FROM items WHERE id_item = " . $tipo);
        $this->nombre = $item['item' . $tipo];
        $this->is_raw = $item['is_raw'];

        $sql = explode(',', $item['raw_needed']);
        foreach ($sql as $i) {
            $this->raw_needed[] = explode('-', $i);
        }
    }
}
