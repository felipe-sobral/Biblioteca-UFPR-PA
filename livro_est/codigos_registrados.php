<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  $sql_mes = mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"); // RETORNA MES ATUAL
  $sql_dia = mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"); // RETORNA DIA ATUAL
  $sql_ano = mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"); // RETORNA ANO ATUAL

  $mes = mysqli_fetch_row($sql_mes); $mes = $mes[0];
  $dia = mysqli_fetch_row($sql_dia); $dia = $dia[0];
  $ano = mysqli_fetch_row($sql_ano); $ano = $ano[0];

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
      echo $dados[$i]."</br>";
      $i--;
    }

  } else {
    echo 0;
    exit;
  }


?>
