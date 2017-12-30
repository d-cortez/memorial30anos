<?php

	error_reporting(E_ALL ^ E_NOTICE);
	
	session_start();
	
    include 'conexao.php';
    include  'PHPExcel/PHPExcel.php';

	//error_reporting(E_ALL);

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();

	 // Podemos definir as propriedades do documento
	$objPHPExcel->getProperties()->setCreator("Memorial 30 anos - Segue-me")
        ->setLastModifiedBy("Memorial 30 anos - Segue-me")
        ->setTitle("Relação de seguidores")
        ->setSubject("Seguidores")
        ->setDescription("Relação dos seguidores");

	//$objPHPExcel->createSheet();

	$objPHPExcel->getActiveSheet()->setTitle('Seguidores');
	$p 	 	= 1;
	$linha 	= 2;
	
	$sql = "SELECT * FROM paroquia WHERE Exibir = 1 ORDER BY ParoquiaDescricao";
	$oParoquia = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));

	while( $row = $oParoquia->fetch(PDO::FETCH_ASSOC) ){

		// 	loop com as paroquias
		$ParoquiaDescricao 	= iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao']);
		$ParoquiaCodigo 	= $row['ParoquiaCodigo'];
		
		//$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex()
            ->setCellValue("A1", "Paróquia")
            ->setCellValue("B1", "Encontro" )
            ->setCellValue("C1", "Ano" )
            ->setCellValue("D1", "Ordem" )
            ->setCellValue("E1", "Nome completo" )
            ->setCellValue("F1", "Cracha" );

       	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        //$objPHPExcel->getActiveSheet()->setTitle('Paroquia'.$p);
		// 	loop com os seguimistas da paroquia

        $sql = "SELECT  e.EncontroNumero, e.EncontroAno, q.NomeCompleto, q.Cracha 
              FROM    	quadrante q, encontro e
              WHERE   	q.EncontroNumero = e.EncontroNumero
              			AND q.ParoquiaCodigo = e.ParoquiaCodigo
              			AND q.ParoquiaCodigo = ". $ParoquiaCodigo ."
              ORDER BY 	e.EncontroNumero, e.EncontroAno, q.NomeCompleto";

      	$ordem 			= 1;
      	$EncontroNumero = 0;

      	$oQuadrante = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
      	while( $quadrante = $oQuadrante->fetch(PDO::FETCH_ASSOC) ){

      		if ($EncontroNumero != $quadrante['EncontroNumero'] || $ParoquiaCodigo != $row['ParoquiaCodigo']) {
	        	$ordem = 1;	        	
	        	$EncontroNumero = $quadrante['EncontroNumero'];
	        }

	        $objPHPExcel->setActiveSheetIndex()
				->setCellValue("A".$linha, $ParoquiaDescricao)
            	->setCellValue("B".$linha, str_pad($quadrante['EncontroNumero'], 2, "0", STR_PAD_LEFT))
            	->setCellValue("C".$linha, $quadrante['EncontroAno'] )
            	->setCellValue("D".$linha, str_pad($ordem, 2, "0", STR_PAD_LEFT) )
            	->setCellValue("E".$linha, iconv('ISO-8859-1', 'UTF-8', $quadrante['NomeCompleto']) )
            	->setCellValue("F".$linha, iconv('ISO-8859-1', 'UTF-8', $quadrante['Cracha']) );

			$ordem++;
	        $linha++;

      	}

        $p++;
	}

	// Cabeçalho do arquivo para ele baixar
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="memorial30anos.xls"');
	header('Cache-Control: max-age=0');
	// Se for o IE9, isso talvez seja necessário
	header('Cache-Control: max-age=1');

	// Acessamos o 'Writer' para poder salvar o arquivo
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

	// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
	$objWriter->save('php://output'); 

	exit;

?>