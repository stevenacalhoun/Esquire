<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Add a Profile Image | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
	<body>
		
		<!-- Overlay -->
		<div class="submitOverlay"></div>
		
		<!-- Main Box -->
		<div id="profileImageBox" class="box">
			<div id="profileImageTitle">Add a Profile Image</div>
			<form method="post" action="php/joinPicture.php" enctype="multipart/form-data">
				<input type="file" name="profileImage" id="profileImage" />
				<div id="profileImageText">For best results, upload a square image.</div>
				<input type="submit" value="Submit" class="button green" id="profileImageSubmit" />
			</form>
			<a href="groups.php"><div class="button" id="profileImageSkip">Skip</div></a>
		</div>
				
		<!-- Submitting Popover -->
		<div class="submit">
			<div class="submitText">Submitting</div>
			<div class="submitGif"></div>
		</div>
	</body>
</html>