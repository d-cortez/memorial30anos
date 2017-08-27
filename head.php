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

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>Segunda Etapa</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<meta charset="utf-8">
	<meta name="description" content="Segunda etapa"/>
	<meta name="keywords" content="arquidiocese,natal,segue-me,segunda,etapa" />
	<meta name="author" content="Flávio Cortez"/>
	<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
	<link rel="shortcut icon" href="images/favicon.ico" />

	<script>
		function goBack()
  		{
  			window.history.back();
  		}
	</script>