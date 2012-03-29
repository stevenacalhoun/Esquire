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
    
    // Get the current user from session
    $user = $_SESSION['user'];
    
    // Get groupID from get request and strip everything but the number
    $groupID = str_replace("groupDelete", "", $_POST["groupID"]);
    $group = new groupClass($groupID);

    // Delete group
    $group->deleteGroup();

    // Remove the group from the logged in user's group list
    $user->removeGroup($groupID);
?>