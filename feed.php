<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // GroupID comes from get request and user from session
    $groupID = $_GET['groupID']; 
    $user = $_SESSION['user'];
    
    // Recreate User object and restore it 
    $user = new User($user->getEmail());
    $_SESSION['user'] = $user;
    $_SESSION['groupID'] = $groupID;
    
    // If the user is not a member of the group redirect back to groups page
    if (!in_array($groupID, $user->getGroups() ) ){
        header('Location:groups.php');
    }
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword") or die("Could not connect to dataBase:" . mysql_error());
    mysql_select_db("$db_name", $con);
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Feed | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/spinner.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>

	<!-- Overlays -->
	<div class="overlay" id="feedOverlay"></div>
	<div class="submitOverlay"></div>
	
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
			<div class="postButton"></div>
			<nav>
				<ul>
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile">Profile</li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		
		<!-- Post Container -->
		<div id="feedList<?php echo $groupID ?>">
			<?php 
				$group = new Group($groupID);
				$user = $_SESSION['user'];
				foreach($group->getPosts() as $post){
					$postObject = new Post($post);
					$postUser = new User($postObject->getEmail());
			?>
				<div class="feedBlock">
					<div class="feedName"><?php echo $postUser->getFullName(); ?></div>
					<div class="feedPost"><?php echo $postObject->getMessage(); ?></div>
					<div class="feedDate"><?php echo $postObject->getDateTime(); ?></div>
					<?php if($user->getEmail() == $group->getAdmin() || $user->getEmail() == $postUser->getEmail()){ ?>
						<div class="feedDelete" title="Delete Post" id="delete<?php echo $postObject->getPostID(); ?>"></div>
					<?php } ?>
					<?php if($postObject->getFlag()){ ?>
						<div class="feedFlag icon active" title="Flag Post" id="flag<?php echo $postObject->getPostID(); ?>"></div>
					<?php } else { ?>
						<div class="feedFlag icon" title="Flag Post" id="flag<?php echo $postObject->getPostID(); ?>"></div>
					<?php } ?>
				</div>
			<?php } ?> 
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Post Popover-->
	<div class="box" id="postBox">
		<div id="postTitle">Post an Update</div>
		<form action="php/post.php" id="postForm" method="post">
			<textarea name="postContent" id="postContent"></textarea>
			<input type="submit" value="Post" class="button green" id="postCreate" />
		</form>
		<div class="button" id="postCancel">Cancel</div>
	</div>
	
	<!-- Profile popovers -->
    <div class="dynamicPopover" id="profilePopover"></div>
    <div class="dynamicPopover" id="editProfilePopover"></div>
    <div class="dynamicPopover" id="groupSeletPopover"></div>
    
    <!-- Success Popover -->
    <div class="submit">
    	<div class="submitText">Submitting</div>
    </div>
</body>
</html>