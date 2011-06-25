<?

include_once("config.php");
include_once("include/config.php");
/*

Script con varias funciones:


online(): Muestra si el servidor mysql esta disponible o no
sql($sql): Ejecuta la sentencia sql, si da error muestra mensaje de error con die()
 *         devuelve un array con los valores obtenidos si hay mas de 1,
 *			o el valor sin array si solo devuelve 1 valor
 enviar_mail($destino, $nick, $id)
 *        Envia un correo para activar la cuenta --EN DESARROLLO--
 anadir_foro($usuario, $password, $email)
 *         Añade un usuario al foro smf

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
	

function enviar_mail($destino, $nick, $id)
{

select_lang();

// subject
$titulo = $mail_activation['activacion_titulo'];

// message
$mensaje = $mail_activation['activacion_mensaje'];

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

// Mail it
mail($destino, $titulo, $mensaje, $cabeceras);
	
	
	
	
}


function anadir_foro($usuario, $password, $email)
{
    
$server= $GLOBALS["server"];
$forouser=$GLOBALS["forouser"];; /* Usuario DB foro smf */
$foropass=$GLOBALS["foropass"];; /* Password DB foro smf */
$forodb=$GLOBALS["forodb"];; /* DB foro smf */
    
$link2=mysql_connect($server, $forouser, $foropass);

mysql_select_db($forodb, $link2);


$salt = substr(md5(mt_rand()), 0, 4);
$contrasena = sha1(strtolower($usuario) . $password);
$hora = time();

mysql_query("INSERT INTO smf_members (member_name, date_registered, real_name, passwd, email_address, password_salt) VALUES ('$usuario', '$hora', '$usuario', '$contrasena', '$email', '$salt')");

}

function select_lang ()
{
    //Cualquier metodo que vaya aqui para elegir el idioma Y cargar el archivo. De momento solo hay español
    
    include_once("../i18n/es_ES.php");
    
}

?>

