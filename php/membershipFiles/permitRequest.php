<?php
    // Pull in necessary files and start session
    require_once("../classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Connect to the database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get the current user from session
    $user = $_SESSION['user'];
    
    // Get group and email from POST
    $groupID = $_POST["groupID"];
    $email = $_POST['emailToBePermitted'];
    
    // Creat group object and permit the member
    $group = new Group($groupID);
    $group->permitRequest($email);
?>