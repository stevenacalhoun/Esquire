<?php
    // Pull in necessary files and start session
    require_once("groupClass.php");
    require_once("userClass.php");
    session_start();
    
    // Get user object and groupID
    $user = $_SESSION['user'];
    $groupID = $_GET['groupID'];
    $groupID = str_replace("http://esquire.dev/specificGroup.php?groupID=", "", $groupID);

    // Create group object
    $group = new groupClass($groupID);
    
    // Remove the member
    $group->deleteMember($user->getEmail());
    
    // Remove group from logged inuser's groups list
    $user->removeGroup($groupID);
    
    // Redirect back to groups page
    header("Location: ../groups.php");
    

?>