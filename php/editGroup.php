<?php

    // Start session and bring in DB info    
    require_once("classFiles/db_setup.php");
    require_once('./lib/class.phpmailer.php');
    session_start();
    
    $tbl_name = "users";

	
	// Connect to server and database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    $group = $_SESSION['group'];
    $groupID= $group->getGroupID();
    $name = $_POST['editGroupName'];
    $description = $_POST['editGroupDescription'];
    
    function emptyFieldsTest($name, $description){
        return ($name == "" || $description =="");
    }
    
    if (emptyFieldsTest($name, $description)){
        echo "blankError";
    }
    
    else{
        $sql = "UPDATE groups SET name='$name', description='$description' WHERE groupID='$groupID'";
        mysql_query($sql) or die("Could not query: " . mysql_error());
    }
?>