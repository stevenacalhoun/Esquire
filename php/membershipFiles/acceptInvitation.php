<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("../classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Connect to the database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get the current user from session and group from POST
    $user = $_SESSION['user'];
    $groupID = $_POST["groupID"];
    
    // Accept the invitation
	$user->acceptInvitation($groupID);
?>