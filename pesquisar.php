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

		<h1>Localizar seguidor</h1>

		<div class="container ">
		  	<h2>Paróquia:</h2>
		  	<ul class="pagination">
		  	<?php
		  		if ($Paroquia){
		  			$sql = "SELECT * FROM paroquia WHERE ParoquiaCodigo=".$Paroquia;
		  		}else{
		  			$sql = "SELECT * FROM paroquia ORDER BY ParoquiaDescricao";
		  		}
		      
		      	$stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
		      	while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
			    if ($Paroquia == $row['ParoquiaCodigo']) {?>
		            <li class="active"><a style="width:300px;text-align:center" href="pesquisar.php?p=<?=$row['ParoquiaCodigo']?>&e=0"><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></a></li>
		            <a href="pesquisar.php" class="btn btn-warning">Escolher outra paróquia</a>
		        <?}else{?>
		           	<li><a style="width:300px" href="pesquisar.php?p=<?=$row['ParoquiaCodigo']?>&e=0"><?=iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao'])?></a></li>
		    	<?}
		      }
		    ?>
		  	</ul>
		</div>
		
		<?if ($Paroquia) {?>

		<div class="container">

			<div ng-app="LocalizarSeguidor" ng-controller="seguidorCtrl">
				
				<h2>Informe os filtros desejados:</h2>
			  	
			  	<table class="table table-striped table-bordered table-hover">

			  		<tr>
			          <th>Nome Completo</th>
			          <th>Crachá</th>
			          <th>Paróquia</th>
			          <th>Encontro</th>
			          <th>Ano</th>
			      	</tr>

			      	<tr>
                    	<th><input ng-model="search.Nome"		style="width:100%" placeholder='Pesquisar por nome'></th>
                    	<th><input ng-model="search.Cracha"		placeholder='Pesquisar por crachá'></th>
                    	<th><input ng-model="search.Paroquia"	placeholder='Pesquisar por paróquia' readonly></th>
                    	<th><input ng-model="search.Encontro"	placeholder='Pesquisar por encontro'></th>
                    	<th><input ng-model="search.Ano"		placeholder='Pesquisar por ano'></th>
                	</tr>  

					<tbody>
						<tr ng-repeat="x in names | filter:search | orderBy:'Nome'">
							<td>{{ x.Nome }}</td>
						    <td>{{ x.Cracha }}</td>
						    <td>{{ x.Paroquia }}</td>
						    <td>{{ x.Encontro }}</td>
						    <td>{{ x.Ano }}</td>
						</tr>
					<tbody>
				</table>
			
			</div>

		</div>

		<?}?>
		
		<?include "footer.php";?>
	
	</div>

	<script>
		var app = angular.module('LocalizarSeguidor', []);
		app.controller('seguidorCtrl', function($scope, $http) {
  			$http.get("ctrlSeguidores.php?p=<?=$Paroquia?>").success(function (response) {$scope.names = response.records;});
  		});
	</script>

</body>

</html>