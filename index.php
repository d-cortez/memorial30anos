<?php
	error_reporting(E_ALL ^ E_NOTICE);
	
	session_start();
	
	$Paroquia   = $_GET["p"]  ? $_GET["p"] : 0;
    $Encontro   = $_GET["e"]  ? $_GET["e"] : 0;

    $_SESSION["paroquia"] = $Paroquia;
    $_SESSION["encontro"] = $Encontro;

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
		
		<div class="container">
			
			<h2>Memorial 30 anos</h2>
		
		</div>
	</div>

	<div class="container">
	<?include "footer.php";?>	
	</div>
	
</body>

</html>