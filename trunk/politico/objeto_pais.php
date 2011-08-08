<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pais {

    public $nombre;
    public $id;
    
    function pais($id) {
        $this->nombre = sql("SELECT name FROM country WHERE idcountry = " . $id);
        $this->id = $id;
    }
    function list_leaders(){
        $sql = sql2("SELECT * FROM country_leaders WHERE idcountry = ". $this->id ." AND ( date_until  >= ". date("Y-m-d") ." OR is_forever = 1 ) ORDER BY position ASC");
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
    function flag(){
        $sql = sql("SELECT url_bandera FROM country WHERE idcountry = " . $this->id);
        return $sql;
    }

}

?>
