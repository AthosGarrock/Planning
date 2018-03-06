<?php 
	session_start();	
	require('../autoload.php');

	if (!empty($_GET['back'])) {
		unset($_SESSION['id_info']);
		redirect('access.php');
	}

	if ($_SESSION['type'] != 'Admin') {
		redirect('../index.php');
	}


	if (!empty($_POST['name'])) {
		$am = new AccountManager();
		if ($_SESSION['id_info'] = $am->getId($_POST['name'])) {
			redirect('../index.php');
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Choix de l'utilisateur.</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
	<form action="" method="POST">
		<input id="name" type="text" autocomplete="off" placeholder="Nom ou prénom du stagiaire..." name="name" >
		<input type="submit" value="Accéder!">
	</form>
</body>
	
	<script>
		$( "#name" ).autocomplete({
 			delay: 500,
 			minLength: 2,
 			source: function(request, response){
 				$.getJSON('../Ajax/nameList.php', {name: request.term} ,function(data) {
 					response(data);
 				});
 			},
		});
	</script>
</html>