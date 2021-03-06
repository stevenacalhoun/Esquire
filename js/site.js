$(document).ready(function() {

    /** Login, join, logout, and validation **/
    
    // Sniffer for login submit
	$('#loginForm').submit(login);
	
	// Sniffer for password reset
	$('#reset').click(function(){
		$('#resetBox').fadeIn('fast');
	});
	
	// Sniffer for reset cancel
	$('#resetCancel').click(function(){
		$('#resetBox').fadeOut('fast');
	});
	
	// Sniffer for reset submit
	$('#resetSubmit').click(resetPassword);
	
	// Sniffer for join submit
	$('#joinForm').submit(function() {
	    newAccount(event);
	});
	
	// Sniffers for blurs on the email, password, and confirm password for create account page
	$('#joinEmail').blur(validateEmail);
    $('#joinPassword').blur(validatePass1);
    $('#joinConfirm').blur(validatePass2);
    
    // Sniffer for logout
    $('.navLogout').click(function(){window.location.replace("index.php");});
    
    
    /** Profile edit buttons **/
    
    // Sniffer for profile button click
    $('.navProfile').click(showProfile);
    
    // Sniffer for edit profile click
    $('#profileEdit').click(showEditProfile);
    
    // Sniffer for profile cancel click    
    $('#profileCancel').click(hideProfile);
    $('#editProfileCancel').click(hideProfile);
    
    // Sniffers for blurs on the password and confirm password
    $('#editProfilePassword').blur(validatePass1);
    $('#editProfileConfirm').blur(validatePass2);
    $('#editProfileForm').submit(editProfile);
    
    
    /** Group functions **/
    
    // Sniffer for creating a new group and canceling group
    $('#groupCreate').click(
    	function(){
    		event.stopPropagation();
    		$('#createGroupOverlay').fadeIn('fast');
    		$('#createGroupBox').fadeIn('fast');
    		$("#createGroupName").focus();
    	}
    );
    
    // Cancel new group create
    $('#createGroupCancel').click(
        function(){
            $('#createGroupOverlay').fadeOut('fast');
            $('#createGroupBox').fadeOut('fast');
            $("#createGroupInvalidEmail").fadeOut('fast');
            $("#createGroupEmptyField").fadeOut('fast');
        }
    );
    
    // Click button to create group
    $('#createGroupCreate').click(createGroup);
    
    // Hit enter in description field to create group
    $('#createGroupDescription').keypress(function(event){
        if (event.keyCode == 13){
            createGroup();
        }
    });
    
    // Hit enter in email field to create group
    $('#createGroupEmails').keypress(function(event){
        if (event.keyCode == 13){
            createGroup();
        }
    });
    
    // Sniffer for admin's delete group button
    $('.groupDelete').click(deleteGroup);
    
    // Sniffer for leave group
    $('#specificGroupDelete').click(leaveGroup);
    
    // Sniffer for searching for groups
    $('#groupSearch').keyup(function(event){
        if (event.keyCode == 13 && $('#groupSearch').val() != ""){
            window.location.replace("groupSearch.php?search=" + $("#groupSearch").val());
        }
    });
    
    // Request admission
    $('.groupAdd').click(groupAdd);
    $('#specificGroupJoin').click(specificGroupAdd);
    
    
    // Sniffer for accept invitation button
    $('.accept').click(acceptInvitation);
    
    // Sniffer for accept invitation button
    $('.decline').click(declineInvitation);
    
    // Sniffer for feed click
    $('.navFeed').click(loadFeedSelection);
    
    // Sniffer for closing feed select
    
    // Sniffer for each group click for feed
    $(".feedGroupBlock").click(moveToFeedPage);
    
    /** Group's admin privileges **/
    
    // Sniffer for remove member click 
    $('.specificGroupRemove').click(removeMember);
    
    // Sniffer for admin edit group button and cancel
    $('.specificGroupEdit').click(
        function(){
            event.stopPropagation();
            $('#editGroupBox').fadeIn('fast'); 
            $('.overlay').fadeIn('fast');
        }
    );
        
    // Cancel button for edit group popover
    $('#editGroupCancel').click(
        function(){
            $('#editGroupBox').fadeOut('fast');
            $('.overlay').fadeOut('fast');
        }
    );
    
    // Click for edit group
    $('#editGroupCreate').click(editGroup);
    
    // Sniffer for enter hit to edit group
    $('#editGroupDescription').keypress(function(event){
        if (event.keyCode == 13){
            editGroup(event);
        }
    });
    
    // Sniffer for admin invite member button and cancel
    $('#specificGroupAdd').click(
        function(){
            event.stopPropagation();
            $('#inviteBox').fadeIn('fast');
            $('.overlay').fadeIn('fast');
            $('#inviteEmails').focus();
        }
    );
    
    // Submit for inviting new members
    $('#inviteSubmit').click(inviteMembers);
    
    // Sniffer for enter hit to add memebers
    $('#inviteEmails').keypress(function(event){
        if (event.keyCode == 13){
            inviteMembers(event);
        }
    });
    
    // Cancel click for invite box
    $('#inviteCancel').click(
        function(){
            $('#inviteBox').fadeOut('fast');
            $('.overlay').fadeOut('fast');
        }
    );
    
    // Sniffer for change admin
    $('.specificGroupPromote').click(changeAdmin);
    
    // Sniffer for click on request accept
    $('.notificationAccept').click(permitRequest);
    
    // Sniffer for click on request deny
    $('.notificationDecline').click(denyRequest);
    
    // Sniffer for ignore flag post
    $('.notificationApprove').click(ignoreFlag);
    
    // Sniffer for delete flagged post
    $('.notificationRemove').click(deletePost);
    
    // Sniffer for delete post off of feed
    $('.feedDelete').click(deletePost);
    
    // Sniffer for flag post
    $('.feedFlag').click(flagPost);
    
    /** Post stuff **/
    
    // Sniffer for new post
    $(".postButton").click(
        function(){
            event.stopPropagation();
            $("#postBox").fadeIn('fast');
            $(".overlay").fadeIn('fast');
            $("#postContent").focus();
        }
    );
    
    // Sniffer for cancel post
    $("#postCancel").click(
        function(){
            $("#postBox").fadeOut('fast');
            $(".overlay").fadeOut('fast');
        }
    );
    
    // Sniffer for submit post
    $('#postCreate').click(newPost);
    
    $('#postBox').keypress(function(event){
        if (event.keyCode == 13){
            newPost();
        }
    });
    
    // Sniffer for a click on any overlay to fade out any popover
    $('.overlay').click(
        function() {
            //Hide the menus if visible
            $('.overlay').fadeOut('fast');
            $('#profilePopover').fadeOut('fast');
            $('#editProfilePopover').fadeOut('fast');
            $('#createGroupBox').fadeOut('fast');
            $('#inviteBox').fadeOut('fast');
            $('#editGroupBox').fadeOut('fast');
            $('#postBox').fadeOut('fast');
         }
     );
     
    // Hitting the escape key is the same as clicking the overlay
    $(document).keyup(function(e) {
        if (e.keyCode == 27){ 
            $('.overlay').click(); 
        }
    });
    
});


/** Login and join functions **/

// AJAX function for login. Checking to see if correct login.
function login(event){
    // Stop php file from running
	event.preventDefault();
	
	// Create data form form and get action
	var data = $("form#loginForm").serialize();
	var url = $('form#loginForm').attr('action');
	
	// AJAX function to submit data for login.php, if successful move user to next page, otherwise present error
	$.post(url, data,
		function(data) {
		console.log(data);
            if (data=="success"){
                window.location.replace("groups.php");
		    }
		    else {
                $('#loginError').fadeIn('fast');
		    }
	    }
	);
}

// AJAX function for reset password
function resetPassword(event){
    // Stop php file from running
	event.preventDefault();
	
	// Create data from form and get action
	var data = $('form#resetForm').serialize();
	var url = $('form#resetForm').attr('action');
	
	// Show user that request is being submitted to compensate for wait time
	$('.submitOverlay').fadeIn('fast');
	$('.submit').fadeIn('fast');
	
	// AJAX post for reset password, if it works then fade in a success box otherwise an email error
	$.post(url, data,
		function(data){
			if(data == "success"){
				$('#resetSuccess').fadeIn('fast');
				$('#resetError').fadeOut('fast');
				$('.submitOverlay').fadeOut('fast');
				$('.submit').fadeOut('fast');
			}
			else{
				$('#resetError').fadeIn('fast');
				$('.submitOverlay').fadeOut('fast');
				$('.submit').fadeOut('fast');
			}
		}
	);
}


// Function that handles the returns of php validation and moving user to next page upon successful account creation
function newAccount(event){
    // Stop php file from running
    event.preventDefault();
    
    // Create data form form and get action
    var data = $("form#joinForm").serialize();
    var url = $("form#joinForm").attr('action');
    
    // Check for any empty fields
    if($("#joinFirst").val()=="" || $("#joinLast").val()=="" || $("#joinPhone").val()==""){
        $('#blankError').fadeIn('fast');
    }
    else{
        $('#blankError').fadeOut('fast');
    }

	// Show user that request is being submitted to compensate for wait time
    $('.submitOverlay').fadeIn('fast');
    $('.submit').fadeIn('fast');
    
    // Use AJAX post for joining
    $.post (url, data,
        function(data) {   
            console.log(data);    
            // Check for each error in the return data and present error windows accordingly
            if (data.indexOf("exists") != -1){
                $('#creationError').fadeIn('fast');
                $('.submitOverlay').fadeOut('fast');
                $('.submit').fadeOut('fast');
            }
            else {$('#creationError').fadeOut('fast');}
            
            if (data.indexOf("emailError") != -1){
                $('#emailError').fadeIn('fast');
                $('.submitOverlay').fadeOut('fast');
                $('.submit').fadeOut('fast');
            }
            else {$('#emailError').fadeOut('fast');}
            
            if (data.indexOf("passwordError") != -1){
                $('#invalidPassError').fadeIn('fast');
                $('.submitOverlay').fadeOut('fast');
                $('.submit').fadeOut('fast');
            }
            else {$('#invalidPassError').fadeOut('fast');}
            
            if (data.indexOf("passwordMatchError") != -1){
                $('#passMatchError').fadeIn('fast');
                $('.submitOverlay').fadeOut('fast');
                $('.submit').fadeOut('fast');
            }
            else {$('#passMatchError').fadeOut('fast');}
            
            if (data.indexOf("blankError") != -1){
                $('#blankError').fadeIn('fast');
                $('.submitOverlay').fadeOut('fast');
                $('.submit').fadeOut('fast');
            }
            else {$('blankError').fadeOut('fast');}
            
            
            // If there are no errors then move the user to the next page
            if (data=='success'){
                window.location.replace("profileImage.php");
            }
        }
    );
}

/** Validation functions **/

// Validate email using a regular expression
function validateEmail(){
    var regEmail = (/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);    
    
    if(regEmail.test(this.value)){
        $('#emailError').fadeOut('fast');
        return true;
    }
    
    else {
        $('#emailError').fadeIn('fast');
        return false;
    }
}

// Validate password, much meet 5 character criteria
function validatePass1(){    
    if (this.value.length > 4){
        $('#invalidPassError').fadeOut('fast');
        return true;
    }
    
    else {
        $('#invalidPassError').fadeIn('fast');
        return false;
    }
}

// Validate confirm password by comparing it to the first one and ensuring they are identical
function validatePass2(){
    var pass = $('#joinPassword');
    
    if (pass.val() == this.value){
        $('#passMatchError').fadeOut('fast');
        return true;
    }
    
    else {
        $('#passMatchError').fadeIn('fast');
        return false;
    }
}

/** Create and delete a group **/

// Create a group by using a php file
function createGroup(){
    // Stop php file from running
    event.preventDefault();
    event.stopPropagation();

    // Get data and URL
    var data = $("form#createGroupForm").serialize();
    var url = $("form#createGroupForm").attr('action');
    $('#createGroupName').val('');
    $('#createGroupDescription').val('');
    $('#createGroupEmails').val('');
        
    // Show user that request is being submitted to compensate for wait time
    $('#createGroupBox').fadeOut('fast');
    $('.overlay').fadeOut('fast');
    $('.submitOverlay').fadeIn('fast');
    $('.submit').fadeIn('fast');
    
    
    // AJAX to create a new group
    $.post (url, data,
        function(data){
        	
            // Check for each error
            if (data.indexOf("emailError") != -1){
            	$('.submitOverlay').fadeOut('fast');
            	$('.submit').fadeOut('fast');
            	$('#createGroupBox').fadeIn('fast');
            	$('.overlay').fadeIn('fast');
                $("#createGroupInvalidEmail").fadeIn('fast');
            }
            else{
                $("#createGroupInvalidEmail").fadeOut('fast');
            }                
            if (data.indexOf("blankError") != -1){
            	$('.submitOverlay').fadeOut('fast');
            	$('.submit').fadeOut('fast');
            	$('#createGroupBox').fadeIn('fast');
            	$('.overlay').fadeIn('fast');
                $("#createGroupEmptyField").fadeIn('fast');
            }
            else{
                $("#createGroupEmptyField").fadeOut('fast');
            }
            if (data==''){window.location.reload();}
        }
    );
}

// Delete a group using a php file
function deleteGroup(){
    // Get group ID, construct data, and pop up a confirmation
    var id = this.id;
    id = id.replace("groupDelete", "");
    var dataToSend = {groupID : id};
    var confirmation = confirm("Are you sure you want to delete this group?");
    if (confirmation == false){return}
    
    // AJAX post to remove the group 
    $.ajax({
        type:    "POST",
        url:     "php/removeGroup",
        data:    dataToSend,
        success: function(){window.location.reload();}
    });
}

/** Group admin's privileges **/

// Leave a group using a php file
function leaveGroup(){
    // Get ID and construct data to send
    var id = $('.container').attr('id');
    id = id.replace("specificGroup", "");
    var dataToSend = {groupID: id};

    // Send a confirmation
    var confirmation = confirm("Are you sure you want to leave this group?");
    if (confirmation == false){return}
    
    // AJAX post to leave group php file
    $.ajax({
        type:    "POST",
        url:     "php/membershipFiles/leaveGroup.php",
        data:    dataToSend,
        success: function(){window.location.replace("groups.php");}
    });
}

// Admin's privilege to remove a member by using a php file
function removeMember(){
    // Get ID and email and construct data to send
    var id = $('.container').attr('id');
    id = id.replace("specificGroup", "");
    var email = this.id;
    email = email.replace("specificGroup", "");
    var dataToSend = {groupID: id, email: email};
    
    // Send a confirmation 
    var confirmation = confirm("Are you sure you want to delete this member?");
    if (confirmation == false){return}
    
    // AJAX post to delete member php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/deleteMember",
        data:     dataToSend,
        success:  function(){window.location.reload();}
    });
}


// Function to edit group 
function editGroup(event){
    // Stop php file from running
    event.preventDefault();
    event.stopPropagation();

    // Get data and URL
    var data = $("form#editGroupForm").serialize();
    var url = $("form#editGroupForm").attr('action');
    var groupID = $(".container").attr('id');
    groupID = groupID.replace("specificGroup", "");
    
    // Check for empty values
    if ($("#editGroupName").val()=="" || $("#editGroupDescription").val()==""){
        $('#createGroupEmptyField').fadeIn('fast');
    }
    else {
        $('#createGroupEmptyField').fadeOut('fast');
        
        // AJAX post to edit group php file
        $.ajax({
            type:    "POST",
            url:     "php/editGroup.php",
            data:    data,
            success: function(data){window.location.reload();}
        });
    }
} 

// Function to change admin
function changeAdmin(){
    // Get email and group ID and construct data to send
    var email = this.id;
    email = email.replace("specificGroupPromote", "");
    id = $('.container').attr('id');
    groupID = id.replace("specificGroup", "");
    dataToSend = {email: email, groupID: groupID};
    
    // AJAX post to change admin php file
    $.ajax({
        type:    "POST",
        url:     "php/changeAdmin.php",
        data:    dataToSend,
        success: function(data){window.location.reload();}
    });
}
    

// Invite new members to a group
function inviteMembers(){
    // Stop php file from running
    event.preventDefault();
    event.stopPropagation();

    // Get ID, emails, and url
    var groupID = $('.container').attr('id');
    groupID = groupID.replace("specificGroup", "");
    var emails = $('#inviteForm :input').val();
    var url = $("form#inviteForm").attr('action');
    
    // Construct data to send
    var dataToSend = {emails: emails, groupID: groupID};
    $('#inviteEmails').val('');
    
    // Show user that request is being submitted to compensate for wait time
    $('#inviteBox').fadeOut('fast');
    $('.overlay').fadeOut('fast');
    $('.submitOverlay').fadeIn('fast');
    $('.submit').fadeIn('fast');
    
    // AJAX post to invite php file
    $.ajax({
        type:       "POST",
        url:        "php/membershipFiles/invite.php",
        data:       dataToSend,
        success:    function(data){
                        if(data.indexOf("emailError") != -1){
                            $('.submit').fadeOut('fast');
                            $('.submitOverlay').fadeOut('fast');
                            $('#inviteBox').fadeIn('fast');
                            $('.overlay').fadeIn('fast');
                            $("#inviteEmailError").fadeIn('fast');
                        }
                        else{$("#inviteEmailError").fadeOut('fast');}
                        
                        if(data==""){
                            $('#inviteBox').fadeOut('fast');
                            $('.overlay').fadeOut('fast');
                            $(':input','#inviteForm')
                            .removeAttr('inviteEmails');  
                            window.location.reload();
                        }                
                    }
    });
}


// Permit a request from a user
function permitRequest(){
    // Get email and groupID
    var email = this.id;
    email = email.replace("permit", "");
    var id = $('.container').attr('id');
    var groupID = id.replace("specificGroup", "");
    
    // Construct data to send
    var dataToSend = {emailToBePermitted: email, groupID: groupID};
    
    // AJAX post to permit request php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/permitRequest",
        data:     dataToSend,
        success:  function(data){window.location.reload();}
    });
}

// Deny a request from a user
function denyRequest(){
    // Get email and groupID
    var email = this.id;
    email = email.replace("deny", "");
    var id = $('.container').attr('id');
    var groupID = id.replace("specificGroup", "");
    
    // Construct data to send
    var dataToSend = {emailToBeDenied: email, groupID: groupID};
    
    // AJAX post to deny request php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/denyRequest",
        data:     dataToSend,
        success:  function(data){window.location.reload();}
    });
}    


/** User profile information **/

// Present the current user's information 
function showProfile(){
    event.stopPropagation();
    $('#profilePopover').html('').load("profile.php").fadeIn('fast');
    $('.overlay').fadeIn('fast');
}

// Close out the profile popover
function hideProfile(){
    $("#profilePopover").html('').fadeOut("fast");
    $("#editProfilePopover").html('');
    $('.overlay').fadeOut('fast');
}

// Change the popover to be editable
function showEditProfile(){
    event.stopPropagation();
    $("#profilePopover").html('').fadeOut('fast');
    $("#editProfilePopover").load("profileEdit.php").html('');
}

// Change the information 
function editProfile(event){
    // Stop php file from running
    event.preventDefault();
    // Create data form form and get action
    var data = $("form#editProfileForm").serialize();
    var url = $("form#editProfileForm").attr('action');
    
    if($("#joinFirst").val()=="" || $("#joinLast").val()=="" || $("#joinPhone").val()==""){
        $('#blankError').fadeIn('fast');
        return;
    }
    else{
        $('#blankError').fadeOut('fast');
    }
    
    // Use AJAX post to prevent refresh of page
    $.post (url, data,
        function(data) {                   
            // Check for each error in the return data and present error windows accordingly
            if (data.indexOf("passwordError") != -1){
                $('#invalidPassError').fadeIn('fast');
            }
            else {$('#invalidPassError').fadeOut('fast');}
            
            if (data.indexOf("passwordMatchError") != -1){
                $('#passMatchError').fadeIn('fast');
            }
            else {$('#passMatchError').fadeOut('fast');}
            
            if (data.indexOf("blankError") != -1){
                $('#blankError').fadeIn('fast');
            }
            else {$('blankError').fadeOut('fast');}
            
            
            // If there are no errors then move the user to the next page
            if (data==''){window.location.reload();}
        }
    );
}
  
/** Miscellaneous group stuff **/

// Add group function
function groupAdd(){
    // Get group ID and construct data to send
    var groupID = this.id;
    groupID = groupID.replace("groupAdd", "");
    var dataToSend = {groupID: groupID};
    
    // AJAX post to request admission php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/requestAdmission",
        data:     dataToSend,
        success:  function(data){window.location.reload();}  
    });
}

function specificGroupAdd(){
    // Get group ID and construct data to send
    var groupID = $('.container').attr('id');
    groupID = groupID.replace("specificGroup", "");
    var dataToSend = {groupID: groupID};
    
    // AJAX post to request admission php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/requestAdmission",
        data:     dataToSend,
        success:  function(data){window.location.reload();}  
    });
}

    
// Function to accept invitation
function acceptInvitation(){
    // Get group ID and construct data to send
    var groupID = this.id;
    groupID = groupID.replace("groupAccept", "");
    var dataToSend = {groupID: groupID};
    // AJAX post to accept invitation php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/acceptInvitation",
        data:     dataToSend,
        success:  function(){window.location.reload();}
    });
}    
    
// Function to decline invitation
function declineInvitation(){
    // Get group ID and construct data to send
    var groupID = this.id;
    groupID = groupID.replace("groupDecline", "");
    var dataToSend = {groupID: groupID};
    
    // AJAX post to decline invitation php file
    $.ajax({
        type:     "POST",
        url:      "php/membershipFiles/declineInvitation",
        data:     dataToSend,
        success:  function(){window.location.reload();}
    });
}    

// Load feed selection popover
function loadFeedSelection(){
    event.preventDefault();
    event.stopPropagation();
    $('.overlay').fadeIn('fast');    
    $("#profilePopover").html('').load("groupSelect.php").fadeIn('fast');
}
    
// Move to a certain feed page
function moveToFeedPage(){
    var groupID = this.id;    
    window.location.replace("feed.php?groupID=" +groupID);
}

/** Post stuff **/

// Function for new post
function newPost(){
    // Stop php file from running
    event.preventDefault();
    
    // Get message and construct data to send
    var message = $('#postForm :input').val();
	$('#postContent').val("");
    dataToSend = {message: message}
    
    // Show user that request is being submitted to compensate for wait time
    $('#postBox').fadeOut('fast');
    $('.overlay').fadeOut('fast');
    $('.submitOverlay').fadeIn('fast');
    $('.submit').fadeIn('fast');
    
    // AJAX post to new post php file
    $.ajax({
        type:     "POST",
        url:      "php/newPost.php",
        data:     dataToSend,
        success:  function(data){window.location.reload();}
    });
}

// Function to ignore flage    
function ignoreFlag(){
    // Get post ID and construct data to send
    var postID = this.id;
    postID = postID.replace("ignore", "");
    var dataToSend = {postID: postID};
    
    // AJAX post to remove flag php file
    $.ajax({
        type:     "POST",
        url:      "php/removeFlag.php",
        data:     dataToSend,
        success:  function(data){window.location.reload();}
    });
}

// Delete a post
function deletePost(){
    // Get postID and construct data
    var rawID = this.id;
    postID = rawID.replace("delete", "");
    var dataToSend = {postID: postID};
    
    // Make user confirm delete
    var confirmation = confirm("Are you sure you want to delete this post?");
    if (confirmation == false){return}
    
    // AJAX post to delete post php file
    $.ajax({
        type:     "POST",
        url:      "php/deletePost.php",
        data:     dataToSend,
        success:  function(data){window.location.reload();}
    });
}    

// Flag a post
function flagPost(){
    // Get post ID and construct data to send
    var rawID = this.id;
    postID = rawID.replace("flag", "");
    $(this).addClass('active');
    var dataToSend = {postID: postID};
    
    // AJAX post to flag post php file
    $.ajax({
        type:     "POST",
        url:      "php/flagPost.php",
        data:     dataToSend,
        success:  function(data){}
    });
} 