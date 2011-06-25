<?

include_once("config.php");

/*

Script con varias funciones:


online(): Muestra si el servidor mysql esta disponible o no
sql($sql): Ejecuta la sentencia sql, si da error muestra mensaje de error con die()
 *         devuelve un array con los valores obtenidos si hay mas de 1,
 *			o el valor sin array si solo devuelve 1 valor

*/

function online()
{
 
$ip = "localhost";  
$puerto = 3306; 
 
if ($fp=@fsockopen($ip,$puerto,$ERROR_NO,$ERROR_STR,(float)0.5))   
    {   
    fclose($fp);   
            echo "<font color='Green'>Online</font>";  
        } else {         
            echo "<font color='Red'>OFFLINE</font>";   
        }   


}

function sql_error($sql)
{
	
	$result = mysql_query($sql);

    if ($result == false)
    {
        error_log("SQL error: ".mysql_error()."\n\nOriginal query: $sql\n");
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
	


?>

