<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarNivel(3)){
    $mes = retornaData(mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"));
    $dia = retornaData(mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"));
    $ano = retornaData(mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"));

    $codigo = $_POST['codigoBarras'];

    if(strlen($codigo) != 8){
      echo 0;
      exit;
    }

    $ehNumero = intval($codigo); // TRANSFORMA STRING EM NÚMERO
    $ehNumero = strval($ehNumero); // TRANSFORMA NOVAMENTE O NÚMERO EM STRING
    $tamanhoString = strlen($ehNumero); // VERIFICA TAMANHO DA STRING

    if($tamanhoString >= 5){

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
