<?php
	error_reporting(E_ALL ^ E_NOTICE);
	
	session_start();
	
	$Paroquia   = $_GET["p"]  ? $_GET["p"] : 0;
    $Encontro   = $_GET["e"]  ? $_GET["e"] : 0;

    include 'conexao.php';

	error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>

<?include "head.php";?>

</head>

<body>
	
	<div class="container">

		<?include "header.php";?>
		</header>

		<?include "menu.php";?>
		</nav>

		<h1>Monitoramento</h1>

		<div class="container ">

	  		<?php
	  		$sql = "SELECT e.ParoquiaCodigo, ParoquiaDescricao, 
	  				COUNT(e.`EncontroNumero`) AS Quantidade,
					(SELECT COUNT(d.EncontroNumero) 
					FROM 	encontro d 
					WHERE 	e.ParoquiaCodigo = d.ParoquiaCodigo 
						AND Digitado = 1) AS Digitado
					FROM	paroquia p, encontro e
					WHERE 	p.ParoquiaCodigo = e.ParoquiaCodigo
					GROUP BY p.ParoquiaCodigo
					ORDER BY ParoquiaDescricao";
					
	  		$stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
	      	while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){

	      		$Percentual = ($row['Digitado'] > 0) ? ceil(($row['Digitado'] * 100) / $row['Quantidade']) : 0;

	      		switch ($Percentual) {
	      			case 100:
	      				$bar = "progress-bar-success";
	      				break;
	      			
	      			case $Percentual >= 70:
	      				$bar = "progress-bar-info";
	      				break;

	      			case $Percentual > 15:
	      				$bar = "progress-bar-warning";
	      				break;

	      			default:
	      				$bar = "progress-bar-danger";
	      				break;
	      		}

				?>
				
				<div class="panel panel-default">
  					
  					<div class="panel-heading">
  						<?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?>
  					</div>

  					<div class="panel-body">

  						<div class="progress">
						  	<div class="progress-bar <?=$bar?>" role="progressbar" aria-valuenow="<?=$row['Digitado']?>"
						  		aria-valuemin="0" aria-valuemax="<?=$row['Quantidade']?>" style="width:<?=$Percentual?>%">
						    	<?=$Percentual?>% realizado
						  	</div>
						</div>
 
						<?
						$sql = "SELECT  ParoquiaCodigo, EncontroNumero, EncontroAno, Digitado 
					           	FROM    encontro
					           	WHERE   ParoquiaCodigo=".$row['ParoquiaCodigo']." ORDER BY EncontroNumero";
					   	$stm2 = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
					   	while( $encontro = $stm2->fetch(PDO::FETCH_ASSOC) ){?>
					   		<span class="label label-<?=$encontro['Digitado'] ? 'success' : 'danger'?>">
					   			<?=str_pad($encontro['EncontroNumero'], 2, "0", STR_PAD_LEFT)?>
					   		</span>				    	
					  	<?}?>

					</div>

			  	</div>
							
				<?}?>
	
	  	</div>

		<?include "footer.php";?>
	
	</div>
</body>

</html>