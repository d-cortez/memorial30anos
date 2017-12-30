<?php

	$Paroquia   = $_GET["p"]  ? $_GET["p"] : 0;

	include 'conexao.php';

	function RetiraAcento($strTexto){
	 	$array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
	                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
	                     , "ª", "º" );
	  	$array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
	                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"
	                     , " ", " " );
	  	return str_replace( $array1, $array2, $strTexto);
	} 

	$sql = "SELECT 	q.NomeCompleto, q.Cracha, p.ParoquiaDescricao, e.EncontroNumero, e.EncontroAno
	       	FROM    quadrante q, encontro e, paroquia p
	      	WHERE  	q.ParoquiaCodigo = $Paroquia
	      			AND q.EncontroNumero = e.EncontroNumero
	          		AND q.ParoquiaCodigo = e.ParoquiaCodigo	          		
	          		AND q.ParoquiaCodigo = p.ParoquiaCodigo
	          		AND p.Exibir = 1	          		
	       	ORDER BY q.NomeCompleto";

	$oQuadrante = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
	while($quadrante = $oQuadrante->fetch(PDO::FETCH_ASSOC) ){
		
		$arr[] = array(
			"Nome" 		=> RetiraAcento(iconv('ISO-8859-1', 'UTF-8', $quadrante['NomeCompleto'])), 
			"Cracha" 	=> RetiraAcento(iconv('ISO-8859-1', 'UTF-8', $quadrante['Cracha'])), 
			"Paroquia" 	=> iconv('ISO-8859-1', 'UTF-8', $quadrante['ParoquiaDescricao']),
			"Encontro" 	=> str_pad($quadrante['EncontroNumero'], 2, "0", STR_PAD_LEFT), 
			"Ano" 		=> $quadrante['EncontroAno']);
   	}

   	$retorno = array("records"	=> $arr);

	echo json_encode($retorno);

?>