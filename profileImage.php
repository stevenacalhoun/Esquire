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
			<form method="post" action="php/joinPicture.php">
				<input type="file" name="profileImage" id="profileImage" />
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