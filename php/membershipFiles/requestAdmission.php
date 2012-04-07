<?php

    // Pull in necessary files and start session
    require_once("/../classFiles/db_setup.php");
    session_start();
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Get the current user from session
    $user = $_SESSION['user'];
    
    // Get group from POST
    $groupID = $_POST['groupID'];
    
    // User request invite    
    $user->requestAdmission($groupID);  
    
    echo $_SESSION['search']; 
?>