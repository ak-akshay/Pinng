<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_SESSION['user'])) {
        header('location: login.php');
    }
    if(!isset($_GET['id'])) {
        header('location: login.php');
    }

    $filter = [ '_id' => $_SESSION['user'] ];
    $query = new MongoDB\Driver\Query($filter);
    $result = $manager->executeQuery('pinng.users', $query);
    $userData = $result->toArray()[0];
    
    $profile_id = $_GET['id'];
    $filter = [ '_id' => new MongoDB\BSON\ObjectID($profile_id) ];
    $query = new MongoDB\Driver\Query($filter);
    $result = $manager->executeQuery('pinng.users', $query);
    $profileData = $result->toArray()[0];

    function getRecentPinngs($manager) {
        $id = $_GET['id'];
        $filter = [ 'author_id' => new MongoDB\BSON\ObjectID($id) ];
        $query = new MongoDB\Driver\Query($filter, [ 'sort' => ['timestamp' => -1] ]);
        $result = $manager->executeQuery('pinng.pinngs', $query);
        $recent_pinngs = $result->toArray();
        return $recent_pinngs;
    }

    function isFollowing($manager) {
        $filter = [ 'follower' => new MongoDB\BSON\ObjectID($_SESSION['user']), 'user' => new MongoDB\BSON\ObjectID($_GET['id']) ];
        $query = new MongoDB\Driver\Query($filter);
        $result = $manager->executeQuery('pinng.following', $query);
        $result = $result->toArray();
        return empty($result);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile: <?php echo $profileData->firstName.' '.$profileData->lastName ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css">
    <script src="node_modules\jquery\dist\jquery.min.js"></script>
    <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9 mt-5">
                <div class="sticky-top bg-white" style="top: 5rem; z-index: 50;">
                    <div class="display-4">
                        <?php echo $profileData->firstName.' '.$profileData->lastName ?>'s Pinngs
                        <?php
                            if($_SESSION['user'] != $_GET['id']) {
                                if(isFollowing($manager)) {
                                    echo '<a class="btn btn-outline-success rounded-pill float-right mt-3" href="follow.php?id='.$_GET['id'].'&return_address=profile">Follow</a>';
                                } else {
                                    echo '<span class="text-success text-size-m float-right mt-3">Following</span>';
                                }
                            }
                        ?>
                    </div>
                    <hr>
                </div>
                <?php
                    $recent_pinngs = getRecentPinngs($manager);
                    if(!empty($recent_pinngs)){
                        foreach($recent_pinngs as $pinng) {
                            $time = '';
                            date_default_timezone_set("Asia/Kolkata");
                            $diff = date_diff(date_create(date('Y-m-d H:i:s')), date_create($pinng->timestamp));
                            if($diff->h == 0) {
                                $time = $diff->i.' minute(s) ago';
                            } elseif($diff->d < 1) {
                                $time = $diff->h.' hour(s) ago';
                            } else {
                                $time = $pinng->timestamp;
                            }
                            echo '<div class="card border-0">';
                            echo '<div class="card-body border-bottom">';
                            echo '<p class="card-text pinng-body">'.$pinng->body.'</p>';
                            if($_SESSION['user'] == $profileData->_id) {
                                echo '<form action="delete_pinng.php" method="post">
                                <input type=text name="delete" class="d-none" value="'.$pinng->_id.'">
                                <button class="btn btn-outline-danger float-right ml-4" type="submit">
                                <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                </button>
                                </form>';
                            }
                            echo '<span class="card-title float-right">
                                <p class="card-subtitle text-muted" style="font-size: 1.2em;">'.$time.'</p>
                            </span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="lead mt-5">No pinngs found!</p>';
                    }
                ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
</html>