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

    function owner_name() {

        $sql = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id);
        $sql = sql("SELECT name FROM country WHERE idcountry = " . $sql);
        return $sql;
    }
    function owner_flag() {

        $sql = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id);
        $sql = sql("SELECT url_bandera FROM country WHERE idcountry = " . $sql);
        return $sql;
    }

    function distance_to_all() {
        include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/grafo_region.php"); //Cargar grafo de regiones
        $grafo_region->findShortestPath($this->id); //Origen esta region
        $ret = $grafo_region->getResults();
        unset( $ret[0]); //Nunca tenemos region cero
        return $ret;
    }
    function distance_to($id) {
        include_once($_SERVER['DOCUMENT_ROOT'] . "/politico/grafo_region.php"); //Cargar grafo de regiones
        $grafo_region->findShortestPath($this->id); //Origen esta region
        $ret = $grafo_region->getResults($id);
        return $ret;
    }

}

?>
