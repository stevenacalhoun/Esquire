<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get current user from the session and get group IDs
    $user = $_SESSION['user'];
    $groupIDs = $user->getGroups();
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Groups | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>
	
	<!-- Overlay -->
	<div class="overlay" id="createGroupOverlay"></div>

	<!-- Main Container -->
	<div class="container">
	
		<!-- Header -->
		<header>
			<div class="mainTitle"></div>
			<a href="groups.php"><div class="invite notification">1</div></a>
			<nav>
				<ul>
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile">Profile</li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		
		<!-- Search Bar -->
		<input type="text" name="search" placeholder="search groups" id="groupSearch" />
		
		<!-- Group Container -->
		<div id="groupList">
            <?php 
                // Walk over each ID and add a group block for each one
                if (!empty($groupIDs)){
                    foreach($groupIDs as $groupID){
                        $group = new Group($groupID);
                        if (in_array($user->getEmail(), $group->getMembers()) or in_array($user->getEmail(), $group->getPermittedMembers())){
            ?>
                     	<div class="groupBlock">
                     	
                     		<!-- Title -->
                     		<div id="group<?php echo $group->getGroupID(); ?>" class="groupTitle">
                     			<a href="specificGroup.php?groupID=<?php echo $group->getGroupID(); ?>"><?php echo $group->getName(); ?></a>
                     		</div>
                     		
                     		<!-- Description -->
                     		<div class="groupText">
                     			<?php echo $group->getDescription(); ?>
                     		</div>
                     		
                     		<!-- Admin deleteGroup button -->
                     		<?php if($user->getEmail() == $group->getAdmin()){ ?>
                     		   	<div class="groupDelete" title="Delete Group" id="groupDelete<?php echo $group->getGroupID(); ?>"></div>
                     	    <?php } ?>
                     	    
                     	    <!-- Accept/decline buttons -->
                     	    <?php if(!in_array($user->getEmail(), $group->getMembers())){ ?>
                     	    	<div class="decline icon" title="Decline Invite" id="groupDecline<?php echo $group->getGroupID(); ?>"></div>
                     	        <div class="accept icon" title="Accept Invite" id="groupAccept<?php echo $group->getGroupID(); ?>"></div>
                     		<?php } ?>
                     		<?php
                     			$count = sizeof($group->getAcceptedMembers()) + sizeof($group->getFlaggedPosts());
                     			if($count > 0){ 
                     	 	?>
                     			<div class="flagmember notification"><?php echo $count; ?></div>
                     		<?php } ?>
                     	</div>   
			<?php   	}
                    }
                }
            ?>    
		</div>
		
		<!-- Create Group -->
		<div class="button green" id="groupCreate">Create</div> 
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Create Group Popover -->
	<div class="box" id="createGroupBox">
		<div id="createGroupTitle">Create a Group</div>
		<form action="php/createGroup.php" id="createGroupForm" method="post">
			<input type="text" name="createGroupName" placeholder="name" id="createGroupName" />
			<textarea name="createGroupDescription" placeholder="description" id="createGroupDescription"></textarea>
			<textarea name="createGroupEmails" placeholder="emails to invite" id="createGroupEmails"></textarea>
			<input type="submit" value="Create" class="button green" id="createGroupCreate" />
		</form>
		<div class="button" id="createGroupCancel">Cancel</div>
		<div class="overlayError" id="createGroupEmptyField">You left a field blank.</div>
		<div class="overlayError" id="createGroupInvalidEmail">One or more of the emails you entered is invalid.</div>
	</div>
	
	<!-- Profile popovers -->
	<div class="dynamicPopover" id="profilePopover"></div>
    <div class="dynamicPopover" id="editProfilePopover"></div>
    <div class="dynamicPopover" id="groupSeletPopover"></div>
</body>
</html>