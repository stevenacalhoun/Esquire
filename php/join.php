<?php

    // Start session and bring in DB info    
    session_start();
    require_once("db_setup.php");
    $tbl_name = "users";

	
	// Connect to server and database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");

	// Get values from new account form
	$email = $_POST['email'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$password = $_POST['password'];
	$passwordConfirm = $_POST['confirmPassword'];
	$phoneNum = $_POST['phoneNum'];
	$carrier = $_POST['carrier'];
	$textUpdates = $_POST['texts'];
	$emailUpdates = $_POST['emails']; 
	
	// Functions for validation
	function validateEmail($email){
	    return (ereg("^[a-zA-Z0-9]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$", $email));
	}
	function validatePassword($password){
	    return (strlen($password) > 5);
	}
	function validatePassword2($password, $password2){
	    return ($password == $password2);
    }
    function emailExistence($email){
        return (mysql_num_rows(mysql_query("SELECT * FROM users WHERE email = '$email'")) <= 0);
    }

	
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
      
	// Check if email is a valid email
	if (!validateEmail($email)){
	    echo ("emailError");
	}
	
	// Check if password is a valid password
	if (!validatePassword($password)){
	    echo ("passwordError");
	}
	
	// Check if passwords are the same
	if (!validatePassword2($password, $passwordConfirm)){
	    echo ("passwordMatchError");
	}
	
	// Check if email already exists in DB
	if (!emailExistence($email)){
	    echo ("exists");
	}
	
	// If all the inputs are valid then they can be submitted to the DB
    if (validateEmail($email) AND validatePassword($password) AND validatePassword2($password, $passwordConfirm) AND emailExistence($email)){
    	
    	// Construct SQL query to add new user
    	$sql = "INSERT INTO users (email, firstName, lastName, password, phoneNum, phoneEmail, textUpdates, emailUpdates) VALUES ('$email', '$firstName', '$lastName', '$password', '$phoneNum', '$phoneEmail', '$textUpdates', '$emailUpdates')";

    	// Add user to database
    	mysql_query($sql) or die("Could not query: " . mysql_error());
    	
    	// Add info to session 
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
    }
    mysql_close($con);
?>