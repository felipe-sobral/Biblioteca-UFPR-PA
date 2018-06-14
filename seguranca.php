<?php
  $status = true;

  function verificaHostIP(){
    $dadosIP = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/".$_SERVER['REMOTE_ADDR']));
    $ipHUSR = $dadosIP->ipName;
    $ipsWHITE = array("ip1", "ip2", "ip3", "ip4");

    if(!in_array($ipHUSR, $ipsWHITE)){ //REMOVER *!* PARA ATIVAR A SEGURANÇA
      return true;
    }else{
      return false;
    }
  }

  if(!verificaHostIP()){
    if(isset($_SESSION)){
      session_destroy();
    }

    $status = false;
  }

  echo $status;
?>
