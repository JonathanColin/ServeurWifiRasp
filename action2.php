<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<?php
session_start();
?>
<?php

	//pas utilisé

	require("parametres.php");
	
	$connexion=mysqli_connect($serveur,$login,$mdp)
	or die("Connexion impossible au serveur $serveur pour $login");
	
	$bd="exo_connexionphp";
	
	mysqli_select_db($connexion,$bd)
	or die("Impossible d'accéder à la base de données");
	$tables="connexion";
	$requete="Select * From $tables";
	$resultat=mysqli_query($connexion,$requete);
	
?>

<html>
    <body>
	<h1>Ecran de connexion</h1>
	<h3>
		<form action="action2.php" method="post" name="formulaire">
		Login : <input type="text" name="login" value=""></br>
		<p>Mot de passe : <input type="password" name="mdp" value=""></p> </br>
		<input type="submit" name ="connexion" id="connexion" value="Connexion"> </br>
   	</h3>

    </body>
	<?php
    $sql = "SELECT * FROM connexion";
	$result = mysqli_query($connexion, $sql);
	
	 if (!empty($_POST['connexion']))
	{
		echo "apres connexion";
		echo "<br>";
		if (isset($_POST['login']) and !empty($_POST['login']) 
		and (isset($_POST['mdp']) and !empty($_POST['mdp'])))
		{
			echo "apres isset";
			echo "<br>";
			 $login=$_POST['login'];
			 $mdp=$_POST['mdp'];
			 $_SESSION['login'] = $login;

			 
			 if (mysqli_num_rows($result) > 0) 
			{
				echo "apres sqlinumrow";
				echo "<br>";
				while($row = mysqli_fetch_assoc($result))
				{
					if ($row["password"] == $mdp and $login == $row["login"])
					{
						echo("même mot de passe");
						header('Location:utilisateur.php');
					}
				}
				echo("<b>MOT DE PASSE</b> ou <b>IDENTIFIANT</b> invalide");
				
			} 
			else 
			{
				echo "Pas de résultat";
			}	
			
		}
	else
	{
		echo "Une condition n'a pas été remplie";
		echo '<br>';
	}
	}


    ?>

	
</html>
