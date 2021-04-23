<?php 
	//permet la deconnexion propre 

	include("server.php");
	echo "<form action=\"deconn.php\" method=\"get\">
	<input class='button-primary' type=\"submit\" value=\"Deconnexion\" name=\"deconnect\">
	</form>";
	if (isset($_GET['deconnect'])) {
		deconnect();
		header("Location: index.php");
		exit();
	}
?>
