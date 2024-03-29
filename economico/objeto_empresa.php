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
    public $raw;

    public $gold;

    private $money;


    public function __construct($businessId)
    {
        $empresa = sql("SELECT * FROM empresas WHERE id_empresa='" . $businessId . "'");
        if ($empresa == false)
            return false; //Si no existe la empresa devuelve false

        $this->id_empresa = $businessId;
        $this->id_propietario = $empresa['id_propietario'];
        $this->nombre_empresa = $empresa['nombre_empresa'];
        $this->tipo = $empresa['tipo'];
        $this->gold = $empresa['Gold'];
        $this->stock = $empresa['stock'];
        $this->items_venta = $empresa['items_venta'];
        $this->precio_venta = $empresa['precio_venta'];
        $this->raw = $empresa['raw'];
        $this->pais = $empresa['pais'];
        $this->region = $empresa['region'];
        $this->precio_empresa = $empresa['precio_empresa'];

        $this->setMoney();
    }

    public function get_nick_propietario()
    {
        $nick = sql("SELECT nick FROM usuarios WHERE id_usuario='$this->id_propietario'");
        return $nick;
    }

    public function get_tipo()
    {
        $tipo = sql("SELECT tipo FROM empresas WHERE id_empresa = " . $this->id_empresa);
        return $tipo;
    }

    private function setMoney()
    {
        $this->money = [
            'gold' => $this->gold
        ];
    }

    public function getMoney()
    {
        return $this->money;
    }
}
