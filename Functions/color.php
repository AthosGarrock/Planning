<?php 

	//Permet d'appliquer une valeur seuil de 255. - Indispensable pour maintenir un code cohérent!
	function maxSat($value){
		if ($value > 255) {
			return 255;
		} else {
			return $value;
		}
	}

	//'Accroit la 'quantité' de couleur dans le pixel
	function upSat($base, $add){
		return dechex(maxSat(hexdec($base)+$add));
	}

	//Fonction ayant pour but d'éclaircir une teinte.
	function lighten($hex, $add){
		$hex = substr($hex, '1');

		$red 	= upSat($hex[0].$hex[1], $add);
		$green	= upSat($hex[2].$hex[3], $add);
		$blue	= upSat($hex[4].$hex[5], $add);

		return '#'.$red.$green.$blue;
	}

 ?>