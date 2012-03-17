<?php

    // Start session and bring in DB info
	session_start();
	require_once("db_setup.php");
	require_once("userClass.php");
    $tbl_name = "users";
	
	// Connect to server and database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");
	
	// Get email and password from form
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Construct query from input and query database
	$sql = "SELECT * FROM $tbl_name WHERE email = '$email' and password = '$password'";
	$result = mysql_query($sql);
	
	// Count num of rows that satifies the request
	$count = mysql_num_rows($result);
	
	// If count is 1 then the pair is correct and store them to the seession
	if ($count == 1)
	{
        $userRow = mysql_fetch_array($result);
        $groupsIDs = mysql_query("SELECT groupID FROM member_of WHERE email = '$email'");
        while($ID = mysql_fetch_array($groupsIDs)){
            $groups[] = $ID['groupID'];
        }
        
        $user = new userClass($userRow['firstName'], $userRow['lastName'], $userRow['email'], $userRow['phoneEmail'], $userRow['password'], $groups);
        $_SESSION['user'] = $user;
        echo "success";
	}
	
	// Otherwise present error
	else
	{
		echo "Wrong username or password";
	}
	mysql_close($con);
?>