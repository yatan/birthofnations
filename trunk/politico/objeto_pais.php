<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pais {

    public $nombre;

    function pais($id) {
        $this->nombre = sql("SELECT name FROM country WHERE idcountry = " . $id);
    }
    function list_leaders($id){
        $sql = sql2("SELECT * FROM country_leaders WHERE idcountry = ". $id ." AND ( date_until  >= ". date("Y-m-d") ." OR is_forever = 1 ) ORDER BY position ASC");
        return $sql;
    }

}

?>
