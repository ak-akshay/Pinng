<?php

    require_once('vendor/autoload.php');

    $google_client = new Google_Client();
    $google_client->setClientId('231764296941-qht2ajdmlv9b72hkm5tn0d7dvh21esnq.apps.googleusercontent.com');
    $google_client->setClientSecret('X6_mJtV1Vkotvj3ypT4tJcIi');

    $google_client->setRedirectUri('http://localhost/pinng/welcome.php');

    $google_client->addScope('email');
    $google_client->addScope('profile');

?>