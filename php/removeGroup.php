<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();    
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get the current user from session
    $user = $_SESSION['user'];
    
    // Get groupID from post
    $groupID = $_POST['groupID'];
    
    // Create group object
    $group = new Group($groupID);

    // Delete group
    $group->deleteGroup();

    // Remove the group from the logged in user's group list
    $user->removeGroup($groupID);
?>