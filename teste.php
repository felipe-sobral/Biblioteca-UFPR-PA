<?php
  print_r(date ("d/m/Y", filemtime("teste.php")));

  echo "<br><br> codigo: ".sha1("consulta_local")." <br> digitado: ".sha1($_GET['teste'])." <br><br>";


  switch(sha1($_GET['teste'])){
    case sha1("e_usuarios"):
       echo $_GET["teste"];
       break;

    case sha1("consulta_local"):
        echo $_GET["teste"];
       break;

    case sha1("consulta_local_INSERIR"):
        echo $_GET["teste"];  
       break;

    default:
       echo "{\"status\": false, \"mensagem\": \"#4#\"}";
       exit;
 }