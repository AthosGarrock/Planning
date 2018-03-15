<?php 
	
	require_once('../autoload.php');
	require_once('../arrayFunctions.php');

	//Fields for update
	$u_fields = ['e_name', 'e_initials'];
	//Fields for adding
	$a_fields = ['name', 'ini', 'type', 'color'];

	$cm = new CategoryManager();

	//[DELETE]Delete Cateory
	if(!empty($_POST['del_id'])){
		$cm->delete($_POST['del_id']);
	} 
	//[EDIT/UPDATE]Update Category
	else if(emptyPostCount($u_fields) != count($u_fields)){

		$categories = [];

		foreach ($u_fields as $index) {
			if (!empty($_POST[$index])) {
				foreach ($_POST[$index] as $key => $value) {
					$categories[$key][$index] = $value;
				}
			}
		}

		foreach ($categories as $key => $data) {
			$ctg = $cm->get($key);

			//Attribution des valeurs
			foreach ($data as $key => $value) {
				$attr = ucfirst(substr($key, '2'));
				$method = 'set'.$attr;

				$ctg->$method($value);
			}
			
			$cm->update($ctg);
		}

	}

	//[ADD] Nouvelle Catégorie
	else if (emptyPostCount($a_fields) == 0) {
		$category = new Category([	'name'=>$_POST['name'],
									'initials'=>$_POST['ini'],
									'type'=>$_POST['type'],
									'color'=>$_POST['color']]);
		$cm->add($category);	
		}

	echo json_encode($cm->getAll());

 ?>