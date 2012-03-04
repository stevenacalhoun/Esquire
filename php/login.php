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
	
	// Get email and password from form
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Strip inputs and query database
	$email = stripslashes($email);
	$password = stripslashes($password);
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);
	
	$sql = "SELECT * FROM $tbl_name WHERE email = '$email' and password = '$password'";
	$result = mysql_query($sql);
	
	// Count num of rows that satifies the request
	$count = mysql_num_rows($result);
	
	// If count is 1 then the pair is correct
	if ($count == 1)
	{
		session_register("email");
		session_register("password");
		header("location:groups.html");
	}
	
	// Otherwise redirect to login
	else
	{
		//header("index.html");
		echo "It works!";
	}
?>