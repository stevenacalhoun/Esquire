$(document).ready(function() {

    /** Login, join, logout, and validation **/
    
    // Sniffer for login submit
	$('#loginForm').submit(function() {
		login(event);
	});
	
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
    
    // Sniffer for profile cancel click    
    $('#profileCancel').click(hideProfile);
    $('#editProfileCancel').click(hideProfile);
    
    
    /** Group functions **/
    
    // Sniffer for creating a new group and canceling group
    $('#groupCreate').click(function(){$('#createGroupOverlay').fadeIn('fast'); $('#createGroupBox').fadeIn('fast');});
    $('#createGroupCancel').click(
        function(){
            $('#createGroupOverlay').fadeOut('fast');
            $('#createGroupBox').fadeOut('fast');
            $("#createGroupInvalidEmail").fadeOut('fast');
            $("#createGroupEmptyField").fadeOut('fast');
        }
    );
    $('#createGroupCreate').click(createGroup);
    
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
    
    
    /** Group's admin privileges **/
    
    // Sniffer for remove member click 
    $('.specificGroupRemove').click(removeMember);
    
    // Sniffer for edit profile click
    $('#profileEdit').click(editProfile);
    
    // Sniffer for admin edit group button and cancel
    $('.specificGroupEdit').click(
        function(){
            $('#editGroupBox').fadeIn('fast'); 
            $('.overlay').fadeIn('fast');
        }
    );
    $('#editGroupCancel').click(
        function(){
            $('#editGroupBox').fadeOut('fast');
            $('.overlay').fadeOut('fast');
        }
    );
    
    // Sniffer for admin invite member button and cancel
    $('#specificGroupAdd').click(
        function(){
            $('#inviteBox').fadeIn('fast');
            $('.overlay').fadeIn('fast');
        }
    );
    $('#inviteCancel').click(
        function(){
            $('#inviteBox').fadeOut('fast');
            $('.overlay').fadeOut('fast');
        }
    );
});


/** Login and join functions **/

// AJAX function for login. Checking to see if correct login.
function login(event){
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


// Function that handles the returns of php validation and moving user to next page upon successful account creation
function newAccount(event){
    event.preventDefault();
    
    // Create data form form and get action
    var data = $("form#joinForm").serialize();
    var url = $("form#joinForm").attr('action');
    
    if($("#joinFirst").val()=="" || $("#joinLast").val()=="" || $("#joinPhone").val()==""){
        $('#blankError').fadeIn('fast');
    }
    else{
        $('#blankError').fadeOut('fast');
    }
    
    // Use AJAX post to prevent refresh of page
    $.post (url, data,
        function(data) {       
            console.log(data);     
            // Check for each error in the return data and present error windows accordingly
            if (data.indexOf("exists") != -1){
                $('#creationError').fadeIn('fast');
            }
            else {$('#creationError').fadeOut('fast');}
            
            if (data.indexOf("emailError") != -1){
                $('#emailError').fadeIn('fast');
            }
            else {$('#emailError').fadeOut('fast');}
            
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
            if (data==''){window.location.replace("groups.php");}
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
    event.preventDefault();
    
    var data = $("form#createGroupForm").serialize();
    var url = $("form#createGroupForm").attr('action');
    
    //if($("#createGroupName".val=="" || $("createGroupDescription").val==""
    
    $.post (url, data,
        function(data){
            console.log(data);
            // Check for each error
            if (data.indexOf("emailError") != -1){
                $("#createGroupInvalidEmail").fadeIn('fast');
            }
            else{
                $("#createGroupInvalidEmail").fadeOut('fast');
            }                
            if (data.indexOf("blankError") != -1){
                $("#createGroupEmptyField").fadeIn('fast');
            }
            else{
                $("#createGroupEmptyField").fadeOut('fast');
            }
            if (data==''){window.location.replace("groups.php");}
        }
    );
}

// Delete a group using a php file
function deleteGroup(){
    var id = this.id;
    var dataToSend = {groupID : id};
    $.ajax({
        type:    "POST",
        url:     "php/removeGroup",
        data:    dataToSend,
        success: function(){window.location.replace("groups.php");}
    });
}

/** Group admin's privileges **/

// Leave a group using a php file
function leaveGroup(){
    var id = $('.container').attr('id');
    var dataToSend = {groupID: id};
    console.log(id);
    $.ajax({
        type:    "POST",
        url:     "php/leaveGroup.php",
        data:    dataToSend,
        success: function(){window.location.replace("groups.php");}
    });
}

// Admin's privilege to remove a member by using a php file
function removeMember(){
    var id = $('.container').attr('id');
    var email = this.id;
    var dataToSend = {groupID: id, email: email};
    $.ajax({
        type:     "POST",
        url:      "php/deleteMember",
        data:     dataToSend,
        success:  function(){window.location.reload();}
    });
}

// Admin's privilege to add a member by using a php file
function addMember(){
    $("htmladf").appendTo(".specificGroupBlock").page();
}

/** User profile information **/

// Present the current user's information 
function showProfile(){
    $('.dynamicPopover').html('').load("profile.php").fadeIn('fast');
    $('.overlay').fadeIn('fast');
}

// Close out the profile popover
function hideProfile(){
    $(".dynamicPopover").html('').fadeOut("fast");
    $('.overlay').fadeOut('fast');
}

// Change the popover to be editable
function editProfile(){
    $(".dynamicPopover").html('').fadeOut("fast");
    $(".dynamicPopover").html('').load("profileEdit.php").fadeIn('fast');
}
