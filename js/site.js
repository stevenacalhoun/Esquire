$(document).ready(function() {
	$('#loginForm').submit(function() {
		login(event);
	});
	$('#joinForm').submit(function() {
	    newAccount(event);
	});
	
//	$('#email').blur(validateEmail);
//    $('#password').blur(validatePass1);
//    $('#confirmPassword').blur(validatePass2);
    	
	
});

// AJAX function for login. Checking to see if correct login.
function login(event)
{
	event.preventDefault();
	var data = $("form#loginForm").serialize();
	var url = $('form#loginForm').attr('action');
	
	$.post(url, data,
		function(data) {
	        console.log(data);
            if (data=="success"){
                window.location.replace("groups.html");
		    }
		    else {
                $('#loginError').fadeIn('fast');
		    }
	    }
	);
}


// Function to ensure during account creation the email has not been taken
function newAccount(event)
{
    event.preventDefault();
    var data = $("form#joinForm").serialize();
    var url = $("form#joinForm").attr('action');
    
    $.post (url, data,
        function(data) {
            console.log(data);
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
            else {
//                $('#creationError').fadeOut('fast');
//                $('#emailError').fadeOut('fast');
//                $('invalidPasswordError').fadeOut('fast');
                $('#passMatchError').fadeOut('fast');
                
                //window.location.replace("groups.html"); 
            }
        }
    );
}

// Validate email
function validateEmail()
{
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

function validatePass1()
{
    console.log(this);
    if (this.value.length > 4){
        $('#invalidPassError').fadeOut('fast');
        return true;
    }
    else {
        $('#invalidPassError').fadeIn('fast');
        return false;
    }
}

function validatePass2()
{
    var pass = $('#password');
    console.log(this.value);
    console.log(pass.val());
    if (pass.val() == this.value){
        $('#passMatchError').fadeOut('fast');
        return true;
    }
    else {
        $('#passMatchError').fadeIn('fast');
        return false;
    }
}
    
    
    
    
    
    
    