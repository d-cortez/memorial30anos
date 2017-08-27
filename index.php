<?php
	error_reporting(E_ALL ^ E_NOTICE);
	
	session_start();
	
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
		
	</div>

	<div class="container">
	<?include "footer.php";?>	
	</div>
	
</body>

</html>