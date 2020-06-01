<?php

    $navbar = 
    '<nav class="navbar navbar-expand-lg navbar-light bg-success sticky-top">
    <a class="navbar-brand" href="index.php"><span class="home-link">My P!nng</span></a>
    <div>
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
          <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
          <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.6)" />
          <use xlink:href="#gentle-wave" x="48" y="2" fill="rgba(255,255,255,0.4)" />
          <use xlink:href="#gentle-wave" x="48" y="4" fill="rgba(255,255,255,0.2)" />
        </g>
      </svg>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-text pt-3" href="profile.php?id='.$_SESSION['user'].'">My profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text pt-3" href="userlist.php">All users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text pt-3" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>';

  echo $navbar;

?>