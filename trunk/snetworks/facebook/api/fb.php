<?php
include_once 'facebook-php/src/facebook.php';

class fb {
    private $api_key;
    private $secret_key;
    private $facebook;

    function __construct($api_key, $secret_key) {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;

        $this->facebook = new Facebook($api_key,$secret_key);
    }


}
?>
