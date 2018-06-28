<?php
function inserirCodigo($codigo){
  $mes = date("m");
  $dia = date("d");
  $ano = date("Y");

  if(strlen($codigo) != 8){
    return false;
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
      gravar_log("Adicionou Consulta [".$codigo."] * [#134#]");

      return true;

    } else {

      mysqli_query($GLOBALS['conectar'], "INSERT INTO `consulta_local`(`dia`, `ano`, `mes`, `codigos`) VALUES ('$dia', '$ano', '$mes','$codigo')");
      gravar_log("Adicionou Consulta [".$codigo."] * [#134#]");
      return true;

    }

  }else{
    return false;

  }

}
?>
