<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();
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