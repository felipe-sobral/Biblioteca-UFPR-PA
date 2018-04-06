<?php

  include "../bibliotecas/phpqrcode/qrlib.php";
  /*include "../cfg.php"; // EXCLUIR LINHA
  include "../funcoesGerais.php";  // EXCLUIR LINHA*/

  $mes = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MONTH(CURRENT_TIMESTAMP)"));
  $dia = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT DAY(CURRENT_TIMESTAMP)"));
  $ano = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT YEAR(CURRENT_TIMESTAMP)"));
  $hora = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT HOUR(CURRENT_TIMESTAMP)"));
  $min = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MINUTE(CURRENT_TIMESTAMP)"));
  $sec = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT SECOND(CURRENT_TIMESTAMP)"));

  puxarQR();

  function gerarQR(){
    global $mes, $dia, $ano, $hora, $min, $sec, $conectar;

    $codigo = $dia.$mes.$ano.$hora.$min.$sec;

    $sql = mysqli_query($conectar, "SELECT * FROM QRcode");
    $sql = mysqli_num_rows($sql);

    $caminho = "QR/codigo".$sql.".png";

    QRcode::png($codigo, $caminho, QR_ECLEVEL_L , 10);

    mysqli_query($conectar, "INSERT INTO QRcode(codigo, hora, minutos, ativo, caminho) VALUES ('{$codigo}', '{$hora}', '{$min}', '1', '{$caminho}')");

  }

  function puxarQR(){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT codigo FROM QRcode");

    $linhas = mysqli_num_rows($sql);
    $dados = mysqli_fetch_row($sql);

    if($linhas == null){

      gerarQR();
      puxarQR();

    } else {

      $numero = rand(0, $linhas);
      $endereco = $dados[$numero];  /// ARRUMAR AQUI PARA RECEBER ENDEREÇO DA IMAGEM E O RETORNAR
      echo $endereco;
      return $endereco;

    }
  }

  function validarQR($codigo){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM QRcode WHERE codigo = '{$codigo}'");

    if(verificarSql($sql)){
      return true;
    } else {
      return false;
    }

  }

?>
