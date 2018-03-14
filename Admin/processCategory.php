<?php 
	
	require_once('../autoload.php');

	$cm = new CategoryManager();

	//Delete day
	if(!empty($_POST['del_id'])){
		$cm->delete($_POST['del_id']);
	}
	else if (!empty($_POST)) {
		$category = new Category([	'name'=>$_POST['name'],
									'initials'=>$_POST['ini'],
									'type'=>$_POST['type'],
									'color'=>$_POST['color']]);
		$cm->add($category);	
	}

	echo json_encode($cm->getAll());

 ?>