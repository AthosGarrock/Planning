<?php 
	//DEBUG VARS
	if (!ini_get('display_errors')) {
   		 ini_set('display_errors', '1');
	}
	session_start();

	if (!empty($_GET['back'])) {
		unset($_SESSION['id_info']);
	}

	//For localhost testing only.
		// $_SESSION['id'] = 2147483647;


	function get_options($array){
    	$result = null;
    	foreach ($array as $value) {
    		$value = new Category($value);
    		$result .= "<option value='{$value->getName()}'>{$value->getName(true)}</option>";
    	}

    	return $result;
    }

	
	//Autoloader. Les Objets et leurs Managers sont automatiquement appelés si nécéssaire.
		require_once('autoload.php');

	//Fonctions appelées
		require('Functions/color.php');

	//Managers. Gestion de la BDD.
    $dem = new DayEntryManager();
    $cm = new CategoryManager();

    $themes = $cm->getAllThemes();
    $activites = $cm->getAllActivites();


    $opt_themes = get_options($themes);
    $opt_act = get_options($activites);

    //Efface l'id du stagiaire selectionné.
    if (!empty($_GET['back'])) {
		unset($_SESSION['id_info']);
	}

	//Si une sélection  a été faite
	if (!empty($_POST['name'])) {
		$am = new AccountManager();

		try{
			$_SESSION['id_info'] = $am->getId($_POST['name']);
		} catch(Exception $e){
			throw new Exception("User not found", 1);
		}
	}

    $data = ($_SESSION['type'] == 'Admin' && !empty($_SESSION['id_info']))
    		?$dem->getAllThemes($_SESSION['id_info'])
    		:$dem->getAllThemes($_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Planning Beta</title>
	<!-- Style global -->
	<link rel="stylesheet" href="<?= ROOT ?>/Assets/style.css">
	<!-- Style navigateur -->
	<link rel="stylesheet" href="<?= ROOT ?>/Assets/newNav.css">
	<!-- FONT-AWESOME ( icones ) -->
	<link rel="stylesheet" href="../css/font-awesome.css">

	<!-- jQuery + UI  -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<!-- Thèmes générés par l'administrateur -->
	<style>
		<?php 
			foreach ($themes as $theme) {
				$lighter = lighten($theme['color'], 60);

			echo ".".$theme['name']."{
				background-color: {$lighter}c0 !important;
			}
			";
			}
		?>
	</style>
</head>
<body>	
	<nav>
		<?php 
			if (file_exists('../includes/nav.php')) {
				include '../includes/nav.php';
			}		
		 ?>
	</nav>	
	<?php 
		if ($_SESSION['type'] == 'Admin') {
			?>
			<div class="ftg">
				<form action="" method="POST" class="s_user">
					<input id="uname" type="text" autocomplete="off" placeholder="Nom ou prénom du stagiaire..." name="name" >
					<input type="submit" value="Accéder!">
				</form>
			<?php
			if ($_SESSION['type'] == 'Admin' AND !empty($_SESSION['id_info'])) { ?>
				<a href="?back=true">Retour</a>
	 		<?php } ?>
	 		</div>
	 		<?php
		} 
	?>

	<main>
		<?php 
			echo new Calendar($data);
		?> 	
	</main>

	<!-- STATS -->
	<section class="u-stats">
		<canvas width="250px" height="400px"></canvas>
	</section>

	<!-- ENTREE JOURNALIERE -->
	<section class="toggle">
		<div class="close" title="Fermer l'entrée">X</div>
		<div id="ctn">
			
			<div id="entry">
				<h2 class="theme_display"></h2>

				<span class="delete day-entry"><i class="fa fa-trash" title="Supprimer l'entrée"></i></span>

				<div class="entry_ctn">				
					<div class="date day-select"></div>
		<!-- 					<aside id="graph"></aside> -->

					<div id="legend"></div>
					<form id="form1">
						<div id="daydata"></div>
						<input type="submit" style="display: none;" value="Modifier/Effacer" id="erase">
					</form>

					<button class='btn-entry'></button>
				</div>
			</div>


			<!-- Formulaire -->
			<form action="" method="POST" class="enform" id="form2">
				<label for="d_start">Du:</label>
				<input type="date" class="date" readonly name="d_start">
				<label for="d_end" class="d_end">Jusqu'au</label>
				<input type="date" class="date d_end" name="d_end">
				
				<!-- Jours ( STAGE ) -->
				<fieldset class="days">
					<label for="">Lun:</label>
					<input type="checkbox" name="mon">
					<label for="">Mar:</label>
					<input type="checkbox" name="tue">
					<label for="">Mer:</label>
					<input type="checkbox" name="wed">
					<label for="">Jeu:</label>
					<input type="checkbox" name="thu">
					<label for="">Ven:</label>
					<input type="checkbox" name="fri">
					<label for="">Sam:</label>
					<input type="checkbox" name="sat">
					<label for="">Dim:</label>
					<input type="checkbox" name="sun">
				</fieldset>

				<!-- thèmes -->
				<select name="theme" id="theme">
					<option disabled selected hidden>Thème</option>
					<option>Mixte</option>
					<option>Stage</option>
					<option value="RDS">Recherche de stage (RDS)</option>
					<?= $opt_themes ?>
				</select>
				

				<!-- (MIXTE) -->
				<fieldset class="details">
					<span class="caption">Veuillez détailler vos activités :</span>
					<!-- placeholder counter - use PHP/JS-->
					<h3>Activité :</h3>
				
					<div class="add">					
						<label>De :</label>
						<select name="e_start[]">
							<optgroup label='Par demi-journée'>								
								<option value="Matin">Matin</option>
								<option value="Apres-midi">Après-midi</option>
							</optgroup>
							<optgroup label="Par heure">
								<option value="09:00">09:00</option>
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
								<option value="13:30">13:30</option>
								<option value="14:00">14:00</option>
								<option value="15:00">15:00</option>
								<option value="16:00">16:00</option>
								<option value="17:00">17:00</option>
							</optgroup>

						</select>

						<select name="activite[]" id="activite">
							<option disabled selected hidden>Thème de l'activité</option>
							<?= $opt_act ?>
						</select>

						<input type="text" name="content[]" placeholder="(Précisions)">


						<button type="button" class="add-act">+</button>
						<button type="button" class="dl-row" style="display: none;">-</button>
					</div>

				</fieldset>

				<input type="submit" value="Valider">
			</form>
		</div>	
	</section>		
</body>

<!-- JS -->
<script type="text/javascript">
	var month = <?php echo (!empty($_GET['month'])?$_GET['month']."\n":date('m')."\n"); ?>
	var year = <?php echo (!empty($_GET['year'])?$_GET['year']."\n":date('Y')."\n"); ?>
</script>
<!-- main script -->
<script src="<?= ROOT ?>/entry.js"></script>
<!-- animated navigator -->
<script type="text/javascript" src="<?= ROOT ?>/Assets/anim.js"></script>
<!-- autocompletion -->
<script type="text/javascript" src="<?= ROOT ?>/Assets/autocomplete.js"></script>
<!-- CHART.JS -->
<script type="text/javascript" src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script>
	let arr = [];
	let ctx = document.querySelector('canvas');


	for (var i = 0; i <= 20; i++) {
		arr[i] = 2*i;
	};

	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
	        datasets: [{
	            label: '# of Votes',
	            data: [12, 19, 3, 5, 2, 3],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	    	responsive: false,
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true
	                }
	            }]
	        },
	        maintainAspectRatio: true,
	    }
	});
</script>
</html>