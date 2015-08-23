<?php
  
  error_reporting(E_ALL ^ E_NOTICE);
  
  session_start();
  
  $Paroquia   = $_GET["p"]  ? $_GET["p"] : 0;
  $Encontro   = $_GET["e"]  ? $_GET["e"] : 0;

  $dir = "quadrantes/$Paroquia/$Encontro/";

  include 'conexao.php';

  $sql = "SELECT  p.ParoquiaDescricao, e.EncontroAno, e.Digitado
          FROM  encontro e
              INNER JOIN paroquia p ON p.ParoquiaCodigo = e.ParoquiaCodigo 
          WHERE   e.ParoquiaCodigo = ".$Paroquia." AND e.EncontroNumero = ".$Encontro;
  $stm = $pdo->query($sql) OR die(implode('', $pdo->errorInfo()));
  while( $row = $stm->fetch(PDO::FETCH_ASSOC) ){
    $ParoquiaDescricao  = iconv('ISO-8859-1', 'UTF-8', $row['ParoquiaDescricao']);
    $EncontroAno        = $row['EncontroAno'];
  }

  error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>

<?include "head.php";?>

  <style>
    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
    }
  </style>
</head>
<body>

  <div class="container">

    <?include "header.php";?>
      </header>

      <?include "menu.php";?>
      </nav>

      <h1>Galeria de fotos</h1>

      <h2>Paróquia: <?=$ParoquiaDescricao?></h2>
      <h2>Encontro: <?="#".str_pad($Encontro, 2, "0", STR_PAD_LEFT). " (Ano: ".$EncontroAno.")"?></h2>

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        
        <div class="carousel-inner" role="listbox">

          <?php
          if (is_dir($dir)) {
              if ($dh = opendir($dir)) {
                  $Imagem = 1;
                  while (($file = readdir($dh)) !== false) {
                    
                    $info = new SplFileInfo($file);
                    
                    if (strtolower($info->getExtension()) == "jpg") {
                    ?>                    
                    
                    <div class="<?=($Imagem == 1) ? 'item active' : 'item'?>">
                      <img src="<?=$dir.$file?>" width="460" height="345">
                    </div>    
                    
                    <?$Imagem++;
                    }
                  }
                  closedir($dh);
              }
          }
          ?>

        </div>

        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>

      <?include "footer.php";?>

    </div>

</body>

</html>
