<?php

/*
 * Quest 1
 * En busca de los lobos enfadados
 * 
 * Test de quest
 */

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
    }
    
    
    function guardar()
    {
       $s = serialize($this);
       $fp = fopen("quest_1.txt", "w");
       fwrite($fp, $s);
       fclose($fp);        
    }
    
    function cargar()
    {
        $archivo = @file("quest_1.txt");
        if($archivo == false)
        {
            $this->lobos_muertos=0;
        }
        else
        {
            $s = implode("", $archivo);
            $a = unserialize($s);


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

$mision = new quest_1("1");

$mision ->matar_lobo();
$mision ->matar_lobo();
$mision ->matar_lobo();




?>
