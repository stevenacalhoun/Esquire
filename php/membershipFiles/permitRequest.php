<?php
    // Pull in necessary files and start session
    require_once("../classFiles/db_setup.php");
    session_start();
    
    // Connect to the database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get the current user from session
    $user = $_SESSION['user'];
    
    // Get group from POST and accept invitation
    $groupID = $_POST["groupID"];
    $email = $_POST['emailToBePermitted'];
    $group = new Group($groupID);
    $group->permitRequest($email);
?>