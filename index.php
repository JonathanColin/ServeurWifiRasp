<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/index_css.css" />
	</head>
	<body>
<?php
//page d'index avec juste un login
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	include("server.php");
	
	if ($_SESSION['login']) {
		login($_SESSION['login'],$_SESSION['password']);
	}
	
	echo " 
	
	
		<div class='container'>
			<h3 style='text-align:center'>Connexion</h3>
			<form action='action_login.php' method='get'>
			<h1>Login</h1>
			<input type='text' name='login'>
			<h1>Password</h1>
			<input type='password' name='password'>
			<input type='submit' name='submit' value='Submit'>";

	if (isset($_GET['echec'])){
                echo"<p style='color:Red;font-size:13px;text-align:center;'> Le login ou le mot de passe est incorrect</p>";
        } 
	echo"</form></div>";
	?>
	
	<img class='image' src="images/uvsq_logo.png"> 
	<h4 style='text-align:center'>Projet réalisé par Alexandre KHELIFI / Jonathan COLIN / Raphaël MEISSONNIER / Thibaut COQUELET</h4>



	</body>
</html>
