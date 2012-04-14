<?php

    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
	
	// Connect to database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get group from session and get groupID
    $group = $_SESSION['group'];
    $groupID= $group->getGroupID();
    
    // Get new info for the group
    $name = $_POST['editGroupName'];
    $description = $_POST['editGroupDescription'];
    
    // Function to test for empty fields
    function emptyFieldsTest($name, $description){
        return ($name == "" || $description =="");
    }
    
    // Test for empty fields 
    if (emptyFieldsTest($name, $description)){
        echo "blankError";
    }
    
    // If everything is valid then edit the group info
    else{
        $sql = "UPDATE groups SET name='$name', description='$description' WHERE groupID='$groupID'";
        mysql_query($sql) or die("Could not query: " . mysql_error());
    }
?>