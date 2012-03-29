<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/userClass.php");
    require("php/groupClass.php");
    require_once("php/db_setup.php");
    session_start();
  
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

	<!-- Group Page -->
	<div class="container">
		<header>
			<div class="mainTitle"></div>
			<nav>
				<ul>
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile">Profile</li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		<input type="text" name="search" placeholder="search groups" id="groupSearch" />
		<div id="groupList">
		
            <?php 
                // Get current user from the session and get group IDs
                $user = $_SESSION['user'];
                $groupIDs = $user->getGroups();
                
                // Walk over each ID and add a group block for each one
                if (!empty($groupIDs)){
                    foreach($groupIDs as $groupID){
                        $group = new groupClass($groupID);
                        if (in_array($user->getEmail(), $group->getMembers()) or in_array($user->getEmail(), $group->getPermittedMembers())){
                 ?>
                     	<div class="groupBlock">
                     		<div id="group<?php echo $group->getGroupID(); ?>" class="groupTitle">
                     			<a href="specificGroup.php?groupID=<?php echo $group->getGroupID(); ?>"><?php echo $group->getName(); ?></a>
                     		</div>
                     		<div class="groupText">
                     			<?php echo $group->getDescription(); ?>
                     		</div>
                     		
                     		<!-- Admin deleteGroup button -->
                     		<?php if($user->getEmail() == $group->getAdmin()){ ?>
                     		   	<div class="groupDelete" id="groupDelete<?php echo $group->getGroupID(); ?>"></div>
                     	    <?php } ?>
                     	    
                     	    <!-- Accept/decline buttons -->
                     	    <?php if(!in_array($user->getEmail(), $group->getMembers())){
                     	    ?>
                     	    	<div class="decline icon" id="groupDecline<?php echo $group->getGroupID(); ?>"></div>
                     	        <div class="accept icon" id="groupAccept<?php echo $group->getGroupID(); ?>"></div>
                     	        
                     		<?php } ?>
                     	</div>   
                     	<?php } ?>       
                <?php
                    }
                }
             ?>    
		</div>
		<div class="button green" id="groupCreate">Create</div> 
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Create Group Box -->
	<div class="box" id="createGroupBox">
		<div id="createGroupTitle">Create a Group</div>
		<form action="php/createGroup.php" id="createGroupForm" method="post">
			<input type="text" name="createGroupName" placeholder="name" id="createGroupName" />
			<textarea name="createGroupDescription" placeholder="description" id="createGroupDescription"></textarea>
			<textarea name="createGroupEmails" placeholder="emails to invite" id="createGroupEmails"></textarea>
			<input type="submit" value="Create" class="button green" id="createGroupCreate" />
		</form>
		<div class="button" id="createGroupCancel">Cancel</div>
	</div>
	<div class="error" id="createGroupEmptyField">You left a field blank.</div>
	<div class="error" id="createGroupInvalidEmail">One or more of the emails you entered is invalid.</div>
	<div id="test"></div>
</body>
</html>