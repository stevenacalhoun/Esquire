<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("../classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get the current user from session
    $user = $_SESSION['user'];

    // Get groupID and create group object
    $groupID = $_POST["groupID"];
    $group = new Group($groupID);
    
    // Get email of the member to be removed
    $email = $_POST["email"];

    // Delete the member
    $group->deleteMember($email);
?>