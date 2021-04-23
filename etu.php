<!DOCTYPE html>
<html lang="fr">
<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<head>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<script src="dist/Chart.bundle.js"></script>
	<script src="dist/chartjs-plugin-datalabels.js"></script>
</head>

<body>

<?php

	include("deconn.php");
	include("server.php");
	if($_SESSION['mode'] !="etudiant") {
		deconnect();
		header("Location: index.php");
		exit();
	}
	
	echo "<h1>Connecté en tant que : </br></h1>";
	echo "<h3>".$_SESSION['login']."</h3>";
	echo "<br>";
?>
<section id="menu-listefichiers" class="menu-listefichiers">
<div class="container">
	
	<div class="row">
			<h1>Sélectionner un cours à télécharger</h1>
			<?php
			//telechargement des fichiers
				$b=scandir("cours");
				for ($i = 2; $i < count($b); $i++) {
					echo "<a href='cours/$b[$i]' download>".$b[$i] ."</a> </br>";
				}
			
			?>
	</div>
	</br>
	<div class="row">
		<div class="one-half column">
			<li><a href="#">Revenir en haut de la page</a></li>
			</br>
		</div>
	</div>
</div>
</section>

		<?php
		//partie etudiant de sondage.php
			include("sondage.php");
		?>

</body>
</html>