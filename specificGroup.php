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
    // Get group from GET request
    $requestedGroupID = str_replace("group", "",$_GET['groupID']);
    $group = new groupClass($requestedGroupID);
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Get current user from the session and get group IDs
    $user = $_SESSION['user'];
    $groupIDs = $user->getGroups();
    $members = $group->getMembers();
?>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $group->getName(); ?> | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>

	<!-- Popovers -->
	<div class="overlay" id="specificGroupOverlay"></div>
	
	<div class="container" id="specificGroup<?php echo $group->getGroupID(); ?>">
		<header>
			<div class="mainTitle"></div>
			<nav>
				<ul>
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile"><a href="#">Profile</a></li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		
		<!-- Specific Group chucks go here-->
		<div id="specificGroupList">
			
			<!-- Group Name & Description -->
			<div class="specificGroupBlock">
				<div class="specificGroupTitle">
					<?php echo $group->getName(); ?>
				</div>
				<div class="specificGroupText">
					<?php echo $group->getDescription(); ?>
				</div>
				
				<?php if($user->getEmail() == $group->getAdmin()){ ?>
					<div class="specificGroupEdit icon"></div>
				<?php } ?>
			</div>
			
			<!-- Administrator -->
			<div class="specificGroupBlock">
				<div class="specificGroupTitle">Administrator</div>
				<div class="specificGroupText">
					<?php 
						$adminUserObject = new userClass($group->getAdmin());
						echo $adminUserObject->getFullName();
					?>
				</div>
			</div>
			
			<!-- Notifications for Admin -->
			
			<!-- Members -->
			<div class="specificGroupBlock">
				<div class="specificGroupTitle">Members</div>
				<div class="specificGroupText">
				<?php foreach($members as $member){ ?>
					<div class="specificGroupMember">
				<?php
					$userObject = new userClass($member);
					echo $userObject->getFullName();
					if($user->getEmail() == $group->getAdmin() && $userObject->getEmail() != $group->getAdmin()){
				?>
						<div class="specificGroupRemove" id="specificGroup<?php echo $userObject->getEmail(); ?>"></div>
				<?php } ?>
					</div>
				<?php } ?>
				</div>
			</div>
			
			<!-- Add Members -->
			<?php if($user->getEmail() == $group->getAdmin()){ ?>
				<div class="button green" id="specificGroupAdd">Add</div>
			<?php } ?>
			<!-- Leave Group -->
			<?php if($user->getEmail() != $group->getAdmin()){ ?>
				<div class="button red" id="specificGroupDelete">Leave</div>
			<?php } ?>
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Edit Group Popover-->
	<div class="box" id="editGroupBox">
		<div id="editGroupTitle">Edit Group</div>
		<form action="php/editGroup.php" id="editGroupForm" method="post">
			<input type="text" name="editGroupName" placeholder="name" id="editGroupName" />
			<textarea name="editGroupDescription" placeholder="description" id="editGroupDescription"></textarea>
			<input type="submit" value="Submit" class="button green" id="editGroupCreate" />
		</form>
		<div class="button" id="editGroupCancel">Cancel</div>
	</div>
	
	<!-- Invite Popover -->
	<div class="box" id="inviteBox">
		<div id="inviteTitle">Invite Members</div>
		<form action="php/invite.php" id="inviteForm" method="post">
			<textarea name="inviteEmails" placeholder="emails to invite" id="inviteEmails"></textarea>
			<input type="submit" value="Submit" class="button green" id="inviteSubmit" />
		</form>
		<div class="button" id="inviteCancel">Cancel</div>
	</div>
	
	<!-- Profile popovers -->
	<div class="dynamicPopover"></div>
</body>
</html>