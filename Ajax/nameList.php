<?php 
	require_once('../autoload.php');

	$am = new AccountManager();

	$results = [];

	if (!empty($_GET['name'])) {
		$data = $am->get($_GET['name']);

		foreach ($data as $value) {
			$prenom = $value['prenom'];
			$nom = $value['nom'];

			$results[] = $prenom.' '.$nom;

			// echo "<li>{$prenom} {$nom}</li>";
		}
	}

	echo json_encode($results);

 ?>