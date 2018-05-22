<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  $mes = retornaData(mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"));
  $dia = retornaData(mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"));
  $ano = retornaData(mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"));

  $sql = mysqli_query($conectar, "SELECT codigos FROM consulta_local WHERE mes='{$mes}' AND dia='{$dia}' AND ano='{$ano}'");

  if(verificarSql($sql)){
    $dado = mysqli_fetch_array($sql);

    $dados = explode("\r\n", $dado['codigos']);

    $i = 0;

    while(isset($dados[$i])){
      $i++;
    }

    $i = $i-1;
    $ii = $i-3;

    while($i > $ii){
      if($i >= 0){
        echo $dados[$i]."</br>";
      } else {
        return;
      }
      $i--;
    }

  } else {
    echo 0;
    exit;
  }


?>
