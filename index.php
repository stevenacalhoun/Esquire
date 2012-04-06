<!DOCTYPE html>
<?php 
    // Destroy any session info that may be leftover to ensure login
    require_once("php/db_setup.php");
    session_start();
    session_destroy();
    date_default_timezone_set('America/Chicago');
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    $phpDate = date($dateFormat);
    $mySQLDate = strtotime($phpDate);
    
    $sql = "INSERT INTO posts (email, groupID, message, dateTime, flag) VALUES (email, 1, message, $mySQLDate, 0)";
    mysql_query($sql) or die(mysql_error()); 
    
    $result = mysql_query("SELECT dateTime FROM posts WHERE groupID=1") or die(mysql_error());
    $dateArray = mysql_fetch_array($result);
    
    $date = $dateArray['dateTime'];
    $phpdate = date($dateFormat, $date);    
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>
	
	<!-- Main Box -->
	<div id="loginBox" class="box">
		<div id="loginTitle"></div>
		<form action="php/login.php" method="post" id="loginForm">
			<input type="text" name="email" placeholder="email" id="loginEmail" />
			<input type="password" name="password" placeholder="password" id="loginPassword" />
			<input type="submit" value="Login" id="loginButton" class="button" />
		</form>
		<a href="join.html"><div id="joinButton" class="button green">Join</div></a>
		<div id="reset">Forgot password?</div>
	</div>
	
	<!-- Error messages -->
	<div id="loginError" class="error">Wrong Username/Password Combination.</div>
	
	<div class="secondaryFooter">&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</div>
</body>
</html>
