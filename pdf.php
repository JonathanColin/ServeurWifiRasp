<?php
ini_set('display_errors',1);
require("fpdf/fpdf.php");


if(isset($_GET['course'])) {

//echo "a=".$a;

	class PDF extends FPDF{
		function Header(){
			$this->Image('images/uvsq_logo.png',170,8,30);
			$this->Ln(30);
		}
		function Footer(){
			$this->SetY(-20);
			$this->Cell(196,5,'Achieved with FPDF.',0,0,'C');
		}
		
		
		// Chargement des données
		/*function LoadData($file){
			// Lecture des lignes du fichier
			$lines = file($file);
			$data = array();
			foreach($lines as $line)
				$data[] = explode(';',trim($line));
			unset($data[0]);
			return $data;
		}

		
		// Tableau coloré
		/*function FancyTable($header, $data){
			// Couleurs, épaisseur du trait et police grasse
			$this->SetX(40);
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			// En-tête
			$w = array(22, 22, 22, 22, 22, 22);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Ln();
			// Restauration des couleurs et de la police
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Données
			$fill = true;
			foreach($data as $row)
			{
				$this->SetX(40);
				$this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
				$this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
				$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
				$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
				$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
				$this->Cell($w[5],6,$row[5],'LR',0,'C',$fill);
				$this->Ln();
				$fill = !$fill;
			}
			// Trait de terminaison
			$this->SetX(40);
			$this->Cell(array_sum($w),0,'','T');
		}
		
		
		// Tableau résultats
		function ResultTable($header,$data){
			
			
			//include "stats.php";
			$moy_ouv = $_SESSION['moy_ouv'];
			$moy_min = $_SESSION['moy_min'];
			$moy_max = $_SESSION['moy_max'];
			$moy_vol = $_SESSION['moy_vol'];
			$min_max = $_SESSION['min_max'];
			$max_min = $_SESSION['max_min'];
			// $moy_ouv = $_SESSION['moy_ouv'];
			// $moy_min = $_SESSION['moy_max'];
			// Couleurs, épaisseur du trait et police grasse
			$this->SetY(50);
			$this->SetX(65);
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			// En-tête
			$w = array(60, 60, 60, 60, 60, 60);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,2,'C',true);
			
			// Restauration des couleurs et de la police
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Données
			$fill = true;
			$w = array(40, 40, 40, 40, 40, 40);
			$this->SetY(50);
			
			
			//Pour mon moi du futur : il faut emmener toutes les variables de resultats.php en POST.
			$this->SetX(125);
			$this->Cell($w[0],7,$moy_ouv,1,2,'C',$fill);
			$this->Cell($w[1],7,$moy_min,1,2,'C',!$fill);
			$this->Cell($w[2],7,$moy_max,1,2,'C',$fill);
			$this->Cell($w[3],7,$moy_vol,1,2,'C',!$fill);
			$this->Cell($w[4],7,$min_max,1,2,'C',$fill);
			$this->Cell($w[5],7,$max_min,1,2,'C',!$fill);
			
			/*foreach($data as $row)
			{
				$this->SetX(105);
				$this->Cell($w[0],7,$row[0],1,0,'C',$fill);
				$this->Ln();
				$fill = !$fill;
			}*/
			
		//}
	}
	
	
	//$a = str_replace("files/","/files/",$a);
	//echo $a;
	//$pdf->Text(8,38,'Login :'.$row['login']);
	//$pdf->Text(8,43,'mdp :'.$row['mdp']);
	
	
	
	
	//$docTitle = $_SESSION['fichier'];
	
	//echo var_dump($_SESSION);
	/*echo var_dump($docTitle);
	echo var_dump($moy_ouv);
	echo var_dump($moy_min);
	echo var_dump($moy_max);
	echo var_dump($moy_vol);
	echo var_dump($min_max);
	echo var_dump($max_min);*/
	
    

	ob_get_clean();
        $pdf = new PDF('P','mm','A4');
        
    
        $pdf->SetFont('Arial','',11);
        
        
        //$pdf->Ln(12);
        
        $pdf->AddPage();
        
        $pdf->Write(5,$_GET['course']);
        //$pdf->Stats();
        
        $pdf->Output();
	
}
?>
