<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
//    require_once("php/userClass.php");
//    require("php/groupClass.php");
    require_once("php/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get current user from the session and get group IDs
    $user = $_SESSION['user'];
    $groupIDs = $user->getGroups();
?>

<!-- Group Selection for Feeds -->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
<div class="box" id="feedBox">
	<?php 
		// Walk over each ID and add a group block for each one
		if (!empty($groupIDs)){
			foreach($groupIDs as $groupID){
		    	$group = new groupClass($groupID);
		        if (in_array($user->getEmail(), $group->getMembers()) or in_array($user->getEmail(), $group->getPermittedMembers())){
	?>
			     	<div class="feedGroupBlock">
			     		<div id="<?php echo $group->getGroupID(); ?>" class="groupTitle">
			     			<a href="feed.php"><?php echo $group->getName(); ?></a>
			     		</div>
			     		<div class="groupText">
			     			<?php echo $group->getDescription(); ?>
			     		</div>
			     	</div>
	<?php       }
		    }
		} 
	?>
</div>