<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include("../index_head.php");

?>


<div id="juego">
<div id="mapa" style="height: 400px; width: 600px; background-color: green; margin-top: 50px;">
   <img src="http://www.ecologismo.com/wp-content/uploads/2011/02/bosques-espa%C3%B1oles.jpg" />

    <div style="position: absolute; top: 250px; left:160px;">
        <img src="http://www.guildwars2guru.com/forum/customavatars/avatar7295_2.gif"/>
    </div>
</div>


    
    <style>
        #botones td:hover {
            background-color: gray;
        }
        
    </style>
    
<div id="info" style="float: left; top:50px; left: 30px; height: 150px; width: 400px; background-color: #fff; margin-left: 90px; margin-top: 50px;">

    <table id="botones" border="2px" height="100%" width="100%" style="text-align: center;">
        <tr>
            <td>Atacar</td>
            <td>Objetos</td>
        </tr>
         <tr>
            <td>Defensar</td>
            <td>Huir</td>
        </tr>       
    </table>
</div>
    
</div>

