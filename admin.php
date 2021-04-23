<!DOCTYPE html>
<html lang="fr">
<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
<head>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
</head>

<?php 


	//toutes les fonctions sont decrites danns server.php


	include("deconn.php");
	include("server.php");
	if($_SESSION["mode"] !="admin") {
		deconnect();
		header("Location: index.php");
		exit();
	}

	echo "<h1>Connecté en tant que : </br></h1>";
	echo "<h3>".$_SESSION['login']."</h3>";
	echo "<br>";
?>

<body>

<section id="menu-creation" class="menu-creation">
<div class="container">

    <div class="row">
        <div class="twelve columns">
            <form action="admin.php#formulairecre" method="post" id="formulairecre">

            </br>

            <h1>Création d'un utilisateur</h1>
            Login:
            <input type="text" name="login"></br>
            Mdp :
            <input type="text" name="passwd"></br>
            Rôle:
            <input type="text" name="role"></br>
            <input style="font-size:10pt" class="button-primary" type="submit" name ="creationUser" value="Nouvel Utilisateur"> </br>
            </form>

            <?php
            if (isset($_POST['login'])){
                create_user($_POST['login'],$_POST['passwd'],$_POST['role']);
            }
			afficher_users();
            ?>
        </div>
    </div>
</div>
</section>

<section id="menu-creation" class="menu-creation">
<div class="container">

    <div class="row">
        <div class="twelve columns">
            <form action="admin.php#formulairemod" method="post" id="formulairemod">

            </br>

            <h1>Modifier un mot de passe</h1>
            Login user:
            <input type="text" name="loginmdp"></br>
            Ancien Mdp :
            <input type="text" name="passwdmdp"></br>
            Nouveau Mdp:
            <input type="text" name="newmdp"></br>
            <input style="font-size:10pt" class="button-primary" type="submit" name ="creationUser" value="Changer le mot de passe"> </br>
            </form>

            <?php
            if (isset($_POST['loginmdp'])){
                modif_passwd($_POST['loginmdp'],$_POST['passwdmdp'],$_POST['newmdp']);
            }
            ?>
        </div>
    </div>
</div>
</section>

<section id="menu-creation" class="menu-creation">
<div class="container">

    <div class="row">
        <div class="twelve columns">
            <form action="admin.php#formulairesup" method="post" id="formulairesup">

            </br>

            <h1>Supprimer un utilisateur</h1>
            Login user:
            <input type="text" name="loginsup"></br>
            <input style="font-size:10pt" class="button-primary" type="submit" name ="creationUser" value="Supprimer utilisateur"> </br>
            </form>

            <?php
            if (isset($_POST['loginsup'])){
                delete_user($_POST['loginsup']);
            }
            ?>
        </div>
    </div>
</div>
</section>

</body>
</html>