<?php 

	require('../autoload.php');
	require('../arrayFunctions.php');

	$cm = new CategoryManager();

	echo json_encode($cm->getAllActNames());

?>