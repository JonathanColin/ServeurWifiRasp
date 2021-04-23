<?php 

	//gere les connexions utilisateur

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include("server.php");
	
	$login=$_GET['login'];$mdp=$_GET['password'];
	login($login,$mdp);
	if ($_SESSION['mode']=="admin") {
		header("Location: admin.php");
		exit();
	}
	if ($_SESSION['mode']=="enseignant") {
		header("Location: enseignant.php");
		exit();
	}
	if ($_SESSION['mode']=="etudiant") {
		header("Location: etu.php");
		exit();
	}
	else{
		header("Location:index.php?echec=1");
	}

?>
