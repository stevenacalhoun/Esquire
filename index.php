<!DOCTYPE html>

<?php 
    // Destroy any session info that may be leftover to ensure login
    session_start();
    session_destroy();
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
	<div id="loginBox" class="box">
		<div id="loginTitle"></div>
		<form action="php/login.php" method="post" id="loginForm">
			<input type="text" name="email" placeholder="email" id="loginEmail" />
			<input type="password" name="password" placeholder="password" id="loginPassword" />
			
			<input type="submit" value="Login" id="loginButton" class="button" />
		</form>
		<a href="join.html"><div id="joinButton" class="buttonG">Join</div></a>
		<div id="reset">Forgot password?</div>
	</div>
	<div id="loginError" class="error">Wrong Username/Password Combination.</div>
	<div class="secondaryFooter">&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</div>
</body>
</html>
