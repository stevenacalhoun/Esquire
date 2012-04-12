<?php
    // Pull in required files and make sure the user is logged in, if not redirect ot log in
    require_once("php/classFiles/User.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get current user from the session
    $user = $_SESSION['user'];
    $user = new User($user->getEmail());
    $_SESSION['user'] = $user;
?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
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
					<input type="radio" name="texts" value="textYes" <?php if($user->getTexts()){ ?>checked<?php } ?> />
					<label>No</label>
					<input type="radio" name="texts" value="textNo" <?php if(!$user->getTexts()){ ?>checked<?php } ?>/>
			</div>
			<div id="editProfileEmails">
				<label name="emails">Emails:</label>
					<label>Yes</label>
					<input type="radio" name="emails" value="emailYes" <?php if($user->getEmails()){ ?>checked<?php } ?> />
					<label>No</label>
					<input type="radio" name="emails" value="emailNo" <?php if(!$user->getEmails()){ ?>checked<?php } ?>/>
			</div>
		</div>
			
		<!-- Right -->
		<div id="editProfileRight">
			<input type="file" name="profileImage" id="editProfileImage" />
			<div id="editProfileTitle"></div>
			<input type="submit" value="Submit" class="button green" id="editProfileSubmit" />
			<div id="editProfileCancel" class="button">Cancel</div>
		</div>
	</form>
	<div class="overlayError" id="passMatchError">Passwords do not match.</div>
	<div class="overlayError" id="invalidPassError">Password must contain at least 5 characters (letters or numbers).</div>
	<div class="overlayError" id="blankError">A required field is empty</div>
</div>