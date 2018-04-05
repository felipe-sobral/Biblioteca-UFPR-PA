<?php
function inserirCodigo($codigo){
  $mes = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MONTH(CURRENT_TIMESTAMP)"));
  $dia = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT DAY(CURRENT_TIMESTAMP)"));
  $ano = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT YEAR(CURRENT_TIMESTAMP)"));

  if(strlen($codigo) != 8){
    echo 0;
    exit;
  }

  $ehNumero = intval($codigo); // TRANSFORMA STRING EM NÚMERO
  $ehNumero = strval($ehNumero); // TRANSFORMA NOVAMENTE O NÚMERO EM STRING
  $tamanhoString = strlen($ehNumero); // VERIFICA TAMANHO DA STRING

  if($tamanhoString >= 5){

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM consulta_local WHERE mes='{$mes}' AND dia='{$dia}' AND ano='{$ano}'");

    if(verificarSql($sql)){

      $dado = mysqli_fetch_array($sql);

      $novo_text = $dado['codigos']."\r\n".$codigo;

      mysqli_query($GLOBALS['conectar'], "UPDATE consulta_local SET codigos='{$novo_text}' WHERE mes='{$mes}' AND dia='{$dia}' AND ano='{$ano}'");

      echo 1;
      exit;

    } else {

      mysqli_query($GLOBALS['conectar'], "INSERT INTO `consulta_local`(`dia`, `ano`, `mes`, `codigos`) VALUES ('$dia', '$ano', '$mes','$codigo')");

      echo 1;
      exit;

    }

  }else{
    echo 0;
    exit;
  }


}
?>
