                    <div id="crear_pais">
                        <form action="../politico/crear_pais.php" method="POST">
                            <h2><? getString("new_country");?></h2>
                            <label for="nombre"><? getString("country_name");?><input tabindex="1" type="text" name="name"></label><br>
                            <label for="moneda"><? getString("currency_name");?><input tabindex="1" type="text" name="moneda"></label><br>
                            <input type="submit">
                        </form>
                    </div><!--form de creacion de pais-->
