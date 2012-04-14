<?php
    // Start session and bring in DB info    
    require_once("classFiles/db_setup.php");
    session_start();
	
	// Connect to database
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
	
//	$image = $_FILES['profileImage']['name'];
//	$profileImageFolder = $profileImageFolder . basename( $_FILES['profileImage']['name']);
//	$_FILES['profileImage']['name'] = $email;
//	echo $_FILES['profileImage']['name'];
//	$path = "../profileImages".$email . ".png";
//	if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $path)){
//	    echo 'hot damn';
//	}
//	else {echo 'mother';}
	
	// Determine boolean values for update options
	if ($textUpdates == "textYes"){$textUpdates = true;}
	if ($emailUpdates == "emailYes"){$emailUpdates = true;}
	
	/** Functions for validation **/
	
	// Validate email
	function validateEmail($email){
	    return (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email));
	}
	
	// Validate password
	function validatePassword($password){
        $regex  = "/^[a-z0-9]{5,18}$/";
        return preg_match($regex, $password);
	}
	
	// Make sure the passwords match
	function validatePassword2($password, $password2){
	    return ($password == $password2);
    }
    
    // Make sure that email isn't already registered
    function emailExistence($email){
        return (mysql_num_rows(mysql_query("SELECT * FROM users WHERE email = '$email'")) <= 0);
    }
    
    // Make sure none of the files are empty
    function emptyFieldsTest($firstName, $lastName, $phoneNum){
        return ($firstName == '' || $lastName == '' || $phoneNum == '');
    }

	
	// Switch case for different carriers. Phone email is constructed by using the phone number plus a designated address.
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
	
	// Check if any fields are empty
	if (emptyFieldsTest($firstName, $lastName, $phoneNum)){
	    echo ("blankError");
	}
	
	
	// If all the inputs are valid then they can be submitted to the DB
    if(validateEmail($email) AND validatePassword($password) AND validatePassword2($password, $passwordConfirm) AND emailExistence($email) AND !emptyFieldsTest($firstName, $lastName, $phoneNum)){
    	// Encrypt password
    	$passwordObject = new Password($password);
    	$encryptedPassword = $passwordObject->encrypt();
    	$cipher = $passwordObject->getDefaultCipher();
    	
    	// Construct SQL query and query the database
    	$sql = "INSERT INTO users (email, firstName, lastName, password, phoneNum, phoneEmail, textUpdates, emailUpdates, cipher) VALUES ('$email', '$firstName', '$lastName', '$encryptedPassword', '$phoneNum', '$phoneEmail', '$textUpdates', '$emailUpdates', '$cipher')";
    	mysql_query($sql) or die("Could not query: " . mysql_error());
    	
    	// Echo success
    	echo "success";
    	
    	// Create user object and add to Session
    	$user = new User($email);
    	$_SESSION['user'] = $user;
    	
    	// If the new user desires email updates send an email welcoming to Esquire
    	if ($emailUpdates){
        	$message = "Hello $firstName $lastName, welcome to Esquire";    	
        	$mail = new PHPMailer();
        	$mail->IsSMTP();
        	$mail->Host = "cse.msstate.edu";
        	$mail->SMTPDebug = 0;
        	$mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
        	$mail->Subject = "Welcome to Esquire";
        	$mail->Body = $message;
        	$address = $email;
        	$mail->AddAddress($address, "$firstName $lastName");
        	$mail->Send();
        }
    }
    
    // Close DB connection
    mysql_close($con);
?>