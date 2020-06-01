<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_POST['body'])){
        exit();
    } else {
        $user_id = $_SESSION['user'];
        $filter = [ '_id' => $user_id ];
        $query = new MongoDB\Driver\Query($filter);
        $result = $manager->executeQuery('pinng.users', $query);
        $userData = $result->toArray()[0];
        $body = $_POST['body'];
        date_default_timezone_set("Asia/Kolkata");
        $timestamp = date('Y-m-d H:i:s');
        
        $bulk = new MongoDB\Driver\BulkWrite(['ordered' => true]);
        $bulk->insert([ 
            'author_id' => $user_id, 
            'author_name' => $userData->firstName.' '.$userData->lastName, 
            'body' => $body, 
            'timestamp' => $timestamp 
        ]);
        $result = $manager->executeBulkWrite('pinng.pinngs', $bulk);
        header('location: home.php');
    }

?>