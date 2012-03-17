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
	<title>Group Search | Esquire</title>
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
					<li class="button navFeed"><a href="feed.php">Feed</a></li>
					<li class="button navProfile">Profile</li>
					<li class="button navGroup"><a href="groups.php">Groups</a></li>
					<li class="button navLogout">Logout</li>
				</ul>
			</nav>
		</header>
		<input type="text" name="search" placeholder="search groups" id="groupSearch" />
		<div id="groupList">
		
			<!-- Group Search chunks go here -->
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
                 		<div class="groupAdd"></div>
                 	</div>              
            <?php
                }
             ?>    
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
</body>
</html>