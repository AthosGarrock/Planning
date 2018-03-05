<?php 
	require_once('../autoload.php');

	$am = new AccountManager();


	if (!empty($_POST['name'])) {
		$data = $am->get($_POST['name']);

		foreach ($data as $value) {
			$prenom = $value['prenom'];
			$nom = $value['nom'];

			echo "<li>{$prenom} {$nom}</li>";
		}


	}

 ?>