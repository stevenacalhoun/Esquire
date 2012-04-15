<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("../classFiles/db_setup.php");
    session_start();
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
?>