<?php 
/**
 * @param [string index1, string index2, ...]
 * 
 * @return int $i == number of empty indexes
 */
function emptyPostCount(array $array){
	$i = 0;
	foreach ($array as $value) {
		if (empty($_POST[$value])) {
			$i++;
		}
	}
	return $i;
}

/**
 * @param [string index1, string index2, ...]
 * 
 * @return int $i == number of empty indexes
 */
function emptyGetCount(array $array){
	$i = 0;
	foreach ($array as $value) {
		if (empty($_GET[$value])) {
			$i++;
		}
	}
	return $i;
}



/**
 * @param [string index1, string index2, ...]
 * 
 * @return [index1 => $_POST[index1], index2 => $_POST[index2], ...]
 */
function quickPost(array $array){
	$converted = [];
	
	foreach ($array as $value) {
		$converted[$value] = $_POST[$value];
	}

	return $converted;
}


/**
 * @param [string index1, string index2, ...]
 * 
 * @return [index1 => $_GET[index1], index2 => $_GET[index2], ...]
 */
function quickGet(array $array){
	$converted = [];
	
	foreach ($array as $value) {
		$converted[$value] = $_GET[$value];
	}

	return $converted;
}




?>