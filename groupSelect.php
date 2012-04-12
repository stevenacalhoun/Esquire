<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get current user from the session and get group IDs
    $user = $_SESSION['user'];
    $user = new User($user->getEmail());
    $_SESSION['user'] = $user;
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
		    	$group = new Group($groupID);
		        if (in_array($user->getEmail(), $group->getMembers()) or in_array($user->getEmail(), $group->getPermittedMembers())){
	?>
				     	<div class="feedGroupBlock" id="<?php echo $group->getGroupID(); ?>">
				     		<div class="groupTitle">
				     			<?php echo $group->getName(); ?>
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