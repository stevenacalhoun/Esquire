$(document).ready(function() {
	$('#loginForm').submit(function() {
		login(event);
	});
	$('#joinForm').submit(function() {
	    newAccount(event);
	});
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
            