$(document).ready(function() {
	$('#loginForm').submit(function() {
		login(event);
	});
	$('#joinForm').submit(function() {
	    newAccount(event);
	});
	$('#email').blur(validateEmail);
	$('#email').keyup(validateEmail);
	
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
            if (data=="exists"){
                $('#creationError').fadeIn('fast');
            }
            else {
                window.location.replace("groups.html"); 
            }
        }
    );
}

// Validate email
function validateEmail()
{
    var regex = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{0,4}$/;    
    if(regex.test(this.value)){
        $('#creationError').fadeOut('fast');
        return true;
    }
    else {
        $('#creationError').fadeIn('fast');
        return false;
    }
}

function validatePassword1()
{
    
}
    
    
    
    
    
    
    
    