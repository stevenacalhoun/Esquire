<?php
    // Start session and bring in DB info
	session_start();
	require_once("classFiles/db_setup.php");
	
	// Connectdatabase
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");
	
	// Get email and password from form
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Construct query from input and query database
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysql_query($sql);
	$resultArray = mysql_fetch_array($result);
	
	// Get encrytped password and cipher
	$encryptedPassword = $resultArray['password'];
	$cipher = $resultArray['cipher'];
	
	// Make password object and decrypt
	$passwordObject = new Password($encryptedPassword);
	$decryptedPassword = $passwordObject->decrypt($cipher);
	
	// Count num of rows that satifies the request
	$count = mysql_num_rows($result);
	
	// If count is 1 then the pair is correct and store the object to the seession
	if ($count == 1 && $password == $decryptedPassword)
	{
	    // Add user object to the session and return success for login
        $user = new User($email);
        $_SESSION['user'] = $user;
        echo "success";
	}
	
	// Otherwise present error
	else
	{
		echo "Wrong username or password";
	}
?>