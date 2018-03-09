<?php 
	require_once('../autoload.php');

	$cm = new CategoryManager();
	$data = $cm->getAllThemes();
	$dat_act = $cm->getAllActivites();

	$info = null;
	$themes = null;
	$act = null;

	//
	if (empty($data)){
		#code to alert nothing was found
	} else {
		foreach ($data as $theme) {
			$themes .= "<div class='row'>
								<div class='name'>{$theme['name']}</div>
								<div class='name'>{$theme['initials']}</div>
								<div class='color' style='background-color: {$theme['color']};'></div>	
							</div> ";
		}
	}

	if (empty($dat_act)){
		#nothing was found
	} else {
		foreach ($dat_act as $activite) {
			$act .= "<div class='row'>
								<div class='name'>{$activite['name']}</div>
								<div class='name'>{$activite['initials']}</div>
								<div class='color' style='background-color: {$activite['color']};'></div>	
							</div> ";
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Gestion de catégories</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="gestion.css">
	<link rel="stylesheet" href="../Assets/newNav.css">
</head>
<body>
	<nav>
		<?php 
			if (file_exists('../../includes/nav.php')) {
				include '../../includes/nav.php';
			}
		?>
	</nav>
	<h1>Gestion des catégories</h1>

	<h2>Thèmes journaliers</h2>
	<div class="ctn">
		
		<div class="row title">
			<div class='name'>Nom</div>
			<div class='name'>Initiales</div>
			<div class='color'>Couleur</div>
		</div>
		<div class="ctn-ajax">
			<?= $themes ?>
		</div>
	</div>	

	<h2>Activités</h2>
	<div class="ctn">
		
		<div class="row title">
			<div class='name'>Nom</div>
			<div class='name'>Initiales</div>
			<div class='color'>Couleur</div>
		</div>
		<div class="ctn-ajax">
			<?= $act ?>
		</div>
	</div>

	<br>
	
	<footer>
		<button>Ajouter une nouvelle catégorie</button>
	</footer>
</body>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../Assets/anim.js"></script>
	<script type="text/javascript" src='gestion.js'></script>
</html>