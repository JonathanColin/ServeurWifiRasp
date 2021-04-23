<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<html>
<body>
<?php


//fichier utilisé pour les tests de connexion


session_start();
echo "<h1>Connecté en tant que : </br></h1>";
echo $_SESSION['login'];
echo "<br>";
?>

   	<form action="utilisateur.php" method="post" name="formulaire">
   	</br>
	<input style="width:125px; height:35px; border-style:dotted; border-color:black; color: black; 
	font-size:13.5pt" type="submit" name ="déconnexion" value="Déconnexion"> </br></form>
	
		<?php
		if (isset($_POST['déconnexion']) and !empty($_POST['déconnexion']))
			{
				session_destroy();
				header('Location:index3.php');
			}
		?>
		
    </body>
</html>

