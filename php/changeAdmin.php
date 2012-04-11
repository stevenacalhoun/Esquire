<?php
// Pull in necessary files and start session
    require_once("groupClass.php");
    require_once("db_setup.php");
    require_once("userClass.php");
    session_start();
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get groupID and email
    $email = $_POST['$email'];
    $groupID = $_POST['groupID'];
    
    // Create new group object
    $group = new groupClass($groupID);
    
    // Change admin
    $group->changeAdmin($email);
        
?>