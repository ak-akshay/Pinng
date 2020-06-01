<?php

    session_start();
    require_once('dbconnect.php');

    if(isset($_SESSION['user'])) {
        header('location: home.php');
    }

    // -----------Register New User--------------------
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $filter = ['email' => $email];
        $query = new MongoDB\Driver\Query($filter);
        $result = $manager->executeQuery('pinng.users', $query);
        if(!empty($result->toArray())) {
            header('location: welcome.php?errcode=3');
        } else {
            $bulk = new MongoDB\Driver\BulkWrite(['ordered' => true]);
            $bulk->insert(['email' => $email, 'firstName' => $first_name, 'lastName' => $last_name, 'password' => $password]);
            $result = $manager->executeBulkWrite('pinng.users', $bulk);
            
            // Logging in new user
            $filter = ['email' => $email, 'password' => $password];
            $query = new MongoDB\Driver\Query($filter);
            $result = $manager->executeQuery('pinng.users', $query);
            $data = $result->toArray();
            $_SESSION['user'] = $data[0]->_id;
            header('location: home.php');
        }
    }

?>