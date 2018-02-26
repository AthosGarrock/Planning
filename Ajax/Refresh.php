<?php 
	//This page solely exist for the purpose of refreshing the calendar.
	
		session_start();
	//Autoloader. Les Objets et leurs Managers sont automatiquement appelés si nécéssaire.
		require_once('../autoload.php');

	//Fonctions appelées
		require('../Functions/color.php');

	//Managers. Gestion de la BDD.
    $dem = new DayEntryManager();
    $data = $dem->getAllThemes($_SESSION['id']);

    echo new Calendar($data);

 ?>