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

	<!-- Overlay -->
	<div class="overlay" id="searchGroupOverlay"></div>
	
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
		
			<!-- Group Search chunks go here -->
            <?php 
                // Connect to database
                $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
                mysql_select_db("$db_name", $con);
                
                // Get current user from the session and get group IDs
                $user = $_SESSION['user'];
                $groupIDs = $user->getGroups();
                
                // Get the desired search entry
                $search = $_GET['search'];
                
                // Use search function to search for groups 
                $groupIDs = $user->searchGroups($search);
                
                if($groupIDs != null){
                // Walk over each ID and add a group block for each one
                    foreach($groupIDs as $groupID){
                        $group = new groupClass($groupID);
                 ?>
                     	<div class="groupBlock">
                     		<div id="<?php echo $group->getGroupID(); ?>" class="groupTitle">
                     			<a href="specificGroup.php?groupID=<?php echo $group->getGroupID(); ?>"><?php echo $group->getName(); ?></a>
                     		</div>
                     		<div class="groupText">
                     			<?php echo $group->getDescription(); ?>
                     		</div>
                     	<?php if(!in_array($groupID, $user->getGroups())){ ?>
                     		<div class="groupAdd icon" id="<?php echo $group->getGroupID(); ?>"></div>
                     	<?php } ?>
                     	</div>              
                <?php
                    }
                }
                else{ ?>
                	<div id="emptyResults">Your search returned no results.</div>
			<?php } mysql_close($con); ?>    
		</div>
	</div>
	<footer>&copy; Copyright 2012 Esquire. Imaginary Rights Reserved.</footer>
	
	<!-- Profile popovers -->
	<div class="dynamicPopover"></div>
</body>
</html>