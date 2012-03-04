$(document).ready(function() {
	$('#login').submit(function() {
		login(event);
	});
});

function login(event)
{
	event.preventDefault();
	var data = $("form#login").serialize();
	var url = $('form#login').attr('action');
	
	$.post(url, data,
		function(data) {
		    console.log(data);
		    window.location.replace("groups.html");			
		}
	);
}

//function getDashboard() {
//    $.getJSON(
//        function(data) {
//            for (var i = 0; i < count; i++) {
//                $('body').append(i.name);
//            }
//        }
//    );
//}