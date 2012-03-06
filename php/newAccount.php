<?php
	// MySQL info
	/*
	$host = "pluto.cse.msstate.edu";
	$sqlusername = "dcspg33";
	$sqlpassword = "licepill47";
	$db_name = "dcspg33";
	$tbl_name = "users";
	*/
	
	$host = "localhost";
	$sqlusername = "root";
	$sqlpassword = "root";
	$db_name = "Esquire";
	$tbl_name = "users";
	
	// Connect to server and database
	mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name") or die("Database does not exist");

	// Get values from new account form
	$email = $_POST['email'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$password = $_POST['password'];
	$phoneNum = $_POST['phoneNum'];
	$carrier = $_POST['carrier'];
	//$textUpdates = $_POST['textUpdates'];
	//$emailUpdates = $_POST['emailUpdates'];
	
	$textUpdates = ' ';
	$emailUpdates = ' ';

	
	// Switch case for different carriers. Phone email is constructed by using the phone
	// number plus a designated address.
	switch ($carrier)
	{
	case "Verizon":
		$phoneEmail = $phoneNum . "@vtext.com";
		break;
	
	case "AT&T":
		$phoneEmail = $phoneNum . "@txt.att.net";
		break;
	
	case "T-Mobile":
		$phoneEmail = $phoneNum . "@tmomail.net";
		break;
	default:
		$phoneEmail = ' ';
		break;
	}	
	
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);
	$firstName = mysql_real_escape_string($firstName);
	$lastName = mysql_real_escape_string($lastName);
	$phoneNum = mysql_real_escape_string($phoneNum);
	$phoneEmail = mysql_real_escape_string($phoneEmail);
	$textUpdates = mysql_real_escape_string($textUpdates);
	$emailUpdates = mysql_real_escape_string($emailUpdates);
	
	// Check if email already exists in DB
	$result = mysql_query("SELECT * FROM $tbl_name WHERE email = '$email'") or die("could not query" . mysql_error());
	
	if (mysql_num_rows($result) > 0){
	    echo "exists";
	}
	
    else {
    	// Construct SQL query to add new user
    	$sql = "INSERT INTO users (email, firstName, lastName, password, phoneNum, phoneEmail, textUpdates, emailUpdates) VALUES ('$email', '$firstName', '$lastName', '$password', '$phoneNum', '$phoneEmail', '$textUpdates', '$emailUpdates')";
    		
    	// Add user to database
    	mysql_query($sql) or die("Could not query: " . mysql_error());
    	
    	// Direct to account created notification
    	//header("location:created.html");
	}
?>