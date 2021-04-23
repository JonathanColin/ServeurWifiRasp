
<!DOCTYPE html>
<html lang="fr">
<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<head>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
</head>

<body>

<?php
	ini_set('display_errors',1);
	include("deconn.php");
	include("server.php");
	if($_SESSION['mode'] !="enseignant") {
		deconnect();
		header("Location: index.php");
		exit();
	}

	echo "<h1>Connecté en tant que : </br></h1>";
	echo "<h3>".$_SESSION['login']."</h3>";
	echo "<br>";
	include("pdf.php");
//	echo "<a href='pdf.php'>Ecrire un cours</a>";
//permet d'ecrire un cours. Caractères et espaces seulement
echo "Ecrire un cours: </br> lettres et espaces seulements";

echo "<form action='pdf.php' method='get'>
                        <input type='textarea' rows='4' cols='50' name='course'>
                        <input type='submit' name='submit' value='Submit'>";
 

?>



<section id="menu-chargerfichiers" class="menu-chargerfichiers">
<div class="container">
	
	<div class="row">
		<div class="one-half column">
			<h1>Envoyer des fichiers pdf à destination des élèves</h1>
			<form action="upload.php" method="post" enctype="multipart/form-data">
			Choisissez un pdf a envoyer:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input style="font-size:10pt" class="button-primary" type="submit" value="Envoyer le cours" name="submit">
			</form>
		</div>
	</div>
	<div class="row">
		<div class="one-half column">
			<li><a href="#">Revenir en haut de la page</a></li>
			</br>
		</div>
	</div>
</div>
</section>



<section id="menu-suppressioncsv" class="menu-suppressioncsv">
<div class="container">
	
	<div class="row">
		<div class="seven columns">
			<h1>Supprimer un fichier pdf</h1>

			<?php 
			
				if (!empty($_GET)){
					foreach ($_GET as $key => $value) {
						if ($value=="supprimer") {
							unlink("cours/".$key);
						}
					}
				}
			
				$b=scandir("cours");
				echo "<form action='enseignant.php#suppression' method='get' id='suppression'>";
				for ($i = 2; $i < count($b); $i++) {
					echo "</br>".$b[$i]. "<input type='submit' value='supprimer' name=".$b[$i].">" ;
				}
				
				
			?>

				
		
		</div>
	</div>
	<div class="row">
		<div class="one-half column">
			<li><a href="#">Revenir en haut de la page</a></li>
			</br>
		</div>
	</div>
</div>
</section>

<section id="menu-creation" class="menu-creation">
<div class="container">
	
	<div class="row">
		<div class="one-half column">
		<?php
		//partie enseignant de sondage.php
			include("sondage.php");
		?>
		</div>
	</div>
	<div class="row">
		<div class="one-half column">
			<li><a href="#">Revenir en haut de la page</a></li>
			</br>
		</div>
	</div>
</div>
</section>
</body>
</html>
