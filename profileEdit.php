<!-- Edit Profile popover -->
<div id="editProfileBox" class="box">
	<form id="editProfileForm" action="php/editProfile.php" method="post">
	
		<!-- Left -->
		<div id="editProfileLeft">
			<input type="text" name="firstName" placeholder="first name" id="editProfileFirst" value="<?php echo $user->getFirstName(); ?>" />
			<input type="text" name="lastName" placeholder="last name" id="editProfileLast" value="<?php echo $user->getLastName(); ?>" />
			<input type="password" name="password" placeholder="password" id="editProfilePassword" />
			<input type="password" name="confirmPassword" placeholder="confirm password" id="editProfileConfirm" />
			<input type="text" name="phoneNum" placeholder="phone number" id="editProfilePhone" value="<?php echo $user->getPhone(); ?>" />
			<select name="carrier" id="editProfileCarrier">
				<option value="default">select a carrier</option>
				<option value="AT&T" <?php if($user->getCarrier()=="AT&T"){ ?>selected<?php } ?>>AT&amp;T</option>
				<option value="T-Mobile" <?php if($user->getCarrier()=="T-Mobile"){ ?>selected<?php } ?>>T-Mobile</option>
				<option value="Verizon" <?php if($user->getCarrier()=="Verizon"){ ?>selected<?php } ?>>Verizon</option>
			</select>
			<div id="editProfileTexts">
				<label name="texts">Texts:</label>
					<label>Yes</label>
					<input type="radio" name="texts" value="textYes" <?php if($user->getTexts()=="textYes"){ ?>checked<?php } ?> />
					<label>No</label>
					<input type="radio" name="texts" value="textNo" <?php if($user->getTexts()=="textNo"){ ?>checked<?php } ?>/>
			</div>
			<div id="editProfileEmails">
				<label name="emails">Emails:</label>
					<label>Yes</label>
					<input type="radio" name="emails" value="emailYes" <?php if($user->getEmails()=="emailYes"){ ?>checked<?php } ?> />
					<label>No</label>
					<input type="radio" name="emails" value="emailNo" <?php if($user->getEmails()=="emailNo"){ ?>checked<?php } ?>/>
			</div>
		</div>
			
		<!-- Right -->
		<div id="editProfileRight">
			<!--<div id="editImage">Edit<div id="overlay"></div></div>-->
			<div id="editProfileTitle"></div>
			<input type="submit" value="Submit" class="button green" id="editProfileSubmit" />
			<a href="#"><div id="editProfileCancel" class="button">Cancel</div></a>
		</div>
	</form>
</div>