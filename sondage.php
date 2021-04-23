<?php

	//si l'utilisateur est ni enseignant ni etudiant, quitter
	if(! in_array($_SESSION['mode'],["enseignant","etudiant"]) or !isset($_SESSION['mode'])) {
		deconnect();
		header("Location: index.php");
		exit();
	}
	//partie enseignant
	if ($_SESSION['mode']=="enseignant") {
		
		/*$date = date("Y-m-d H:i:s");
		echo $date;
		echo date("Y-m-d H:i:s",strtotime("$date + 3 minutes"));*/
		
		if (!empty($_GET)){
			foreach ($_GET as $key => $value) {
				if ($value=="activer" or $value=="pasactiver") {
					changer_status_sondage($key,$value);
				}
				else if ($value=="supprimer") {
					supprimer_sondage($key);
				}
				else if ($key=="question") {
					creer_sondage($value);
				}
				
			}
		}
		
		echo "<h1>Gestion des Sondages</h1><br>";
		$liste = get_sondages();
		echo "<br> <form action='enseignant.php#sondage_select' method='get' id='sondage_select'>";
		echo "<table border='1'>";
		for($i=0; $i<count($liste); $i+=3) {
			echo "<tr>";
			if ($liste[$i+1] != "actif") {
				echo "<td> $liste[$i] </td> <td><input type='submit' value='activer' name=".$liste[$i+2]."></td><td><input type='submit' value='supprimer' name=".$liste[$i+2]."></td>"; 
			}
			else {
				echo "<td> $liste[$i] </td> <td><input type='submit' value='pasactiver' name=".$liste[$i+2]."></td><td><input type='submit' value='supprimer' name=".$liste[$i+2]."></td>"; 
			}
			echo "</tr>";
		}
		echo "</table></form>";
		
		echo "<h1>Création d'un Sondage</h1><br>";
		echo "<form action='enseignant.php#sondage_creation' method='get' id='sondage_creation'>
		<h3> Question: </h3>
		<input type='text' name='question'>
		<input type='submit' value='envoyer' name=Envoyer>
		</form>";
		
	}
	//partie etudiant
	if ($_SESSION['mode']=="etudiant") {
		
		$liste = get_sondages();		//$liste est un tableau qui contient tous les toutes les infos des sondages sous cette forme: [question,status,id]
		
		if (!empty($_GET)){
			foreach ($_GET as $key => $value) {
				if ($key=="reponse" && !sondage_repondu($liste[$_SESSION['indice']+2])) {
					repondre_sondage($liste[$_SESSION['indice']+2],$value);
				}
			}
		}
		$mode="off";$indice=0;
		for ($i=0;$i<count($liste);$i+=3) {
			if ($liste[$i+1]=="actif") {
				$mode="on";$_SESSION['indice']=$i;
			}
		}
		if ($mode=="on" && !sondage_repondu($liste[$_SESSION['indice']+2])) {
		
		echo '<script src="dist/Chart.bundle.js"></script>
	<script src="dist/chartjs-plugin-datalabels.js"></script>';
		
			echo '<section id="menu-chargerfichiers" class="menu-chargerfichiers">
					<div class="container">
	
						<div class="row">
						<div class="one-half column">';
			//Cette partie s'affiche si l'etudiant n'a pas encore repondu au sondage			
			echo "<h1>Sondage</h1>";
			echo "<h3>".$liste[$_SESSION['indice']]."</h3>";
			echo "<form action='etu.php#reponse_sondage' method='get' id='reponse_sondage'>
			<input type='radio' name='reponse' value='1'> Oui
			<input type='radio' name='reponse' value='0'> Non
			<input type='radio' name='reponse' value='2'> Ne se prononce pas
			<input type='submit' name='submit' value='Valider'>
			</form>";
			
			echo'</div>
				</div>
					<div class="row">
						<div class="one-half column">
							<li><a href="#">Revenir en haut de la page</a></li>
							</br>
						</div>
					</div>
				</div>
				</section>';
		}
		//l'etudiant a repondu au sondage, donc:
		else if ($mode=="on") {
			$resultats_sondages=get_resultats_sondages($liste[$_SESSION['indice']+2]);		//contient les resultats du sondage sous la forme d'un tableau: [oui,non,neseprononcepas,pasvoté,totaldesvoix]
			echo '<section id="menu-chargerfichiers" class="menu-chargerfichiers">
					<div class="container">
	
						<div class="row">
						<div class="one-half column">';
						
			echo "<h1>Sondage</h1>";
			echo "<h3>".$liste[$_SESSION['indice']]."</h3>";
			echo "<h4>Résultats: </h4>";
			
			echo "Votes OUI: ".$resultats_sondages[0]." ".round((floatval($resultats_sondages[0])/floatval($resultats_sondages[4]))*100,2) ."%</br>";
			echo "Votes NON: ".$resultats_sondages[1]."              ".round((floatval($resultats_sondages[1])/floatval($resultats_sondages[4]))*100,2) ."%</br>";
			echo "Ne se prononce pas: ".$resultats_sondages[2]."            ".round((floatval($resultats_sondages[2])/floatval($resultats_sondages[4]))*100,2) ."%</br>";
			echo "N'ont pas voté: ".$resultats_sondages[2]."            ".round((floatval($resultats_sondages[3])/floatval($resultats_sondages[4]))*100,2) ."%</br>";
			
		//script pour le graphique	
			echo "<canvas id='myChart'></canvas>
		<script>
		var ctx = document.getElementById('myChart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'doughnut',

			// The data for our dataset
			data: {
				labels: ['Oui', 'Non', 'Ne se prononce pas'],
				showInLegend: true,
				datasets: [{
					label: 'dataset',
					backgroundColor: ['rgb(0, 160, 64)','rgb(224, 0, 0)','rgb(128, 0, 192)'],
					borderColor: 'rgb(0,0,0)',
					data: [".round((floatval($resultats_sondages[0])/floatval($resultats_sondages[4]))*100,2) .", ".round((floatval($resultats_sondages[1])/floatval($resultats_sondages[4]))*100,2).", ".round((floatval($resultats_sondages[2])/floatval($resultats_sondages[4]))*100,2)."]
				}]
			},

    // Configuration options go here
    options: {
	title: {
        display: true,
        text: 'Pourcentage des réponses des étudiants à ce sondage',
		fontSize: 20
      },
	  plugins: {
		datalabels: {
			color: '#000000',
			
            font:{
				size: 10    
			}
           }
		
		
		}
	  
	  
	  
	  }
  
});
	
	
	
	
	
	
	
	</script>";
			
			
			echo'</div>
				</div>
					<div class="row">
						<div class="one-half column">
							<li><a href="#">Revenir en haut de la page</a></li>
							</br>
						</div>
					</div>
				</div>
				</section>';
		}
			
	}

	
?>

