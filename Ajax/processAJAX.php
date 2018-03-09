<?php 

	session_start();

	//Si aucun user n'est connecté, vers la page de connexion.
	if (empty($_SESSION['id'])) {
		header('location: ../index.php/candidat');
		exit();
	}

	require_once('../autoload.php');
	require('../arrayFunctions.php');

	$dem = new DayEntryManager();
	$em = new EntryManager();
	$cm = new CategoryManager();
		
	//Placeholders

		$start = !empty($_POST['d_start'])?$_POST['d_start']:null;
		$_POST['d_end'] = !empty($_POST['d_end'])?$_POST['d_end']:$start;

		//Représente les indexes nécéssaires à la création d'une DayEntry.
			$d_indexes = ["d_start", "d_end","theme"];

			//Si rien n'a pu être effectué, message d'erreur.
			$display = ["Hmmm, rien ne semble avoir ete trouve ici.", "error" => emptyPostCount($d_indexes)];


	// POST REQUEST
		//[DELETE - DayEntry]Supprime une entrée de la base.
			if (!empty($_POST['delete'])) {
				if ($_POST['delete'] == 'day') {
					$dem->delete($_SESSION['id'], $_POST['d_start']);
					$display = "Entree effacee.";
				}
			}

		//[ADD/EDIT - DayEntry]Ajout d'entrée.
			else if (emptyPostCount($d_indexes) == 0) {
				$data = quickPost($d_indexes);
				$data['account_id'] = $_SESSION['id'];

				//[ADD]Vérifie qu'aucune entrée ne soit déjà présente. 
				$d_entry = $dem->get($_SESSION['id'], $_POST['d_start']);

				if (empty($d_entry)){
					$d_entry = new DayEntry($data);
					$dem->add($d_entry);
					$ref = $dem->getLast($_SESSION['id'])['MAX(id)'];
				} else {
					$ref = $d_entry['id'];
					//[EDIT]Modifie l'entrée si nécéssaire.
					$d_entry = new DayEntry($d_entry);
					$d_entry->setTheme($data['theme']);
					$dem->update($d_entry);
				}

				// $display = "Entree ajoutee.";

				//[ADD - Entry]
				switch ($_POST['theme']) { 
					case 'Mixte':
						//Entrées "horaire"
						if (!empty($_POST['activite'])) {
							foreach ($_POST['activite'] as $key => $value) {
								$activite = !empty($value)?$value:'Abs';
								$end = date('', strtotime($_POST['e_start'][$key])+3600);

								$e_entry = new Entry([	"de_fk" 	=> $ref,
													 	"activite"	=> $activite,
													 	"e_start"	=> $_POST['e_start'][$key],
													 	"e_end" 	=> $end,
													 	"content"	=> $_POST['content'][$key] ]);
								$em->add($e_entry);
							}
						}


						break;
					case 'Stage':
						$start = strtotime($_POST['d_start']);
						$end = strtotime($_POST['d_end']);
						$days = floor(($start-$end)/(24*3600));
						break;
				}
			}



	//GET REQUEST
		if (!empty($_GET)) {
			$display = [];
			
			if (!empty($_GET['e_id'])) {
				$display['entry'] = $em->getAllByDay($_GET['e_id']);

				foreach ($display['entry'] as $value) {
					$display[$value['activite']]['color'] = $cm->get($value['activite'])['color'];
					$value['content'] = strip_tags($value['content']);

				}
			}

			if (!empty($_GET['attr'])){
				$display['color'] = $cm->get($_GET['attr'])['color'];
			}			
		}


		


	//Permet d'afficher un retour en JSON.
	echo json_encode($display);

 ?>