<?php 

	// if ($_SESSION['type'] != 'Admin') {
	// 	header('location: index.php');
	// }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Choix de l'utilisateur.</title>
	<meta charset="utf-8">
	<style>
		*{font-family: Verdana;}
		.focus{
			background-color: #2626ad;
			color: white;
		}
		ul{
			list-style-type: none;
			padding: 0;
			margin: 0;
		}
	</style>
</head>
<body>
	<form action="">
		<input id="name" type="text" autocomplete="off" placeholder="Nom ou prénom du stagiaire..." name="name" >
		<ul id="autocomplete"></ul>
		<input type="submit" value="Accéder!">
	</form>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		{
		let i = -1; //Focus on input by default
		let results = [];

			//prevents form to be sent when selecting
			// $(document).on("keyup keydown", function(e){
			// 	if(e.which == 13 && $('.focus').length > 0){
			// 		e.preventDefault();
			// 		$('#name').val($('.focus').text());
			// 	}
			// })

			$(document).keyup(function(e) {	
				switch(e.which){
					case 38:
					case 40:
						// Prevent them being used by default.
						break;
					case 13:
				 		$('#name').val($('.focus').text());
						break;
					default:
						i = -1;
						let val = $('input[type=text]').val();
						$('#autocomplete').load('../Ajax/nameList.php', {name: val}, function(){
							results = Array.from($('#autocomplete li'));
						});
						
				}	
			});

			$(document).keydown(function(e) {
				switch(e.which){
					case 38:
						if (i > -1) {
							$(results[i]).removeClass('focus');	
							$(results[--i]).addClass('focus');
							//Gain focus
							if(i == -1){
								$('#name').focus();
							}
						};
						break;
					case 40:	
						if (i < results.length-1) {
							$(results[i]).removeClass('focus');		
							$(results[++i]).addClass('focus');
						}
						//exit focus
						if(i != -1){
							$('#name').blur();
						}
						break;
				}
			});
			}
	</script>
</html>