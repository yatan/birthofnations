<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <textarea name="noticia" cols="60" rows="10"></textarea><br>
    <input type="submit" value="Insertar Noticia" />
</form>
<?php

if ($_POST) {
    if (isset($_POST['noticia'])) {
        sql("INSERT INTO noticias (msg) VALUES ('" . $_POST['noticia'] . "')");
        echo "<font size='5' color='red'>Noticia añadida correctamente</font><br><br>";
    }
}

//Visualizacion de las noticias
$noticias = sql("SELECT tipo, msg FROM noticias ORDER BY id_noticia DESC LIMIT 3");
foreach ($noticias as $noticia) {
    echo "<li>" . $noticia['msg'] . "</li>";
}

?>