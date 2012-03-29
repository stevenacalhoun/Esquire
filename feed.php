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
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Feed | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>

	<!-- Overlay -->
	<div class="overlay" id="feedOverlay"></div>
	
	<div class="container">
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
		
		<!-- Feed chunks go here -->
		
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
</body>
</html>