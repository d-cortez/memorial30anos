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

		<h1>Consultar Quadrante</h1>
		
		<div class="container ">
		  	<h2>Paróquia:</h2>
		  	<ul class="pagination">
		  	<?php
		  		if ($Paroquia){
		  			$sql = "SELECT * FROM paroquia WHERE ParoquiaCodigo=".$Paroquia;
		  		}else{
		  			$sql = "SELECT * FROM paroquia WHERE Exibir = 1 ORDER BY ParoquiaDescricao";
		  		}
		      
		      	$stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
		      	while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
			    if ($Paroquia == $row['ParoquiaCodigo']) {?>
		            <li class="active"><a style="width:300px;text-align:center" href="quadranteconsultar.php?p=<?=$row['ParoquiaCodigo']?>&e=0"><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></a></li>
		           	<a href="quadranteconsultar.php" class="btn btn-warning">Escolher outra paróquia</a>       
		        <?}else{?>
		           	<li><a style="width:300px" href="quadranteconsultar.php?p=<?=$row['ParoquiaCodigo']?>&e=0"><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></a></li>
		    	<?}
		      }
		    ?>
		  	</ul>
		</div>

		<?if ($Paroquia) {?>

			<div class="container">
			    <h2>Encontro:</h2>
			  	<ul class="pagination">
			    <?php      
			      $sql = "SELECT  ParoquiaCodigo, EncontroNumero, EncontroAno 
			              FROM    encontro
			              WHERE   ParoquiaCodigo=".$Paroquia." ORDER BY EncontroNumero";
			      $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
			      while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
			        if ($Encontro == $row['EncontroNumero']) {?>
			            <li class="active"><a href="quadranteconsultar.php?p=<?=$row['ParoquiaCodigo']?>&e=<?=$row['EncontroNumero']?>"><?=str_pad($row['EncontroNumero'], 2, "0", STR_PAD_LEFT)?></a></li>
			            <?$EncontroAno = $row['EncontroAno'];?>
			        <?}else{?>
			            <li><a href="quadranteconsultar.php?p=<?=$row['ParoquiaCodigo']?>&e=<?=$row['EncontroNumero']?>"><?=str_pad($row['EncontroNumero'], 2, "0", STR_PAD_LEFT)?></a></li>
			        <?}
			      }
			    ?>
			  	</ul>
			</div>

		<?}?>

		<?if ($Encontro && $Paroquia) {?>

			<div class="container">

				<h2>
					<p><?="#".str_pad($Encontro, 2, "0", STR_PAD_LEFT)?></p>
					<p><?="Ano: ".$EncontroAno?></p>
				</h2>

			  	<table class="table table-striped table-bordered table-hover">
			      <tr>
			          <th>#</th>
			          <th>Nome Completo</th>
			          <th>Crachá</th>        
			      </tr>

			      <tbody>
			        <?php

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
			        
			        $pdo=null;
			        ?>
			      </tbody>

			  </table>
			</div>

		<?}?>

		<div class="container">
        	<?if ($Paroquia) {?>
        		<a href="quadranteconsultar.php" class="btn btn-warning">Escolher outra paróquia</a>
        	<?}?>
        </div>
		
		<?include "footer.php";?>
	
	</div>
</body>

</html>