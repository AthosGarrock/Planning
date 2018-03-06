$(function(){
	$( "#uname" ).autocomplete({
			delay: 500,
			minLength: 2,
			source: function(request, response){
				$.getJSON('Ajax/nameList.php', {name: request.term} ,function(data) {
					response(data);
				});
			},
	});	
})
