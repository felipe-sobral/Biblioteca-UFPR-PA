<html>
  <head>
  </head>
  <body style="background-color: #00487F; color: #fff; text-align: center">
    <h3>ULTIMOS CODIGOS REGISTRADOS!</h3>
  </body>
</html>

<?php

  include "codigos_registrados.php";
  include "inserir_funcao.php";

  if(isset($_POST['codigo'])){
    $codigo = $_POST['codigo'];
    if(inserirCodigo($codigo) == 1){
      echo "/registrado";
    }
  }
?>
