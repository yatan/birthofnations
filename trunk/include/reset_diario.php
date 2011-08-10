<?

//Archivo de reset diario

include_once("config.php");
function sql_error($sql)
{
	
	$result = mysql_query($sql);

    if ($result == false)
    {
        //error_log("SQL error: ".mysql_error()."\n\nOriginal query: $sql\n");
        // Remove following line from production servers 
        die("SQL error: ".mysql_error()."\b<br>\n<br>Original query: $sql \n<br>\n<br>");
    }
	return $result;
	
}



function sql_data($result)
{
	
	//$result = sql_error($sql);
	
	if($lst = mysql_fetch_assoc($result))
    {
        mysql_free_result($result);
        return $lst;
    }
	    return false;
	
}

function sql($sql)
{
	
	$result = sql_error($sql);
	
        //Si no devuelve nada sale de la funcion
        if($result==1)
            return true;

	if (mysql_num_rows($result) == 1)	
	{
		if (mysql_num_fields($result) == 1)
			{
				
			$dato = mysql_fetch_row($result);
			return $dato[0];
			
			}
		else
	$table = sql_data($result);
	}
	else
	{
    
    $table = array();
	 if (mysql_num_rows($result) > 0)
    {
        $i = 0;
        while($table[$i] = mysql_fetch_assoc($result)) 
            $i++;
        unset($table[$i]);                                                                                  
    }                                                                                                                                     
    mysql_free_result($result);
	}
    return $table;
	}


//Seguridad       
if(!isset($_SERVER['argv']))
    die("Error");

$pin = $_SERVER['argv'][1];
$pin2 = sql("SELECT pin FROM settings");

if($pin != $pin2)
    die("Error");

//Economico
sql("UPDATE diario SET work = 0");

//Actualizacion del dia
sql("UPDATE settings SET day=day+1");

//Politico
sql("UPDATE usuarios SET ant_partido = ant_partido + 1");
$DA = sql("SELECT day FROM settings");
$sql = sql2("SELECT id_partido, frec_elecciones, dia_elecciones FROM partidos");

foreach ($sql as $party) {
    if ($DA % $party['frec_elecciones'] == $party['dia_elecciones']) {//Si es dia de elecciones la abrimos
        sql("INSERT INTO votaciones(tipo_votacion,fin,comienzo,param1) VALUES ('1','" . time() + 86400 . "',' " . time() . "','" . $party['id_partido'] . "')");
    }
}


echo "Cron realizado correctamente";
?>

