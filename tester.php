<?php

  $dados = @unserialize(file_get_contents('http://ip-api.com/php/'.$_SERVER['REMOTE_ADDR']));
  $whitelistISP = "Fundacao da UFPR para o DCTC";

  if($dados['isp'] == $whitelistISP){
    echo "VOCÊ TEM ACESSO!!!!";
  } else {
    echo "VOCÊ NÃO TEM ACESSO!!!";
  }

  echo "<br/>ISP TESTADO = ".$dados['isp'];


?>
