<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pais {

    public $nombre;
    public $id;
    public $bandera;
    
    function pais($id) {
        $this->nombre = sql("SELECT name FROM country WHERE idcountry = " . $id);
        $this->id = $id;
        $this->bandera = sql("SELECT url_bandera FROM country WHERE idcountry = " . $this->id);
    }
    function list_cargos(){
        $min = $this->id*100;
        $max = $this->id*100+99;
        $sql = sql2("SELECT * FROM country_leaders WHERE id_cargo >= " . $min . " AND id_cargo <= " . $max . " ORDER BY id_cargo ASC");
        return $sql;
    }
    function list_regions(){
        $sql = sql2("SELECT * FROM region WHERE idcountry = ". $this->id);
        return $sql;
    }
    function population(){
        $sql = sql("SELECT COUNT(*) FROM usuarios WHERE id_nacionalidad = " . $this->id);
        return $sql;
    }
    function tipo_gobierno(){
        $sql = sql("SELECT tipo_gobierno FROM country WHERE id_country = ". $id);
        return $sql;
    }

}

?>