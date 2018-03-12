<?php 
	session_start();
	require "../autoload.php";

	//Managers
	$cm = new CategoryManager();
	$dm = new DayEntryManager();

	$json = [];

	//Récupération des thèmes existants
	foreach ($cm->getAllThemes() as $key => $value) {
		$json['themes']['name'][] = $value['initials'];
		$json['themes']['color'][] = $value['color'];

		//Récupération du nombre de jours associés à ce thème
		$json['themes']['days'][] = $dm->getCountByTheme($value['name'], $_SESSION['id']);
	}

	

	echo json_encode($json);

 ?>