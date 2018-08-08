<?php
  session_start();

  include "../funcoesGerais.php";
  include "../cfg.php";

  if(isset($_POST['funcao'])){
    $funcao = $_POST['funcao'];
  }
  if(isset($_POST['numero'])){
    $numero = (int)preg_replace('/[^0-9_]/', '',$_POST['numero']);
  }

  switch ($funcao) {
    case 0:
      adicionar($numero); // CERTO
    break;
    case 1:
      atualizarContador(); // CERTO
    break;
    case 2;
      remover($numero); // CERTO
   break;
   case 3:
      //turno($hora_br, $data); // CERTO
   break;
   case 4:
      //datahora(); // N
   break;
   case 5:
      if(verificarLogin(1)){  // CERTO
        echo "1";
      } else {
        echo "0";
      }
   break;
   case 6:
      //$total = somaTurnos($data); // CERTO
   break;
  }

  // ADICIONAR PESSOAS
  function adicionar($total){
    $conectar = $GLOBALS['conectar'];
    $data = date("m-d-Y");
    $sql = mysqli_query($conectar, "SELECT * FROM impressao WHERE xdata = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);
      mysqli_query($conectar, "UPDATE impressao SET total = total+'{$total}' WHERE xdata = '{$data}'");
      gravar_log("Contador+Impressao * [#139#]");
      echo $contagem['total']+$total;
    }
  }

  // REMOVER PESSOAS
  function remover($total){
    $conectar = $GLOBALS['conectar'];
    $data = date("m-d-Y");
    $sql = mysqli_query($conectar, "SELECT * FROM impressao WHERE xdata = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);
      if($contagem['total']-$total < 0){
        mysqli_query($conectar, "UPDATE impressao SET total = 0 WHERE xdata = '{$data}'");
      } else {
        mysqli_query($conectar, "UPDATE impressao SET total = total-'{$total}' WHERE xdata = '{$data}'");
      }
      gravar_log("Contador-Impressao * [#140#]");
      echo $contagem['total']-$total;
    }
  }

  // ATUALIZAR CONTADOR
  function atualizarContador(){
    $data = date("m-d-Y");
    $mes = date("m");
    $ano = date("Y");
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM impressao WHERE xdata = '{$data}'");

    if(!verificarSql($sql)){
      mysqli_query($conectar, "INSERT INTO impressao(total, xdata, mes, ano) VALUES ('0','{$data}', $mes, $ano) ");
    }

    $contagem = mysqli_fetch_array($sql);

    if($contagem['total'] == 0){
      echo "00";
    } else {
      echo $contagem['total'];
    }


  }

 ?>
