<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_SESSION['user'])) {
        header('location: login.php');
    }
    
    $filter = [ '_id' => $_SESSION['user'] ];
    $query = new MongoDB\Driver\Query($filter);
    $result = $manager->executeQuery('pinng.users', $query);
    $userData = $result->toArray()[0];

    function getUsersList($manager) {
        $query = new MongoDB\Driver\Query([]);
        $result = $manager->executeQuery('pinng.users', $query);
        $users = $result->toArray();
        return $users;
    }

    $query = new MongoDB\Driver\Query([ 'follower' => $_SESSION['user'] ]);
    $result = $manager->executeQuery('pinng.following', $query);
    $result = iterator_to_array($result);
    $user_following = array();
    foreach($result as $entry) {
        array_push($user_following, $entry->user);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ping: Users</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css">
    <script src="node_modules\jquery\dist\jquery.min.js"></script>
    <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="sticky-top bg-white" style="top: 5rem; z-index: 50;">
                        <h2 class="display-4">List of Users</h2>
                        <hr class="border-success">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-borderless table-hover table-responsive-sm">
                        <tbody>
                            <?php
                                $users_list = getUsersList($manager);
                                foreach($users_list as $user) {
                                    echo '<tr>';
                                    echo '<td class="lead">'.$user->firstName.' '.$user->lastName.'</td>';
                                    echo '<td><a class="lead text-success" href="profile.php?id='.$user->_id.'">'.$user->email.'</a></td>';
                                    if(in_array($user->_id, $user_following)) {
                                        echo '<td class="text-success">Following</td>';
                                    } elseif($_SESSION['user'] == $user->_id)  {
                                        echo '<td></td>';
                                    } else {
                                        echo '<td><a class="btn btn-outline-success rounded-pill" href="follow.php?id='.$user->_id.'">Follow</a></td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>