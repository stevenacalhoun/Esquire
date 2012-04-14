<?php

    // DB info for connecting
    $host = "localhost";
    $sqlusername = "root";
    $sqlpassword = "root";
    $db_name = "Esquire";

    // Set timezone and date format for post times
    date_default_timezone_set('America/Chicago');
    $dateFormat = "g:ia M j, Y";
    
    // Pull in other required files
    require_once("User.php");
    require_once("Group.php");
    require_once("Post.php");
    require_once("Password.php");
    require_once("lib/class.phpmailer.php");
    
    
    $profileImageFolder = "profileImages/";
    
?>