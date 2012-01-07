<div id="crear_partido">
    <form action="../politico/crear_partido.php" method="POST">
        <h2><?getString("new_party");?></h2>
        <label for="nombre"><?getString("new_party");?><input tabindex="1" type="text" name="nombre"></label><br>
        <label for="antiguedad"><?getString("min_days_to_vote");?><input tabindex="1" type="text" name="ant"></label><br>
        <label for="frecuencia"><?getString("elections_frequency");?><input tabindex="1" type="text" name="frec"></label><br>
        <input type="submit">
    </form>
</div><!--form de creacion de partidos-->
