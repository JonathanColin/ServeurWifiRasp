<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<?php
session_start();
?>
<?php

	//pas utilisé

	require("parametres.php");
	
	$connexion=mysqli_connect($serveur,$login,$mdp)
	or die("Connexion impossible au serveur $serveur pour $login");
	$error=false;
	$bd="exo_connexionphp";
	
	mysqli_select_db($connexion,$bd)
	or die("Impossible d'accéder à la base de données");

    $sql = "SELECT * FROM connexion";
	$result = mysqli_query($connexion, $sql);
	if (!empty($_POST['connexion']))
	{
		if (isset($_POST['login']) and !empty($_POST['login']) 
		and (isset($_POST['mdp']) and !empty($_POST['mdp'])))
		{
			$login=$_POST['login'];
			$mdp=$_POST['mdp'];
			$_SESSION['login'] = $login;
			if (mysqli_num_rows($result) > 0) 
			{
				while($row = mysqli_fetch_assoc($result))
				{
					if ($row["password"] == $mdp and $login == $row["login"])
					{
						$error=false;
						header('Location:utilisateur.php');
					}
					else $error=true;
				}
				if ($error) {
					echo("<b>MOT DE PASSE</b> ou <b>IDENTIFIANT</b> invalide");
				}
			} 
			else 
			{
				echo "Aucun enregistrement correspondant trouvé dans la base";
				$error=true;
			}	
		}
		else $error=true;
	}
	else $error=true;
	echo "erreur vaut : $error";
	echo "<br>";

	if ($error)
	{
		echo '<br>';
		echo "Une condition n'a pas été remplie";
		echo '<br>';
		header('Location:index3.php');
	}
?>
</html>
