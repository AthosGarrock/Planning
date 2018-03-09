<?php 
	
	require_once('../autoload.php');

	$cm = new CategoryManager();

	if (!empty($_POST)) {
		$category = new Category([	'name'=>$_POST['name'],
									'initials'=>$_POST['ini'],
									'type'=>$_POST['type'],
									'color'=>$_POST['color']]);

		$cm->add($category);
		echo json_encode($cm->getAll());
	}



 ?>