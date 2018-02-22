<?php 
	#Constante définissant le dossier racine du projet.
	define('ROOT', '/apprentis/Projet');
	// define('ROOT', '/Projet');

	spl_autoload_register(function($required){
		if (preg_match('#(Manager)$#', $required)) {
			require_once "Classes/Managers/{$required}.php";
		} else{
			require_once "Classes/{$required}.php";
		}
		
	})

?>