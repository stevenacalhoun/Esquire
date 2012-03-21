<?php
    // Pull in necessary files and start session
    require_once("groupClass.php");
    require_once("db_setup.php");
    require_once("userClass.php");
    session_start();
    
    // Connect to database and select table
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get groupID from get request and strip everything but the number
    $groupID = str_replace("groupDelete", "", $_GET["groupID"]);
    $group = new groupClass($groupID);
    
    // Get the members from the group
    $members = $group->getMembers();
    
    // Remove all the members of the group first
    foreach($members as $member){
        $sql = "DELETE FROM member_of WHERE groupID = '$groupID'";
        mysql_query($sql) or die("could not delete some member " . msql_error());
    }
    
    // Remove the group itself
    $sql = "DELETE FROM groups WHERE groupID = '$groupID'";
    mysql_query($sql) or die("could not delete group: " . mysql_error());
    
    // Remove the group from the logged in user's group list
    $user = $_SESSION['user'];
    $user->removeGroup($groupID);
    
    // Redirect back to groups page
    header("Location: ../groups.php");
?>