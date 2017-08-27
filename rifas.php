<?php
	require_once('fpdf/mc_table.php');
	require_once('_funcs.php');
	error_reporting(E_ALL ^ E_NOTICE);
	
	class PDF extends PDF_MC_Table {
		function Header() {}	
		function Footer() {}
		function Logomarca($left, $top) {
			$this->Image("img/logo.jpg", $left, $top, 14);	
		}
	}
	
	$pdf = new PDF();
	$pdf->FPDF("L","mm","A4");
	$pdf->SetMargins(10, 5);
	$pdf->SetAutoPageBreak(1, 0);
	$pdf->SetFont("Arial", "B", 9);
	$pdf->SetTextColor(0, 0, 0);

	$pdf->AddPage();
	$top 	= 12;
	$rifa 	= 1;
		
	$sql = "SELECT 	IdEquipe, Equipe, Jovens, Casais
			FROM 	equipe ORDER BY 1";
	$stm = $pdo->query($sql);
  	while($row = $stm->fetch(PDO::FETCH_ASSOC) ){
		
		$qtdEquipe 	= ($row['Casais'] * 25) + ($row['Jovens'] * 15);
		
		for ($i=1; $i <= $qtdEquipe; $i++) {

			$pdf->Logomarca(130, $top);	// Esquerda
			$pdf->Logomarca(278, $top);	// Direita
 
			$numero = 	str_pad($row['IdEquipe'], 2, "0", STR_PAD_LEFT); 
			$numero .= 	".".str_pad($i, 3, "0", STR_PAD_LEFT); 
			$dv		=	rifaDigito(SoNumero($numero)); 		

			$pdf->Cell(40, 1, "", "LT");
			$pdf->Cell(98, 1, "", "LRT");
			$pdf->Cell(10, 1, "");
			$pdf->Cell(40, 1, "", "LT");
			$pdf->Cell(98, 1, "", "LRT", 1);
			
			//	Linha 01 

			$strTexto[1] = "  A Arquidiocese de Natal esta realizando o XIV encontro da"; 
			$strTexto[2] = "2ª etapa do segue-me e voce pode ajudar: Compre uma rifa ";
			$strTexto[3] = "no valor R$ 2,00 e concorra a um jantar para duas pessoas";
			$strTexto[4] = "no Fogo & Chama. O sorteio acontece dia 15/10/17.";
			
			$pdf->SetFont("Arial", "B", 9);
			$pdf->Cell(20, 6, "NÚMERO: ", "L", 0, "L");
			$pdf->Cell(20, 6, $numero."-".$dv."  ", "R", 0, "R");
			
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(78, 6, $strTexto[1]);
			
			$pdf->SetFont("Arial", "B", 9);
			$pdf->Cell(20, 6, "N° ".$numero."-".$dv, "R", 0, "L");
			$pdf->Cell(10, 1, "");

			$i++;	// Incrementar rifa
			$numero = 	str_pad($row['IdEquipe'], 2, "0", STR_PAD_LEFT); 
			$numero .= 	".".str_pad($i, 3, "0", STR_PAD_LEFT); 
			$dv		=	rifaDigito(SoNumero($numero)); 		
		
			$pdf->Cell(20, 6, "NÚMERO: ", "L", 0, "L");
			$pdf->Cell(20, 6, $numero."-".$dv."  ", "R", 0, "R");
			
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(78, 6, $strTexto[1]);
			$pdf->SetFont("Arial", "B", 9);
			$pdf->Cell(20, 6, "N° ".$numero."-".$dv, "R", 1, "L");
			
			//	Linha 02
			
			$pdf->SetFont("Arial", "", 9);
			$pdf->Cell(40, 6, "NOME: ".str_pad("", 14, "_"), "LR");
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(98, 6, $strTexto[2], "R");
			$pdf->Cell(10, 1, "");
			$pdf->SetFont("Arial", "", 9);
			$pdf->Cell(40, 6, "NOME: ".str_pad("", 14, "_"), "LR");
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(98, 6, $strTexto[2], "R", 1);
			
			//	Linha 03

			$pdf->Cell(40, 6, str_pad("", 23, "_"), "LR");
			$pdf->Cell(98, 6, $strTexto[3], "R");
			$pdf->Cell(10, 1, "");
			$pdf->Cell(40, 6, str_pad("", 23, "_"), "LR");
			$pdf->Cell(98, 6, $strTexto[3], "R", 1);

			//	Linha 04

			$pdf->SetFont("Arial", "", 9);
			$pdf->Cell(40, 6, "FONE: ".str_pad("", 14, "_"), "LR");
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(98, 6, $strTexto[4], "R");
			$pdf->Cell(10, 1, "");
			$pdf->SetFont("Arial", "", 9);
			$pdf->Cell(40, 6, "FONE: ".str_pad("", 14, "_"), "LR");
			$pdf->SetFont("Arial", "", 8);
			$pdf->Cell(98, 6, $strTexto[4], "R", 1);
			
			$rifa++;
			// 	Posicionar logo
			if ($rifa == 9) {
				$top 	= 11;
				$rifa 	= 1;
				$pdf->AddPage();
			}else{
				$top += 25.1;
			}
		}			

		$pdf->Cell(138, 1, "", "T");
		$pdf->Cell(10, 1, "");
		$pdf->Cell(138, 1, "", "T");
		$pdf->Ln(0);

	}

	$pdf->Output();
?>