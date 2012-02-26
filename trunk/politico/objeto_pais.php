<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pais {

    public $nombre;
    public $id;
    public $bandera;
    public $exp;
    public $gov_type;

    function pais($id) {
        $sql = sql("SELECT name, url_bandera, exp,tipo_gobierno FROM country WHERE idcountry = " . $id);
        $this->nombre = $sql['name'];
        $this->id = $id;
        $this->bandera = $sql['url_bandera'];
        $this->exp = $sql['exp'];
        $this->gov_type = $sql['tipo_gobierno'];
    }

    function list_cargos() {
        $min = $this->id * 100;
        $max = $this->id * 100 + 99;
        $sql = sql2("SELECT * FROM country_leaders WHERE id_cargo >= " . $min . " AND id_cargo <= " . $max . " ORDER BY id_cargo ASC");
        return $sql;
    }

    function list_regions() {
        $sql = sql2("SELECT * FROM region WHERE idcountry = " . $this->id);
        return $sql;
    }

    function list_tech() {//Solo la disponible, aunque sea a nivel 0
        //Aqui deberia haber una lista de las id de las tecnologia disponibles segun el estado del pais
        switch ($this->gov_type):
            case 1:
                $tech = "";
                break;
            case 2:
            case 3:
                $tech = array(1,2);
                 break;
        endswitch;
        $sql = sql("SELECT * FROM country_tech WHERE id_country = " . $this->id);
        
        foreach ($tech as $tec) {

            $ret[$tec] = $sql['tech' . $tec];
        }

        return $ret;
    }

    function population() {
        $sql = sql("SELECT COUNT(*) FROM usuarios WHERE id_nacionalidad = " . $this->id);
        return $sql;
    }

    function tipo_gobierno() {
        $sql = sql("SELECT tipo_gobierno FROM country WHERE id_country = " . $id);
        return $sql;
    }

}

?>
