<?php 
	session_start();

	require_once('../autoload.php');
	require('../arrayFunctions.php');

	$em = new EntryManager();
	$dem = new DayEntryManager();

	$e_indexes = ["edit_activite","edit_e_start", "edit_content"];
	$entries = [];

	//[DELETE Entries]
		if (!empty($_POST['del'])) {
			foreach ($_POST['del'] as $key => $value) {
				$em->delete($key);
			}
		}
	
	//[UPDATE Entries]
		foreach ($e_indexes as $index) {
			//Get array : $entries[$id][$attribute] = $value
			if (!empty($_POST[$index])) {
				foreach ($_POST[$index] as $key => $value) {
					$entries[$key][substr($index, 5)] = $value;
				}
			}
		}

		//Modification des attributs de l'entrée
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


	//[DELETE DayEntry]
		if (!empty($_POST['d_start'])) {
			$end = !empty($_POST['d_end'])?$_POST['d_end']:null;
			$dem->delete($_SESSION['id'], $_POST['d_start'], $end);
		}

 ?>