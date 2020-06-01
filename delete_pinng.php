<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_POST['delete'])){
        exit();
    } else {
        $id = new MongoDB\BSON\ObjectID($_POST['delete']);
        $bulk = new MongoDB\Driver\BulkWrite(['ordered' => true]);
        $bulk->delete(['_id' => $id]);
        $result = $manager->executeBulkWrite('pinng.pinngs', $bulk);
        header('location: profile.php?id='.$_SESSION['user']);
    }

?>