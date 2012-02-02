<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include("../index_head.php");

?>

    
<style>
    #botones td:hover {
        background-color: gray;
    }
    #vida_yo {
        width: 200px;
        height: 10px;

    }
    #vida_bicho {
        width: 200px;
        height: 10px;

    }
</style>

<div id="juego">
<div id="mapa" style="height: 400px; width: 600px; background-color: green; margin-top: 50px;">
   <img src="http://www.ecologismo.com/wp-content/uploads/2011/02/bosques-espa%C3%B1oles.jpg" />

    <div style="position: absolute; top: 250px; left:160px;">
        <img src="http://www.guildwars2guru.com/forum/customavatars/avatar7295_2.gif"/>
    </div>
</div>

<div style="left:40px; width: 200px; background-color: wheat;"><center>Mi vida</center> <div style="" id="vida_yo"></div></div>

    
<div id="boton" style="float: left; top:50px; left: 30px; height: 150px; width: 400px; background-color: #fff; margin-left: 90px; margin-top: 50px;">

    <table id="botones" border="2px" height="100%" width="100%" style="text-align: center;">
        <tr>
            <td id="atacar">Atacar</td>
            <td>Objetos</td>
        </tr>
         <tr>
            <td>Defender</td>
            <td>Huir</td>
        </tr>       
    </table>
</div>
    

 
<div id="log" style="OVERFLOW: auto; position:absolute;top:50px; left: 30px; height: 350px; width: 280px; background-color: #fff; margin-left: 900px; margin-top: 100px;">
    <center><h3>Log</h3></center>
    <ul>

    </ul>
</div>    
    
</div>


<script>
    $(document).ready(function() {
        mi_vida = 100;
        
        
        $("#vida_yo").progressbar({ value: mi_vida });
        
        $("#atacar").click(function() { 
            mi_vida -= 10;
            $("#log").append("<p>Ataca!!</p>");
            $("#vida_yo").progressbar({ value: mi_vida });
        });

}); 
    
    
    
</script>    