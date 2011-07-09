<?
    include_once("include/funciones.php");
    $id = $_SESSION['id_usuario'];
    echo "Tu id: ".$id; 
?>

<form action="form_referer1.php" method="post">
     Email: <input type="text" name="mail" /><br/>
    <input type="submit" value="Enviar invitacion" />
    
</form>