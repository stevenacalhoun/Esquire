<?php
    // Pull in necessary files and start session
    require_once("classFiles/db_setup.php");
    session_start();
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get groupID and email
    $email = $_POST['email'];
    $groupID = $_POST['groupID'];
    
    // Create new group object
    $group = new Group($groupID);
    
    // Change admin
    $group->changeAdmin($email);
        
?>