<?php

  $whitelistISP = "Fundacao da UFPR para o DCTC";



  $dados = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/".$_SERVER['REMOTE_ADDR']));

  $isp = $dados->isp;
  $host = $dados->ipName;
  echo "<br/>IP86.cce-servers.ufpr.br";
  echo "<br/>";
  echo "<br/>ISP TESTADO = ".$isp;
  echo "<br/>HOSTNAME TESTADO = ".$host;

   //https://extreme-ip-lookup.com/


?>
