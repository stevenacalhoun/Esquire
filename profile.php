<?php $user = $_SESSION['user']; ?>

<!-- Profile popover -->
<div id="profileBox" class="box">
	<div class="profileTitle"><?php echo $user->getFullName(); ?></div>
	<div class="profileTitle">Email:&nbsp;</div><div class="profileEmail"><?php echo $user->getEmail(); ?></div>
	<div class="profilePhone">Phone:&nbsp;<?php echo $user->getPhone(); ?></div>
	<div class="profileCarrier">Carrier:&nbsp;<?php echo $user->getCarrier(); ?></div>
	<div class="profileTexts">Texts:&nbsp;<?php if($user->getTexts()=="textYes")echo "Yes";else echo "No"; ?></div>
	<div class="profileEmails">Emails:&nbsp;<?php if($user->getEmails()=="emailYes")echo "Yes";else echo "No"; ?></div>
	<div class="profileGroupsTitle">Member of:</div>
		<div class="profileGroups">
			<?php 
			$groups = $user->getGroups();
			foreach($groups as $group){
				$groupName = new groupClass($group);
				echo $groupName->getName();
				echo "<br />";
			}
			?>
		</div>
	<a href="#"><div id="profileCancel" class="button">Cancel</div></a>
	<a href="#"><div id="profileEdit" class="button green">Edit</div></a>
</div>