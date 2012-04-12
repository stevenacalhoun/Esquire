<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get group from GET request
    $requestedGroupID = str_replace("group", "",$_GET['groupID']);
    $group = new Group($requestedGroupID);
    $_SESSION['group'] = $group;
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Get current user from the session and get group IDs and members
    $user = $_SESSION['user'];
    $user = new User($user->getEmail());
    $_SESSION['user'] = $user;
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
	
	<!-- Main Container -->
	<div class="container" id="specificGroup<?php echo $group->getGroupID(); ?>">
	
		<!-- Header -->
		<header>
			<div class="mainTitle"></div>
			<?php 
				$count = sizeof($user->getGroupInvites());
				if($count > 0){
			?>
				<a href="groups.php"><div class="invite notification"><?php echo $count; ?></div></a>
			<?php } ?>
			<nav>
				<ul>
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile"><a href="#">Profile</a></li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		
		<!-- Specific Group Container -->
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
					<div class="specificGroupEdit icon" title="Edit Group"></div>
				<?php } ?>
			</div>
			
			<!-- Administrator -->
			<div class="specificGroupBlock">
				<div class="specificGroupTitle">Administrator</div>
				<div class="specificGroupText">
					<?php 
						$adminUserObject = new User($group->getAdmin());
						echo $adminUserObject->getFullName();
					?>
				</div>
			</div>
			
			<!-- Notifications for Admin -->
			<?php if($user->getEmail() == $group->getAdmin()){ ?>
				<div class="specificGroupBlock">
					<div class="specificGroupTitle">Notifications</div>
					
					<!-- Member requests -->
					<?php 
						$acceptedMembers = $group->getAcceptedMembers();
						$flaggedPosts = $group->getFlaggedPosts();
						if(sizeof($acceptedMembers) != 0 || sizeof($flaggedPosts) != 0){
							foreach($acceptedMembers as $acceptedMember){ 
								$member = new User($acceptedMember);
					?>
					<div class="notificationBlock">
						<div class="notificationMember icon"></div>
						<div class="notificationAccept icon" title="Permit Member" id="permit<?php echo $member->getEmail(); ?>"></div>
						<div class="notificationDecline icon" title="Deny Member" id="deny<?php echo $member->getEmail(); ?>"></div>
						<div class="notificationText notificationName">
							<?php echo $member->getFullName(); ?>
						</div>
					</div>
					<?php } ?>
					
					<?php 
							foreach($flaggedPosts as $flaggedPost){ 
								$post = new Post($flaggedPost);
					?>
					<div class="notificationBlock">
						<div class="notificationFlag icon"></div>
						<div class="notificationApprove icon" title="Approve Post" id="ignore<?php echo $post->getPostID(); ?>"></div>
						<div class="notificationRemove icon" title="Remove Post" id="delete<?php echo $post->getPostID(); ?>"></div>
						<div class="notificationText">
							<?php echo $post->getMessage(); ?>
						</div>
					</div>
					<?php
						      } 
						  } 
						  else{
						  	echo "<div class='specificGroupText'>No notifications.</div>";
						  }
					?>
				</div>
			<?php } ?>
			
			<!-- Members -->
			<div class="specificGroupBlock">
				<div class="specificGroupTitle">Members</div>
				<div class="specificGroupText">
				<?php foreach($members as $member){ ?>
					<div class="specificGroupMember">
				<?php
					$userObject = new User($member);
					echo $userObject->getFullName();
					if($user->getEmail() == $group->getAdmin() && $userObject->getEmail() != $group->getAdmin()){
				?>
						<div class="specificGroupRemove" title="Remove" id="specificGroup<?php echo $userObject->getEmail(); ?>"></div>
						<div class="specificGroupPromote" title="Promote to Admin" id="specificGroupPromote<?php echo $userObject->getEmail(); ?>"></div>
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
			<?php if($user->getEmail() != $group->getAdmin() && (in_array($requestedGroupID, $user->getGroups()) )){ ?>
				<div class="button red" id="specificGroupDelete">Leave</div>
			<?php } ?>
			
			<!-- Join Group -->
			<?php if(!(in_array($requestedGroupID, $user->getGroups()))){ ?>
				<div class="button green" id="specificGroupJoin">Join</div>
			<?php } ?>
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Edit Group Popover-->
	<div class="box" id="editGroupBox">
		<div id="editGroupTitle">Edit Group</div>
		<form action="php/editGroup.php" id="editGroupForm" method="post">
			<input type="text" name="editGroupName" value="<?php echo $group->getName(); ?>" placeholder="name" id="editGroupName" />
			<textarea name="editGroupDescription" placeholder="description" id="editGroupDescription"><?php echo $group->getDescription(); ?></textarea>
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
    <div class="dynamicPopover" id="profilePopover"></div>
    <div class="dynamicPopover" id="editProfilePopover"></div>
    <div class="dynamicPopover" id="groupSeletPopover"></div>
</body>
</html>