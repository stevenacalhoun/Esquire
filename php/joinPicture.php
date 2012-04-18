<?php
    // Start session and bring in DB info    
    require_once("classFiles/db_setup.php");
    session_start();
	
	// Connect to database
	$con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
	mysql_select_db("$db_name", $con) or die("Database does not exist");

	$image = $_FILES['profileImage']['name'];
	$profileImageFolder = $profileImageFolder . basename( $_FILES['profileImage']['name']);
	
	$_FILES['profileImage']['name'] = $email;
	
	echo $_FILES['profileImage']['name'];
	
	$path = "../profileImages".$email . ".png";
	
	if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $path)){
	    echo 'hot damn';
	}
	else {echo 'mother';}
    
    

?>