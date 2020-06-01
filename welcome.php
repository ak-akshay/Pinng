<?php

    session_start();
    require_once('dbconnect.php');
    $loginerr = '';
    $registererr = '';
    if(isset($_GET['errcode'])){
        if($_GET['errcode']==1) {
            $loginerr = '<p class="alert alert-danger">No such user registered!</p>';
        } elseif($_GET['errcode']==2) {
            $loginerr = '<p class="alert alert-danger">Email or password do not match!</p>';
        }elseif($_GET['errcode']==3) {
            $registererr = '<p class="alert alert-danger">User already registered! Try logging in.</p>';
        }
    }
    
    if(isset($_GET['loginerr'])){
        $registererr = $_GET['registererr'];
    }

    // ----------Login with Google-----------------
    include('google_login.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to P!nng</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css">
    <!-- <script src="node_modules\jquery\dist\jquery.min.js"></script>
    <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script> -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-bg">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="index.php" style="width: max-content;">
            <img src="images/pinng-logo.png" height="50em" width="50em">
        </a>
        <span class="text-success display-4" style="font-family: 'Neuton', serif;">P!nng</span>
        <div>
            <svg class="waves-login" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(0, 153, 51, 0.2)" />
                    <use xlink:href="#gentle-wave" x="48" y="2" fill="rgba(0, 230, 77, 0.2)" />
                    <use xlink:href="#gentle-wave" x="48" y="4" fill="rgba(102, 255, 153, 0.2)" />
                </g>
            </svg>
        </div>
    </nav>
    <?php echo $login_button; ?>
    <div class="container-sm">
        <div class="row no-gutters">
        <div class="col-md-4 mt-4 p-3 form-div mx-auto rounded">
            <form id="login_form" method="POST" action="login.php">
                <fieldset>
                    <legend>Login</legend>
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="bi bi-envelope-fill" width="2em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                            </span>
                        </div>
                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="bi bi-lock-fill" width="2em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="11" height="9" x="2.5" y="7" rx="2"/>
                                    <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                </svg>
                            </span>
                        </div>
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>   
                    <button class="btn btn-success rounded-pill" type="submit">Login</button>
                </fieldset>        
            </form>
            <br><?php echo $loginerr; ?>
        </div>
        <div class="col-md-5 mt-4 p-3 form-div mx-auto rounded">
            <form id="register_form" method="POST" action="register.php">
                <fieldset>
                    <legend>Register</legend>
                    <input class="form-control mb-3 bg-transparent border-success" type="text" name="first_name" placeholder="First Name" required>
                    <input class="form-control mb-3 bg-transparent border-success" type="text" name="last_name" placeholder="Last Name" required>
                    <input class="form-control mb-3 bg-transparent border-success" type="email" name="email" placeholder="Email" required>
                    <input class="form-control mb-3 bg-transparent border-success" type="password" name="password" placeholder="Password" required>
                    <button class="btn btn-success rounded-pill" type="submit">Register</button>
                </fieldset>        
            </form>
            <br><?php echo $registererr; ?>
        </div>
        </div>
    </div>
</body>
</html>