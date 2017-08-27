<?php
	require_once("conexao.php");
	
	function rifaDigito($numero) {
		
		$Numero[1]=intval(substr($numero,1-1,1));
		$Numero[2]=intval(substr($numero,2-1,1));
		$Numero[3]=intval(substr($numero,3-1,1));
		$Numero[4]=intval(substr($numero,4-1,1));
		$Numero[5]=intval(substr($numero,5-1,1));
		
		$soma 	= 10*$Numero[1]
				+ 9*$Numero[2]
				+ 8*$Numero[3]
				+ 7*$Numero[4]
				+ 6*$Numero[5];
		$digito = $soma-(11*(intval($soma/11)));
		if ($digito >= 10) { 	$digito = $digito - 10; }

	    return $digito;
	}

	function SoNumero($texto) {
		$num = "";	
		for ($i = 0; $i < strlen($texto); $i++) {
			if (preg_match("/[0-9]/", substr($texto, $i, 1))) { 
				$num = $num.substr($texto, $i, 1);
			}
		}
		
		return $num;
	}
		
?>