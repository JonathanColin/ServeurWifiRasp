<?php 
	include("server.php");
	$target_dir = "cours/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
	header("Location: enseignant.php");
?>