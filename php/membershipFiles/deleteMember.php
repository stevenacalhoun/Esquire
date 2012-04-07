<?php
    // Pull in necessary files and start session
    require_once("../classFiles/db_setup.php");
    session_start();
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get the current user from session
    $user = $_SESSION['user'];

    // Get groupID from get request and strip everything but the number
    $groupID = str_replace("specificGroup", "", $_POST["groupID"]);
    $group = new Group($groupID);
    
    // Get email of the member to be removed
    $email = str_replace("specificGroup", "", $_POST["email"]);

    // Delete member
    $group->deleteMember($email);
?>