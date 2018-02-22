<?php 
	
	require_once('../Classes/Category.php');
	require_once('../Classes/Managers/CoreManager.php');
	require_once('../Classes/Managers/CategoryManager.php');

	$cm = new CategoryManager();

	if (!empty($_POST)) {
		$category = new Category([	'name'=>$_POST['name'],
									'type'=>$_POST['type'],
									'color'=>$_POST['color']]);

		$cm->add($category);
		echo json_encode($cm->getAll());
	}



 ?>