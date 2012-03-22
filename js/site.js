$(document).ready(function() {
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
    
    // Sniffer for creating a new group and canceling group
    $('#groupCreate').click(function(){$('#createGroupOverlay').fadeIn('fast'); $('#createGroupBox').fadeIn('fast');});
    $('#createGroupCancel').click(function(){$('#createGroupOverlay').fadeOut('fast'); $('#createGroupBox').fadeOut('fast');});
    $('#createGroupCreate').click(createGroup);
    
    // Sniffer for admin's delete group button
    $('.groupDelete').click(deleteGroup);
    
    // Sniffer for leave group
    $('#specificGroupDelete').click(leaveGroup);
    
    // Sniffer for remove member click 
    $('#specificGroupRemove').click(removeMember);
});

// AJAX function for login. Checking to see if correct login.
function login(event)
{
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
function newAccount(event)
{
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
    
    console.log($("#joinFirst").val());
    
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

// Validate email
function validateEmail()
{
    // Create regular expression to validate an email
    var regEmail = (/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);    
    
    // If it's valid remove error window
    if(regEmail.test(this.value)){
        $('#emailError').fadeOut('fast');
        return true;
    }
    
    // If invalid present the error box
    else {
        $('#emailError').fadeIn('fast');
        return false;
    }
}

function validatePass1()
{    
    // Password must be at least 5 characters, if it's valid remove error window
    if (this.value.length > 4){
        $('#invalidPassError').fadeOut('fast');
        return true;
    }
    
    // If invalid present the error box
    else {
        $('#invalidPassError').fadeIn('fast');
        return false;
    }
}

function validatePass2()
{
    // Variable for first password
    var pass = $('#joinPassword');
    
    // Passwords must be the same, if it's valid remove error window
    if (pass.val() == this.value){
        $('#passMatchError').fadeOut('fast');
        return true;
    }
    
    // If invalid present the error box
    else {
        $('#passMatchError').fadeIn('fast');
        return false;
    }
}

function createGroup()
{
    event.preventDefault();
    
    var data = $("form#createGroupForm").serialize();
    var url = $("form#createGroupForm").attr('action');
    
    //if($("#createGroupName".val=="" || $("createGroupDescription").val==""
    
    $.post (url, data,
        function(data){
            console.log(data);
            // Check for each error
            if (data.indexOf("emailError") != -1){
                $("#createEmailError").fadeIn('fast');
            }
            if (data.indexOf("blankError") != -1){
                $("#createEmptyError").fadeIn('fast');
            }
            if (data==''){window.location.replace("groups.php");}
        }
    );
}

function deleteGroup()
{
    window.location.replace("php/removeGroup.php?groupID=" + this.id);
}

function leaveGroup()
{
    var url = $(location).attr("href");
    window.location.replace("php/leaveGroup.php?groupID=" + url);
}

function removeMember()
{
    window.location.replace("php/deleteMember.php?groupID=" + hmmmm + "&email=" + this.id);
}





