<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
select_lang();


class empresa
{
    public $id_empresa;
    public $id_propietario;
    public $nombre_empresa;
    public $tipo;
    public $stock;
    public $items_venta;
    public $precio_venta;
    public $en_venta;
    public $precio_empresa;
    public $pais;
    public $region;
    public $zona;
    public $raw;
    public $Gold;
    public $ESP;
    public $FRF;

    public function __construct($id)
    {
        $empresa = sql("SELECT * FROM empresas WHERE id_empresa='$id'");
        if ($empresa == false)
            return false; //Si no existe la empresa devuelve false

        $this->id_empresa = $id;
        $this->id_propietario = $empresa['id_propietario'];
        $this->nombre_empresa = $empresa['nombre_empresa'];
        $this->tipo = $empresa['tipo'];
        $this->Gold = $empresa['Gold'];
        $this->stock = $empresa['stock'];
        $this->items_venta = $empresa['items_venta'];
        $this->precio_venta = $empresa['precio_venta'];
        $this->raw = $empresa['raw'];
        $this->pais = $empresa['pais'];
        $this->region = $empresa['region'];
        $this->precio_empresa = $empresa['precio_empresa'];
    }

    function get_nick_propietario()
    {
        $nick = sql("SELECT nick FROM usuarios WHERE id_usuario='$this->id_propietario'");
        return $nick;
    }

    function get_tipo()
    {
        $tipo = sql("SELECT tipo FROM empresas WHERE id_empresa = " . $this->id_empresa);
        return $tipo;
    }
}
