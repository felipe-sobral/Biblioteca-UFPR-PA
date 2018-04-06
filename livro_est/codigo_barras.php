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
  include "codigo_qr.php";

  if(isset($_POST['codigo']) && isset($_POST['autenticacao'])){
    $codigo = $_POST['codigo'];
    $autenticar = $_POST['autenticacao'];

    echo "</br> ".$autenticar." </br>";

    if(validarQR($autenticar)){
      if(inserirCodigo($codigo)){
        echo "/registrado";
      }
    }else{
      echo "/falhaAutenticacao";
    }

  }
?>
