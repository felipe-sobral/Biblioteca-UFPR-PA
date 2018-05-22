<?php

  include "../bibliotecas/phpqrcode/qrlib.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  if(isset($_POST['gerarQRcode'])){
    puxarQR();
  }

  function gerarQR(){
    $mes = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MONTH(CURRENT_TIMESTAMP)"));
    $dia = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT DAY(CURRENT_TIMESTAMP)"));
    $ano = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT YEAR(CURRENT_TIMESTAMP)"));
    $hora = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT HOUR(CURRENT_TIMESTAMP)"));
    $min = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MINUTE(CURRENT_TIMESTAMP)"));
    $sec = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT SECOND(CURRENT_TIMESTAMP)"));

    $codigo = $dia.$mes.$ano.$hora.$min.$sec;

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM QRcode");
    $sql = mysqli_num_rows($sql);

    $caminho = "QR/codigo".$sql.".png";

    QRcode::png($codigo, $caminho, QR_ECLEVEL_L , 10);

    mysqli_query($GLOBALS['conectar'], "INSERT INTO QRcode(codigo, hora, minutos, ativo, caminho) VALUES ('{$codigo}', '{$hora}', '{$min}', '1', '{$caminho}')");

    return $codigo;

  }

  function puxarQR(){
    limparQR();

    $codigo = gerarQR();

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM QRcode WHERE codigo='{$codigo}'");
    $dado = mysqli_fetch_array($sql);

    echo $dado['caminho'];
  }

  function limparQR(){
    $hora = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT HOUR(CURRENT_TIMESTAMP)"));
    $min = retornaData(mysqli_query($GLOBALS['conectar'], "SELECT MINUTE(CURRENT_TIMESTAMP)"));

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM QRcode");
    if(verificarSql($sql)){
      while($dado = mysqli_fetch_array($sql)){
        if($dado['minutos'] < 10){
          $min = "0".$dado['minutos'];
        } else {
          $min = $dado['minutos'];
        }

        $horaQR = $dado['hora'].$min;

        if($min < 10){
          $min = "0".$min;
        } else {
          $min = $min;
        }

        $horaAtual = $hora.$min;

        $operacao = intval($horaAtual) - intval($horaQR);

        if($operacao < 0){
          excluirQR($dado['id']);
        } else if($operacao >= 30){
          excluirQR($dado['id']);
        }

      }
    }
  }

  function excluirQR($id){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM QRcode WHERE id='{$id}'");
    $dado = mysqli_fetch_array($sql);
    $sql = mysqli_query($GLOBALS['conectar'], "DELETE FROM QRcode WHERE id='{$id}'");

    unlink($dado['caminho']);
  }

?>
