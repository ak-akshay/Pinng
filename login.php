<?php

    session_start();
    require_once('dbconnect.php');

    if(isset($_SESSION['user'])) {
        header('location: home.php');
    }
    
    // ----------------Registered Login------------------
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $filter = ['email' => $email];
        $query = new MongoDB\Driver\Query($filter);
        $result = $manager->executeQuery('pinng.users', $query);
        if(empty($result->toArray())) {
            header('location: welcome.php?errcode=1');
        } else {
            $filter = ['email' => $email, 'password' => $password];
            $query = new MongoDB\Driver\Query($filter);
            $result = $manager->executeQuery('pinng.users', $query);
            $data = $result->toArray();
            if(empty($data)) {
                header('location: welcome.php?errcode=2');
            } else {
                $_SESSION['user'] = $data[0]->_id;
                header('location: home.php');
            }
        }
    }

?>