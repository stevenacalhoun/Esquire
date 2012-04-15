<!DOCTYPE html>
<?php 
    // Destroy any session info that may be leftover to ensure login
    require_once("php/classFiles/db_setup.php");
    session_start();
    session_destroy();
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/spinner.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>
	
	<!-- Overlay-->
	<div class="submitOverlay"></div>
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
		
		<!-- Reset Password Box -->
		<div id="resetBox">
			<form action="php/resetPassword.php" method="post" id="resetForm">
				<input type="text" name="resetEmail" placeholder="email" id="resetEmail" />
				<input type="submit" value="Reset" id="resetSubmit" class="button green" />
			</form>
			<div id="resetCancel" class="button">Cancel</div>
		</div>
		
		<!-- Error messages -->
		<div id="loginError" class="loginError">Wrong Username/Password Combination.</div>
		<div id="resetError" class="loginError">Email not found in Esquire.</div>
		<div id="resetSuccess" class="success">Success.</div>
	</div>
	
	<!-- Success popover -->
	<div class="submit">
		<div class="submitText">Submitting</div>
	</div>
	<div class="secondaryFooter">&copy; Copyright 2012 Esquire.<br/> Imaginary Rights Reserved.</div>
</body>
</html>
