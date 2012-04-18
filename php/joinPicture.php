<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get user 
    $user = $_SESSION['user'];
    
	
	// Connect to database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");

	// Change the name of the file
	$_FILES['profileImage']['name'] = $user->getEmail();
		
	// Make the path for it to be stored in
	$path = "../profileImages/".$user->getEmail() . ".png";
	
	if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $path)){
	    header('Location:../groups.php');
	}
	
?>