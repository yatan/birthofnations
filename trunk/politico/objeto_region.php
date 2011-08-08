<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class region {

    public $nombre;
    public $id;

    function region($id) {
        $this->nombre = sql("SELECT name FROM region WHERE idregion = " . $id);
        $this->id = $id;
    }

    function owner_id() {
        $sql = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id);
        return $sql;
        }

        function owner_name(){

        $sql = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id);
        $sql = sql("SELECT name FROM country WHERE idcountry = " . $sql);
        return $sql;
    }

}

?>
