<!DOCTYPE html>
<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    $groupID = $_GET['groupID'];
     
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Feed | Esquire <?php echo $groupID; ?></title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>

	<!-- Overlay -->
	<div class="overlay" id="feedOverlay"></div>
	
	<!-- Main Container -->
	<div class="container">
	
		<!-- Header -->
		<header>
			<div class="mainTitle"></div>
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
		<div id="feedList">
			<div class="feedBlock">
				<div class="feedName">Matt Smith</div>
				<div class="feedPost">Bespoke Austin authentic, art party echo park trust fund truffaut selvage mixtape helvetica thundercats forage. Tattooed marfa Austin, tumblr farm-to-table ethnic mustache seitan next level banksy brooklyn skateboard fanny pack. Authentic pop-up typewriter, thundercats godard gastropub sustainable art party freegan pinterest cliche terry richardson kogi. Banh mi wolf pop-up 3 wolf moon tumblr dreamcatcher, swag beard mlkshk fixie godard iphone. Biodiesel fixie hoodie typewriter. Godard raw denim kogi, PBR scenester fap kale chips banksy pickled echo park keffiyeh wolf cray lomo high life. Pitchfork before they sold out single-origin coffee yr artisan, vinyl twee beard jean shorts messenger bag bespoke shoreditch seitan.</div>
				<div class="feedDate">8:52pm 20 February 2012</div>
				<div class="feedDelete"></div>
				<div class="feedFlag icon"></div>
			</div>
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
</body>
</html>