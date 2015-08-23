<!DOCTYPE html>
<html>

<?include "head.php";?>

</head>

<body>

	<form method="post" name="frm">

		<div class="container">

			<?include "header.php";?>
			</header>

			<?include "menu.php";?>
			</nav>

			<h1>Lançar Dados</h1>

			<div class="container">
			  	<h4>Selecione a paróquia:</h4>
			  	<ul class="form-group">
			  	<select name="txtParoquia" class="form-control" id="txtParoquia" style="width:350px" onChange="SelecionarParoquia(this.value)">
					<option value="0">---</option>				
					<?php
				      $sql = "SELECT * FROM paroquia ORDER BY ParoquiaDescricao";
				      $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));

				      while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
				        if ($Paroquia == $row['ParoquiaCodigo']) {?>				        
				            <option selected value=<?=$row['ParoquiaCodigo']?>><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></option>
				        <?}else{?>
				            <option value=<?=$row['ParoquiaCodigo']?>><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></option>
				    	  <?}
				      }
				    ?>
			  	</select>			
			</div>

			<?if ($Paroquia) {?>
				<div class="container">
				    <h4>Informe o encontro:</h4>
				    <ul class="form-group">
					  	<select name="txtEncontro" class="form-control" id="txtEncontro" style="width:350px">
							<option value="0">---</option>				
					    <?php      
					      $sql = "SELECT  ParoquiaCodigo, EncontroNumero, EncontroAno, Digitado 
					              FROM    encontro
					              WHERE   ParoquiaCodigo=".$Paroquia." ORDER BY EncontroNumero";
					      $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
					      while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
					      	$color = !$row['Digitado'] ? "#FFDEAD" : "#ccffff"; ?>
					      	<option style="background-color:<?=$color?>" value=<?=$row['EncontroNumero']?>><?=str_pad($row['EncontroNumero'], 2, "0", STR_PAD_LEFT)." (Ano: ".$row['EncontroAno'].")"?></option><?
					  	  }
					    ?>
					    </select>
				  	</ul>
				</div>

				<div class="container">
				    <h4>Quantidade de seguimistas:</h4>
				    <ul class="form-group">
					  	<select name="txtQuantidade" class="form-control" id="txtQuantidade" style="width:350px">
					    <?php      
					      for ($i = 1; $i <= 99; $i++){
					      	if ($i==60) {?>
					      		<option selected value=<?=$i?>><?=$i?></option>    
					      	<?}else{?>
					      		<option value=<?=$i?>><?=$i?></option>    
					      	<?}
					      }
					    ?>
				    	</select>
				  	</ul>
				</div>

			<?}?>

			<div class="container">
            	<?if ($Paroquia) {?>
            		<a onClick="Lancar()" class="btn btn-success">Iniciar lançamento</a>
            	<?}?>
            	<a href="index.php" class="btn btn-warning">Cancelar lançamento</a>            	
            </div>
	        		
			<?include "footer.php";?>

		</div>
	</form>
</body>

</html>

<script language="JavaScript">

	function SelecionarParoquia(intParoquia){
		document.frm.action = 'quadranteregistrar.php?e=0&p='+intParoquia;
		document.frm.submit();
	}

	function Lancar(){

		if(document.frm.txtParoquia.value == 0){
			alert ('Selecione a paróquia');
			return false;
		}

		if(document.frm.txtEncontro.value == 0){
			alert ('Selecione o encontro');
			return false;
		}

		if(document.frm.txtQuantidade.value == 0){
			alert ('Informe a quantidade');
			return false;
		}

		var params = 'p='+document.frm.txtParoquia.value+'&e='+document.frm.txtEncontro.value+'&q='+document.frm.txtQuantidade.value;
		location.href = 'lancamento.php?'+params;

	}

</script>