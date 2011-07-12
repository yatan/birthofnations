<?

//Archivo de reset diario

include_once("funciones.php");


//Economico
sql("UPDATE diario SET work = 0");

//Actualizacion del dia
sql("UPDATE settings SET day=day+1")

?>

