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
					<a href="feed.html"><li class="button">Feed</li></a>
					<li class="button">Profile</li>
					<a href="groups.html"><li class="button">Groups</li></a>
					<li class="button">Sign Out</li>
				</ul>
			</nav>
		</header>
		<input type="text" name="search" placeholder="search groups" id="groupSearch" />
		<div id="groupList">
		
			<!-- Group chunks go here -->
            <?php 
                require_once("php/userClass.php");
                require_once("php/groupClass.php");
                require_once("php/db_setup.php");
                $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
                mysql_select_db("$db_name", $con);
                
                session_start();
                $user = $_SESSION['user'];
                $groupIDs = $user->getGroups();
                
                foreach($groupIDs as $groupID){
                    $group = new groupClass($groupID);

                    // Christian is awesome
                    <div class="groupBlock">
                    	<div class="groupTitle"></div>
                    	<div class="groupText"></div>
                    </div>
                }
             ?>    
		</div>
		<div id="groupCreate">Create Group</div> 
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
</body>
</html>