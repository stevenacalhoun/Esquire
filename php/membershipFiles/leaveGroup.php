<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("../classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get user object and groupID
    $user = $_SESSION['user'];
    $groupID = $_POST['groupID'];

    // Create group object
    $group = new Group($groupID);
    
    // Remove the member
    $group->deleteMember($user->getEmail());
    
    // Remove group from logged in user's groups list
    $user->removeGroup($groupID);
?>