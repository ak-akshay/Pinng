<?php

include('config.php');
include('dbconnect.php');
$login_button = '';

if(isset($_GET['code'])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        if(!empty($data['email'])) {
            $email = $data['email'];
            $filter = ['email' => $email];
            $query = new MongoDB\Driver\Query($filter);
            $result = $manager->executeQuery('pinng.users', $query);
            $data = $result->toArray();
            if(!empty($data)) {
                $_SESSION['user'] = $data[0]->_id;
                header('location: index.php');
            } else {
                $first_name = $data['givenName'];
                $last_name = $data['familyName'];
                $bulk = new MongoDB\Driver\BulkWrite(['ordered' => true]);
                $bulk->insert([ 'email' => $email, 'firstName' => $first_name, 'lastName' => $last_name ]);
                $result = $manager->executeBulkWrite('pinng.users', $bulk);
                $filter = ['email' => $email, 'password' => $password];
                $query = new MongoDB\Driver\Query($filter);
                $result = $manager->executeQuery('pinng.users', $query);
                $data = $result->toArray();
                $_SESSION['user'] = $data[0]->_id;
                header('location: index.php');
            }
        }
    }
}

if(!isset($_SESSION['access_token'])) {
    $login_button = '<a href="'.$google_client->createAuthUrl().'">
    <img class="img-fluid google-img-btn mx-auto d-block mt-3 shadow border rounded" src="images/sign-in-with-google.png">
    </a>';
}

?>