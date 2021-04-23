$<?php

	if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}
	
	//tout ce qui touche à la base de donnees est ici
	
	$serveur="127.0.0.1";
	$connexion=mysqli_connect($serveur,"root","password") 
	or die("Connexion impossible au serveur $serveur");
		
	$bd='bol';
		
	mysqli_select_db($connexion,$bd)
	or die("Impossible d'accèder à la base de données");
	
	$_SESSION['connexion']=$connexion;
	$_SESSION['bd']=$bd;
	
	
	//pour la connexion d'utilisateur
	if(!function_exists("login")){
		function login($login , $passwd) {
			
			$_SESSION['login']=$login;
			$_SESSION['password']=$passwd;
			
			$requete= $_SESSION['connexion']->prepare("SELECT role,status from users WHERE login=? AND password=?");
			$requete -> bind_param("ss", $_SESSION['login'], $_SESSION['password']);
			$requete -> execute();
			$requete -> store_result();
			$requete -> bind_result($role,$status);
			if ($requete -> fetch()) {
				if ($status==0) {
				//resussite
					//$requete="UPDATE users SET status=1 WHERE login='".$_SESSION['login']."'";
					$resultat=mysqli_query($_SESSION['connexion'],$requete);
					if ($role=="admin") {
						$_SESSION['mode']="admin";
					}
					else if($role=="enseignant"){
						$_SESSION['mode']="enseignant";
					}
					else {
						$_SESSION['mode']="etudiant";
					}
				}
			}
			else {$_SESSION['mode']="noone";}
			mysqli_stmt_free_result($requete);
			mysqli_stmt_close($requete);
	}}
	//creer un utilisateur
	if(!function_exists("create_user")){
		function create_user($name,$passwd,$role) {
			$requete="SELECT login FROM users";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			
			while ($row = mysqli_fetch_assoc($resultat)) {
				foreach ($row as $field => $value) { 
					if($name==$value) {echo "L'utilisateur existe deja";return;}
				}
			}
			
			$requete= mysqli_prepare($_SESSION['connexion'],"INSERT INTO `users`(`login`, `password`, `role`) VALUES (?,?,?)");
			mysqli_stmt_bind_param($requete,"sss",$name,$passwd,$role);
			mysqli_stmt_execute($requete);
			mysqli_stmt_close($requete);
			
			/*$requete= $_SESSION['connexion']->prepare("INSERT INTO 'users'('login', 'password','role') VALUES (?,?,?)");
			$requete -> bind_param("sss",$name,$passwd,$role);
			$requete -> execute();*/
		}
	}
	//modifier un mot de passe d'un utilisateur existant
	if(!function_exists("modif_passwd")){
		function modif_passwd($login,$oldpass,$newpass) {
			
			$requete= mysqli_prepare($_SESSION['connexion'],"UPDATE users SET password=? WHERE login=? and password=?");
			mysqli_stmt_bind_param($requete,"sss",$newpass,$login,$oldpass);
			mysqli_stmt_execute($requete);
			mysqli_stmt_close($requete);
			
		}
	}
	//supprimer un utilisateur
	if(!function_exists("delete_user")){
		function delete_user($name) {
			
			$requete= mysqli_prepare($_SESSION['connexion'],"DELETE FROM `users` WHERE login=?");
			mysqli_stmt_bind_param($requete,"s",$name);
			mysqli_stmt_execute($requete);
			mysqli_stmt_close($requete);
			
		}
	}
	//deconnexion propre de l'utilisateur
	if(!function_exists("deconnect")){
		function deconnect() {
			$requete="UPDATE users SET status=0 WHERE login='".$_SESSION['login']."'";
					$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$_SESSION = Array();
			//mysqli_close($connexion);
		}
	}
	//afficher une liste des utilisateur deja mise en forme
	if(!function_exists("afficher_users")){
		function afficher_users() {
			$requete="SELECT login FROM users";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			echo "<br>";
			echo "<table border='1'>";
			while ($row = mysqli_fetch_assoc($resultat)) {
				echo "<tr>";
				foreach ($row as $field => $value) { 
					echo "<td>" . $value . "</td>"; 
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	//renvoie la liste des sondages/questions
	if(!function_exists("get_sondages")){
		function get_sondages() {
			$requete="SELECT question,status,id FROM polls";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$liste = array();
			while ($row = mysqli_fetch_assoc($resultat)) {
				foreach ($row as $field => $value) { 
					$liste[] = $value;
				}
			}
			return $liste;
		}
	}
	//passer un sondage de actif à caché et inversement
	if(!function_exists("changer_status_sondage")){
		function changer_status_sondage($id,$newstatus) {
			
			$requete="UPDATE polls SET status='inactif'";
			mysqli_query($_SESSION['connexion'],$requete);
			
			if($newstatus=="activer") {
				$requete="UPDATE polls SET status='actif' WHERE id='$id'";
			}
			else {
				$requete="UPDATE polls SET status='inactif' WHERE id='$id'";
			}
			mysqli_query($_SESSION['connexion'],$requete);
			
		}
	}
	//creer un sondage a partir d'une question
	if(!function_exists("creer_sondage")){
		function creer_sondage($question) {
			
			$requete= mysqli_prepare($_SESSION['connexion'],"INSERT INTO `polls`(`question`, `status`) VALUES (?,'inactif')");
			mysqli_stmt_bind_param($requete,"s",$question);
			mysqli_stmt_execute($requete);
			mysqli_stmt_close($requete);
		}
	}
	//supprimer un sondage a partir de son id
	if(!function_exists("supprimer_sondage")){
		function supprimer_sondage($id) {
			$requete="DELETE FROM polls WHERE id='$id'";
			mysqli_query($_SESSION['connexion'],$requete);
		}
	}
	//repondre a un sondage
	if(!function_exists("repondre_sondage")){
		function repondre_sondage($id,$reponse) {
			$requete="INSERT INTO answers (idpoll,loginetudiant,reponse) VALUES ($id,'".$_SESSION['login']."','$reponse');";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
		}
	}
	//renvoie vrai si l'etudiant a deja repondu au sondage
	if(!function_exists("sondage_repondu")){
		function sondage_repondu($id) {
			$requete="SELECT idPoll,loginetudiant FROM answers WHERE idpoll='$id' and loginetudiant='".$_SESSION['login']."'";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			while ($row = mysqli_fetch_assoc($resultat)) {
				return 1;
			}
		}
	}
	//renvoie une liste avec [votesoui, votesnon, votesneseprononcentpas, pasvotes, totaldesvotes]
	if(!function_exists("get_resultats_sondages")){
		function get_resultats_sondages($id) {
			$requete="select login from users where role='etudiant'";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$compteur=0;
			while ($row = mysqli_fetch_assoc($resultat)) {
				$compteur++;
			}
			$requete="select loginetudiant from answers where reponse=1 and idpoll='$id'";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$votesoui=0;
			while ($row = mysqli_fetch_assoc($resultat)) {
				$votesoui++;
			}
			$requete="select loginetudiant from answers where reponse=0 and idpoll='$id'";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$votesnon=0;
			while ($row = mysqli_fetch_assoc($resultat)) {
				$votesnon++;
			}
			$requete="select loginetudiant from answers where reponse=2 and idpoll='$id'";
			$resultat=mysqli_query($_SESSION['connexion'],$requete);
			$votespp=0;
			while ($row = mysqli_fetch_assoc($resultat)) {
				$votespp++;
			}
			$pasvote=$compteur-$votesnon-$votesoui-votespp;
			return [$votesoui,$votesnon,$votespp,$pasvote,$compteur];
		}
	}
	//scan un dossier
	if(!function_exists("scandos")){
		function scandos($c) {
			$b=scandir($c);
			for ($i = 2; $i < count($b); $i++) {
				if (is_dir($b[$i])) {
					scandos($b[$i]);
				}
				else {
					echo "<a href='cours/$b[$i]' download>".$b[$i] ."</a> </br>";
				}
			}
		}
	}

?>
