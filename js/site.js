$(document).ready(function() {
	$('#loginForm').submit(function() {
		login(event);
	});
});

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
                $('#loginError').fadeIn('fast', function(){});
		    }
	    }
	);
}
