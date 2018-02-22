<?php 
	session_start();

	require('../autoload.php');
	require('../arrayFunctions.php');

	$em = new EntryManager();
	$dem = new DayEntryManager();

	$e_indexes = ["edit_activite","edit_e_start", "edit_content"];
	$entries = [];

	foreach ($e_indexes as $index) {

		if (!empty($_POST[$index])) {
			foreach ($_POST[$index] as $key => $value) {
				$entries[$key][substr($index, 5)] = $value;
			}
		}
	}


	foreach ($entries as $key => $data) {
		//Récupère l'entrée à modifier
		$entry = $em->get($key);

		//Apporte les modifications récupérées si l'entrée appartient bien à l'user courant.
		if ($dem->getById($entry->getDeFk())['account_id'] == $_SESSION['id']) {
			foreach ($data as $key => $value) {
				$method = 'set'.ucfirst($key);
				$entry->$method($value);
				$em->update($entry);
			}	
		}
	}

 ?>