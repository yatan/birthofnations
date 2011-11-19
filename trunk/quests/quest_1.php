<?php

/*
 * Quest 1
 * En busca de los lobos enfadados
 * 
 * Test de quest
 */

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include("../index_head.php");

class quest_1
{
    
    //Detalles mision
    
    private $id_quest = 1;
    
    public $nombre_quest = "En busca de los lobos enfadados";
    public $texto_quest = "Ve al bosque Willon y mata 10 lobos.";
    public $recompensa = "12 de Experiencia y 2 pociones";
    
    //Recompensas
    
    private $exp_recompensa = 12;
    private $item_recompensa = 1;
    private $cantidad_items_recompensa = 2;
    
    //Objetivos
    
    private $lobos_muertos;
    private $lobos_necesarios = 10;
      


    function __construct()
    {
        echo "Mision {$this->id_quest} creada<br>";
        $this->cargar();
    }
    
    function __destruct() 
    {
       echo "Destruyendo mision {$this->id_quest} <br>";
       $this->guardar();
    }
    
    function matar_lobo()
    {
        
        if($this->lobos_muertos >= $this->lobos_necesarios)
        {
            echo "Ya has hecho esta mision<br>";
            exit();
        }
        $this->lobos_muertos++;
        $this->guardar();
        echo "Has matado {$this->lobos_muertos} / {$this->lobos_necesarios} <br>";
        
        if($this->lobos_muertos >= $this->lobos_necesarios)
        {
            $this->dar_recompensa();
        }
    }
    
    function dar_recompensa()
    {
        echo "Has terminado la quest !<br>";
        echo "Obtienes 10 de EXP y 2 pociones<br>";
        //Aqui codigo para añadir items
        sql("UPDATE usuarios SET exp = exp + {$this->exp_recompensa} WHERE id_usuario='1'");
    }
    
    function info()
    {
       echo $this->nombre_quest ."<br>";
       echo $this->texto_quest ."<br>";
       echo $this->recompensa ."<br>";
    }
    
    function guardar()
    {
       $s = serialize($this);
       sql("UPDATE quests SET quest_1='$s' WHERE id_usuario='1'");
    }
    
    function cargar()
    {
        $archivo = sql("SELECT quest_1 FROM quests WHERE id_usuario='1'");
        if($archivo == false)
        {
            $this->lobos_muertos=0;
        }
        else
        {
            
            $a = unserialize($archivo);

            $this->lobos_muertos = $a->lobos_muertos;

            //Comprobamos si la mision ya esta hecha.
            if($this->lobos_muertos >= $this->lobos_necesarios)
                {
                echo "Ya has hecho esta mision<br>";
                exit();
                }
        }
    }

    
    
    
}

$mision = new quest_1();
/*
$mision ->matar_lobo();

$mision ->matar_lobo();

*/


?>

<div id="juego">
<div id="mapa" style="height: 600px; width: 600px; background-color: green; margin-top: 50px;">
    <?
    for($x=0;$x<5;$x++)
    {
        for($y=0;$y<5;$y++)
        {
            echo "<img src='http://www.dibujosparacolorear24.com/flash/es/thumbs/54423.png'/>";
        }
        echo "<br>";
    }
    ?>
</div>

<div id="info" style="position:absolute;top:50px; left: 30px; height: 350px; width: 280px; background-color: #fff; margin-left: 900px; margin-top: 100px;">
    <center><h3>Log</h3></center>
    <ul>
<?
$mision->info();
$mision ->matar_lobo();
?>
    </ul>
</div>
    
</div>