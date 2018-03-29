<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarNivel(3)){
    $sql_mes = mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"); // RETORNA MES ATUAL
    $sql_dia = mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"); // RETORNA DIA ATUAL
    $sql_ano = mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"); // RETORNA ANO ATUAL

    $mes = mysqli_fetch_row($sql_mes); $mes = $mes[0];
    $dia = mysqli_fetch_row($sql_dia); $dia = $dia[0];
    $ano = mysqli_fetch_row($sql_ano); $ano = $ano[0];

    $codigo = $_POST['codigoBarras'];

    $ehNumero = intval($codigo); // TRANSFORMA STRING EM NÚMERO
    $ehNumeroConf = is_numeric($ehNumero); // RETORNA SE É NUMERO
    $ehNumero = strval($ehNumero); // TRANSFORMA NOVAMENTE O NÚMERO EM STRING
    $tamanhoString = strlen($ehNumero); // VERIFICA TAMANHO DA STRING

    if(($tamanhoString == 8 || $tamanhoString == 6) && $ehNumeroConf == 1){

      $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE mes='{$mes}' AND dia='{$dia}' AND ano='{$ano}'");

      if(verificarSql($sql)){

        $dado = mysqli_fetch_array($sql);

        $novo_text = $dado['codigos']."\r\n".$codigo;

        mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$novo_text}' WHERE mes='{$mes}' AND dia='{$dia}' AND ano='{$ano}'");

        echo 1;
        exit;

      } else {

        mysqli_query($conectar, "INSERT INTO `consulta_local`(`dia`, `ano`, `mes`, `codigos`) VALUES ('$dia', '$ano', '$mes','$codigo')");

        echo 1;
        exit;

      }

    }else{
      echo 0;
      exit;
    }

}



?>
