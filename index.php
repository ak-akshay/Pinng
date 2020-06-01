<?php

    session_start();
    if(isset($_SESSION['user'])) {
        header('location:home.php');
    } else {
        header('location:welcome.php');
    }

?>