<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/userClass.php");
    require("php/groupClass.php");
    require_once("php/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    $user = $_SESSION['user'];
?>

<!-- Profile popover -->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
<div id="profileBox" class="box">
	<div class="profileTitle"><?php echo $user->getFullName(); ?></div>
	<div class="profileEntry">
		<div class="profileSubTitle">Email:&nbsp;</div>
		<div class="profileContent"><?php echo $user->getEmail(); ?></div>
	</div>
	<div class="profileEntry">
		<div class="profileSubTitle">Phone:&nbsp;</div>
		<div class="profileContent"><?php echo $user->getPhone(); ?></div>
	</div>
	<div class="profileEntry">
		<div class="profileSubTitle">Carrier:&nbsp;</div>
		<div clas="profileContent"><?php echo $user->getCarrier(); ?></div>
	</div>
	<div class="profileEntry">
		<div class="profileSubTitle">Texts:&nbsp;</div>
		<div class="profileContent"><?php if($user->getTexts())echo "Yes";else echo "No"; ?></div>
	</div>
	<div class="profileEntry">
		<div class="profileSubTitle">Emails:&nbsp;</div>
		<div class="profileContent"><?php if($user->getEmails())echo "Yes";else echo "No"; ?></div>
	</div>
	<div class="profileEntry">
		<div class="profileSubTitle">Member of:&nbsp;</div>
			<div class="profileContent">
				<?php 
				$groups = $user->getGroups();
    			if ($groups != null){
    				$i = 0;
    				foreach($groups as $group){
    				    $i++;
    					$groupName = new groupClass($group);
    					echo $groupName->getName();
    					if(sizeof($groups)>1 && $i<sizeof($groups)){
    						echo ", ";
    					}
    				}
    			}
    			else {
    			    echo "<i>No groups</i>";
    			}
				?>
			</div>
	</div>
	<a href="#"><div id="profileEdit" class="button green">Edit</div></a>
	<a href="#"><div id="profileCancel" class="button">Cancel</div></a>
</div>