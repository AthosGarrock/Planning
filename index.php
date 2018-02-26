<?php 
	//DEBUG VARS
	if (!ini_get('display_errors')) {
   		 ini_set('display_errors', '1');
	}
	session_start();

	//For localhost testing only.
		// $_SESSION['id'] = 2147483647;

	var_dump($_SESSION['id']);

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

    $data = $dem->getAllThemes($_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Planning Beta</title>
	<link rel="stylesheet" href="<?= ROOT ?>/Assets/style.css">
	<link rel="stylesheet" href="<?= ROOT ?>/Assets/newNav.css">

	<link rel="stylesheet" href="../css/font-awesome.css">

	<!-- User-generated themes/types colors -->
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
	<h1>CE CONTENU EST ENCORE EN DEVELOPPEMENT</h1>
	<nav>
		<?php 
			if (file_exists('../includes/nav.php')) {
				include '../includes/nav.php';
			}		
		 ?>
	 </nav>
	<main>
		<?php 
			echo new Calendar($data);
		?> 	
	</main>
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
				
		<!-- 				<textarea name="content" placeholder="Détaillez votre activité..."></textarea> -->

				<input type="submit" value="Valider">
			</form>
		</div>	
	</section>
</body>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?= ROOT ?>/entry.js"></script>
<script type="text/javascript" src="<?= ROOT ?>/Assets/anim.js"></script>
</html>