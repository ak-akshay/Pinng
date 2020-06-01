<?php

    require_once('vendor/autoload.php');

    $google_client = new Google_Client();
    $google_client->setClientId('');        //GoogleAPI client id
    $google_client->setClientSecret('');    //GoogleAPI client secret

    $google_client->setRedirectUri('http://localhost/pinng/welcome.php');

    $google_client->addScope('email');
    $google_client->addScope('profile');

?>