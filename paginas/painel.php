<?php
   require "../root/init.php";

   session_start();

   $content = "<div id='carregando' class='carregando'><div class='ui massive active centered inverted inline loader'></div></div>";
?>

<!DOCTYPE html>
<html lang='pt-br'>

<!--
    - Felipe Vieira Sobral
    - xfelipesobral@gmail.com
    - felipesobral@ufpr.br
    - https://felipesobral.xyz
    - https://github.com/krepper/Biblioteca-UFPR-PA/
-->

	<head>
  		<meta charset="utf-8" />
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
  		<title>Biblioteca UFPR</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		  
		<link rel="stylesheet" href="default.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
   </head>
   
   <body style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed; color: #fff">

      <?php
         echo $content;

         acesso_restrito(3);
      ?>
      
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
      <script type="text/javascript" src="ponte.js"></script>
   </body>
</html>