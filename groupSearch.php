<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Get current user from the session
    $user = $_SESSION['user'];
    
    // Recreate user object and get groups    
    $user = new User($user->getEmail());
    $_SESSION['user'] = $user;
    $groupIDs = $user->getGroups();
    
    // Get the desired search entry
    $search = $_GET['search'];
    $_SESSION['search'] = $search;
    
    // Use search function to search for groups 
    $groupIDs = $user->searchGroups($search);
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Group Search | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>

	<!-- Overlay -->
	<div class="overlay" id="searchGroupOverlay"></div>
	
	<!-- Main Container -->
	<div class="container">
	
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
                if($groupIDs != null){
                    foreach($groupIDs as $groupID){
                        $group = new Group($groupID);
            ?>
                     	<div class="groupBlock">
                     	
                     		<!-- Title -->
                     		<div id="<?php echo $group->getGroupID(); ?>" class="groupTitle">
                     			<a href="specificGroup.php?groupID=<?php echo $group->getGroupID(); ?>"><?php echo $group->getName(); ?></a>
                     		</div>
                     		
                     		<!-- Description -->
                     		<div class="groupText">
                     			<?php echo $group->getDescription(); ?>
                     		</div>
                     		
                     		<!-- Add button if member is not in group -->
	                     	<?php if(!in_array($groupID, $user->getGroups()) && !in_array($user->getEmail(), $group->getAcceptedMembers())){ ?>
	                     		<div class="groupAdd icon" title="Add Group" id="groupAdd<?php echo $group->getGroupID();?>"></div>
	                     	<?php } ?>
                     	</div>              
 			<?php   }
                }
                else{ ?>
                	<div id="emptyResults">Your search returned no results.</div>
			<?php } mysql_close($con); ?>    
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Profile popovers -->
    <div class="dynamicPopover" id="profilePopover"></div>
    <div class="dynamicPopover" id="editProfilePopover"></div>
    <div class="dynamicPopover" id="groupSeletPopover"></div>
</body>
</html>