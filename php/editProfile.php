<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("userClass.php");
    require("groupClass.php");
    require_once("db_setup.php");
    session_start();
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    $user = $_SESSION['user'];
    $email = $user->getEmail();
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['confirmPassword'];
    $phoneNum = $_POST['phoneNum'];
    $carrier = $_POST['carrier'];
    $textUpdates = $_POST['texts'];
    $emailUpdates = $_POST['emails']; 
    
    // Determine boolean values for update options
    if ($textUpdates == "textYes"){$textUpdates = true;}
    if ($emailUpdates == "emailYes"){$emailUpdates = true;}
    
    // Functions for validation
    function validatePassword($password){
        return (strlen($password) > 5);
    }
    
    function validatePassword2($password, $password2){
        return ($password == $password2);
    }
    
    function emptyFieldsTest($firstName, $lastName, $phoneNum){
        return ($firstName == '' || $lastName == '' || $phoneNum == '');
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

    // Check if password is a valid password
    if (!validatePassword($password)){
        echo ("passwordError");
    }
    
    // Check if passwords are the same
    if (!validatePassword2($password, $passwordConfirm)){
        echo ("passwordMatchError");
    }
        
    if (emptyFieldsTest($firstName, $lastName, $phoneNum)){
        echo ("blankError");
    }
    
    if(validatePassword($password) AND validatePassword2($password, $passwordConfirm) AND !emptyFieldsTest($firstName, $lastName, $phoneNum)){
    
    	$sql = "UPDATE users SET firstName='$firstName', lastName='$lastName', password='$password', phoneNum='$phoneNum', phoneEmail='$phoneEmail', textUpdates='$textUpdates', emailUpdates='$emailUpdates' WHERE email='$email'";
    	
    	mysql_query($sql) or die ("Couldn't query" . mysql_error());
    	$user = new userClass($user->getEmail());
    	$_SESSION['user'] = $user;
    }
    
?>