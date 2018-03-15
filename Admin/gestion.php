<?php 
	require_once('../autoload.php');

	$cm = new CategoryManager();
	$data = $cm->getAll();
	$themes = '';
	$act = '';

	if (!empty($data)) {
		foreach ($data as $ctg) {
			$name = str_replace('_', ' ', $ctg['name']);
			$content = "<div class='row zoom'>
							<div class='name' data-id='{$ctg['id']}'><span class='del' id='{$ctg['id']}'>X</span> {$name}</div>
							<div class='name ini' data-id='{$ctg['id']}'>{$ctg['initials']}</div>
							<div class='color' style='background-color: {$ctg['color']};' data-id='{$ctg['id']}'></div>	
						</div> ";
			
			if ($ctg['type'] == 'theme') {$themes .= $content;}
			else{$act.= $content;}
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
	<p>Pour modifier une valeur, cliquez sur celle-ci.</p>

	<form action="" id="edit">
		<section>
			<h2>Thèmes journaliers</h2>
			<div class="ctn" id="theme">
				<div class="row title">
					<div class='name'>Nom</div>
					<div class='name'>Initiales</div>
					<div class='color'>Couleur</div>
				</div>
				<?= $themes ?>
			</div>	
		</section>

		<section>
			<h2>Activités</h2>
			<div class="ctn" id="act">
				<div class="row title">
					<div class='name'>Nom</div>
					<div class='name'>Initiales</div>
					<div class='color'>Couleur</div>
				</div>
				<?= $act ?>
			</div>
		</section>
		<input type="submit" name="edit" value="Enregistrer les modifications" style="margin-top: 50px;">
	</form>
	<br>

	<footer>
		<button>Ajouter une nouvelle catégorie</button>
	</footer>
</body>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../Assets/anim.js"></script>
	<script type="text/javascript" src='gestion.js'></script>
</html>