<?php
	error_reporting(E_ALL ^ E_NOTICE);
	
	session_start();
	
	$Paroquia   = $_GET["p"]  ? $_GET["p"] : 0;
    $Encontro   = $_GET["e"]  ? $_GET["e"] : 0;
    $Quantidade = $_GET["q"]  ? $_GET["q"] : 0;
	$Gravar 	= $_GET["g"]  ? $_GET["g"] : 0;
	$ins   	 	= 0;

    include 'conexao.php';

    function TratarTexto($strTexto){
	 	$array1 = array("'");
	  	$array2 = array("");
	  	return str_replace($array1, $array2, $strTexto);
	}

	$sql = "SELECT 	p.ParoquiaDescricao, e.EncontroAno, e.Digitado
    		FROM 	encontro e
    				INNER JOIN paroquia p ON p.ParoquiaCodigo = e.ParoquiaCodigo 
    		WHERE 	e.ParoquiaCodigo = ".$Paroquia." AND e.EncontroNumero = ".$Encontro;
    $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
	while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
		$EncontroDigitado 	= $row['Digitado'];
	}

    if ($Gravar == 1 && $EncontroDigitado == 0) {
		for($q=1; $q <= $Quantidade; $q++){
			$Nome	= iconv('UTF-8', 'ISO-8859-1', TratarTexto($_POST['txtNome'][$q]));
			$Cracha = iconv('UTF-8', 'ISO-8859-1', TratarTexto($_POST['txtCracha'][$q]));

			if ($Nome && $Cracha) {
				$insert = "INSERT INTO quadrante (ParoquiaCodigo, EncontroNumero, NomeCompleto, Cracha)
					VALUES (".$Paroquia.", ".$Encontro.", '".$Nome."', '".$Cracha."')";
				$stm = $pdo->query($insert) OR die(implode('', $pdo->errorInfo()));
				$ins++;
			}
		}

		if ($ins) {
			$update = "	UPDATE 	encontro 
						SET 	Digitado = 1
						WHERE 	ParoquiaCodigo = ".$Paroquia." AND EncontroNumero = ".$Encontro;
			$stm = $pdo->query($update) OR die(implode('', $pdo->errorInfo()));
		}
	}

	$sql = "SELECT 	p.ParoquiaDescricao, e.EncontroAno, e.Digitado
    		FROM 	encontro e
    				INNER JOIN paroquia p ON p.ParoquiaCodigo = e.ParoquiaCodigo 
    		WHERE 	e.ParoquiaCodigo = ".$Paroquia." AND e.EncontroNumero = ".$Encontro;
    $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
	while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
		$ParoquiaDescricao 	= iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao']);
		$EncontroAno 		= $row['EncontroAno'];
		$EncontroDigitado 	= $row['Digitado'];
	}


	error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>

<?include "head.php";?>

</head>

<body>

	<form data-toggle="validator" role="form" method="post" name="frm">

		<div class="container">

			<?include "header.php";?>
			</header>

			<?include "menu.php";?>
			</nav>

			<h1>Lançar Dados</h1>

			<div class="container">

			  	<h2>Paróquia: <?=$ParoquiaDescricao?></h2>
			  	<h2>Encontro: <?="#".str_pad($Encontro, 2, "0", STR_PAD_LEFT). " (Ano: ".$EncontroAno.")"?></h2>

				<?if (!$EncontroDigitado) {?>

				  	<table class="table table-striped tabl$Encontro-hover">
				      	<tr>
				          <th style="width:10%">#</th>
				          <th style="width:70%">Nome Completo</th>
				          <th style="width:20%">Crachá</th>        
				      	</tr>

				      	<tbody>

				  		<?php
				  		for ($i = 1; $i <= $Quantidade; $i++){
				  			echo '<tr>';
				  			echo '<td>'.$i.'</td>';
				            echo "<td><input style='width:100%' type=text name=txtNome[$i]  	id=txtNome[$i] 		placeholder='Nome completo do seguidor #".$i."'></td>";
				            echo "<td><input style='width:100%' type=text name=txtCracha[$i]    id=txtCracha[$i] 	placeholder='Nome do crachá #".$i."'></td>";			            
				            echo '</tr>';
				  		}
					    ?>
				  		</tbody>

			  		</table>

			  	<?}else{?>

			  		<table class="table table-striped table-bordered table-hover">
				      <tr>
				          <th>#</th>
				          <th>Nome Completo</th>
				          <th>Crachá</th>        
				      </tr>

				      <tbody>
				        <?php

				        if ($Encontro && $Paroquia) {

				          $sql = "SELECT  NomeCompleto, Cracha 
				                  FROM    quadrante 
				                  WHERE   ParoquiaCodigo=$Paroquia AND EncontroNumero=$Encontro
				                  ORDER BY NomeCompleto";
				          $ordem=1;
				          $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
				          while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
				            echo '<tr>';
				            echo '<td>'. $ordem .'</td>';
				            echo '<td>'. iconv('ISO-8859-1', 'UTF-8', $row['NomeCompleto']).'</td>';
				            echo '<td>'. iconv('ISO-8859-1', 'UTF-8', $row['Cracha']).'</td>';
				            echo '</tr>';
				            $ordem++;
				          }
				        } 
				        $pdo=null;
				        ?>
				      </tbody>

				  </table>

			  	<?}?>
			</div>

			<div class="container">
				<?if (!$ins) {?>

					<?if (!$EncontroDigitado) {?>
	            		<a onClick="Lancar()" class="btn btn-success">Confirmar lançamento</a>            	
	            	<?}else{?>
	            		<div class="alert alert-danger" role="alert">Atenção! Este quadrante já foi digitado.</div>
	            	<?}?>
	            	<a href="quadranteregistrar.php" class="btn btn-warning">Novo lançamento</a>

	            <?}else{?>

	            	<div class="alert alert-success" role="alert">Lançamento realizado com sucesso!</div>
	            	<a href="quadranteregistrar.php" class="btn btn-warning">Novo lançamento</a>

	            <?}?>

            	<p></p>
            </div>

			<div class="alert alert-danger" id="msgDadosInvalidos">			
				<strong>Os dados de todos os seguimistas precisam ser informados!</strong>
				Preencha as informações que faltaram e tente novamente.
			</div>

			<?include "footer.php";?>

		</div>
	</form>
</body>

</html>

<script language="JavaScript">

$('#msgDadosInvalidos').hide();

function Lancar(){

	var qtd = <?=$Quantidade?>;

	for(var i=1; i<=qtd; i++){
		if (!document.getElementById('txtNome['+i+']').value || !document.getElementById('txtCracha['+i+']').value) {
			$('#msgDadosInvalidos').show();
			alert('Dados incompletos.\n\nPreencha os dados do seguidor #'+i);
			return	false;
		}
	}
	
	document.frm.action = 'lancamento.php?g=1&p=<?=$Paroquia?>&e=<?=$Encontro?>&q=<?=$Quantidade?>';
	document.frm.submit();

}

</script>