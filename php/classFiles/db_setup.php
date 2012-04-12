<?php

    // DB info for connecting
    $host = "localhost";
    $sqlusername = "root";
    $sqlpassword = "root";
    $db_name = "Esquire";

    date_default_timezone_set('America/Chicago');
    
    $dateFormat = "g:ia M j, Y";
    require_once("User.php");
    require_once("Group.php");
    require_once("Post.php");
    require_once("Password.php");
    
    $profileImageFolder = "profileImages/";
    
?>