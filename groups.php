<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Groups | Esquire</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/site.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
		<header>
			<div class="mainTitle"></div>
			<div class="postButton"></div>
			<nav>
				<ul>
					<a href="feed.php"><li class="button" id="navFeed">Feed</li></a>
					<li class="button" id="navProfile">Profile</li>
					<a href="groups.php"><li class="button" id="navGroup">Groups</li></a>
					<li class="button" id="navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		<input type="text" name="search" placeholder="search groups" id="groupSearch" />
		<div id="groupList">
		
			<!-- Group chunks go here -->
            <?php 
                require_once("php/userClass.php");
                require("php/groupClass.php");
                require_once("php/db_setup.php");
                $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
                mysql_select_db("$db_name", $con);
                
                session_start();
                $user = $_SESSION['user'];
                $groupIDs = $user->getGroups();
                
                foreach($groupIDs as $groupID){
                    $group = new groupClass($groupID);
             ?>
                 	<div class="groupBlock">
                 		<div class="groupTitle">
                 			<?php echo $group->getName(); ?>
                 		</div>
                 		<div class="groupText">
                 			<?php echo $group->getDescription(); ?>
                 		</div>
                 	</div>              
            <?php
                }
             ?>    
		</div>
		<div id="groupCreate">Create Group</div> 
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
</body>
</html>