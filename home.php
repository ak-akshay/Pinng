<?php

    session_start();
    require_once('dbconnect.php');

    if(!isset($_SESSION['user'])) {
        header('location: welcome.php');
    }
    
    $filter = [ '_id' => $_SESSION['user'] ];
    $query = new MongoDB\Driver\Query($filter);
    $result = $manager->executeQuery('pinng.users', $query);
    $userData = $result->toArray()[0];

    function getRecentPinngs($manager) {
        $query = new MongoDB\Driver\Query([ 'follower' => $_SESSION['user'] ]);
        $result = $manager->executeQuery('pinng.following', $query);
        $result = iterator_to_array($result);
        $user_following = array();
        foreach($result as $entry) {
            array_push($user_following, $entry->user);
        }
        $query = new MongoDB\Driver\Query([ 'author_id' => [ '$in' => $user_following ] ], [ 'sort' => ['timestamp' => -1] ]);
        $result = $manager->executeQuery('pinng.pinngs', $query);
        $recent_pinngs = $result->toArray();
        return $recent_pinngs;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pinng</title>
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
            <div class="col-md-8 mt-3">
                <div class="mb-3" id="pinng_form">
                    <form action="create_pinng.php" method="post">
                        <label for="pinng" class="text-size-p">Hey! What's cracking?</label><br>
                        <textarea class="border border-success rounded p-4" name="body" cols="70" rows="5" maxlength=1000 minlength=5 style="resize: none;" autofocus></textarea><br>
                        <button class="btn btn-success rounded-pill w-25" type="submit">P!nng</button>
                    </form>
                </div>
                <div>
                    <div class="sticky-top bg-white" style="top: 5rem; z-index: 50;">
                        <h2 class="display-4">News Feed</h2>
                        <hr class="border-success">
                    </div>
                    <?php
                        $recent_pinngs = getRecentPinngs($manager);
                        if(!empty($recent_pinngs)) {
                            foreach($recent_pinngs as $pinng) {
                                $badge = '';
                                $time = '';
                                date_default_timezone_set("Asia/Kolkata");
                                $diff = date_diff(date_create(date('Y-m-d H:i:s')), date_create($pinng->timestamp));
                                if($diff->h < 1) {
                                    $badge = '<span class="badge badge-primary">New</span>';
                                }
                                if($diff->y == 0 && $diff->m == 0 && $diff->d == 0 && $diff->h == 0) {
                                    $time = $diff->i.' minute(s) ago';
                                } elseif($diff->m == 0 && $diff->m == 0 && $diff->d == 0) {
                                    $time = $diff->h.' hour(s) ago';
                                } else {
                                    $time = $pinng->timestamp;
                                }
                                echo '<div class="card border-0">';
                                echo '<div class="card-body border-bottom">'.$badge;
                                echo '<span class="card-text pinng-body">'.$pinng->body.'</span>';
                                echo '<span class="card-title float-right">By 
                                <a class="text-success" href="profile.php?id='.$pinng->author_id.'">'.explode(" ", $pinng->author_name)[0].'</a>
                                <p class="card-subtitle text-muted">'.$time.'</p>
                                </span>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="lead mt-5">Pinngs from your followed users will appear here.</p>';
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="bg-success rounded-circle p-2 new-pinng-btn">
            <a class="text-white" href="home.php#" title="Got something to share">
                <svg class="bi bi-pencil-square" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
            </a>
        </div>
    </div>
</body>
</html>