<?php

    session_start();
    if(!isset($_SESSION['user'])){
        header('location: index.php');
    }
    
    include('config.php');
    if(isset($token)) {$google_client->revokeToken();}

    unset($_SESSION['user']);
    session_unset();
    session_destroy();
    header('location: index.php');
    exit;

?>