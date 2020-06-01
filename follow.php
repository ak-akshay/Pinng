<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_GET['id'])){
        exit;
    }
    
    $user_id = $_GET['id'];
    $follower_id = $_SESSION['user'];

    $bulk = new MongoDB\Driver\BulkWrite(['ordered' => true]);
    $bulk->insert([
        'user' => new MongoDB\BSON\ObjectID($user_id),
        'follower' => new MongoDB\BSON\ObjectID($follower_id)
    ]);
    $result = $manager->executeBulkWrite('pinng.following',$bulk);
    if(isset($_GET['return_address'])) {
        header('location: profile.php?id='.$user_id);
    } else {
        header('location: userlist.php');
    }

?>