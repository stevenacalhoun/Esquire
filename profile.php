<!DOCTYPE html>

<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/userClass.php");
    require("php/groupClass.php");
    require_once("php/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    $user = $_SESSION['user'];
?>

<!-- Temp page for profile code -->
<html>
<head>
	<meta charset="utf-8" />
	<title>Profile | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>
	<div id="profileBox" class="box">
		<div class="profileTitle"><?php echo $user->getFullName(); ?></div>
		<div class="profileEmail">Email:&nbsp;<?php echo $user->getEmail(); ?></div>
		<div class="profilePhone">Phone:&nbsp;<?php echo $user->getPhone(); ?></div>
		<div class="profileCarrier">Carrier:&nbsp;<?php echo $user->getCarrier(); ?></div>
		<div class="profileTexts">Texts:&nbsp;<?php if($user->getTexts()=="textYes")echo "Yes";else echo "No"; ?></div>
		<div class="profileEmails">Emails:&nbsp;<?php if($user->getEmails()=="emailYes")echo "Yes";else echo "No"; ?></div>
		<div class="profileGroupsTitle">Member of:</div>
			<div class="profileGroups">
				<?php 
				$groups = $user->getGroups();
				foreach($groups as $group){
					$groupName = new groupClass($group);
					echo $groupName->getName();
					echo "<br />";
				}
				?>
			</div>
		<a href="#"><div id="profileCancel" class="button">Cancel</div></a>
		<a href="#"><div id="profileEdit" class="button green">Edit</div></a>
	</div>
	<div class="secondaryFooter">&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</div>
</body>
</html>
