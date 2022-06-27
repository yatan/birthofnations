<?php
if (isset($_POST['nick'])) {
    header('location: /' . $_GET['lang'] . '/buscador/' . $_POST['nick'] . '/0');
    exit();
}
