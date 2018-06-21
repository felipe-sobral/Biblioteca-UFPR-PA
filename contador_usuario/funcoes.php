<?php
  session_start();

  include "../funcoesGerais.php";
  include "../cfg.php";

  if(isset($_POST['funcao'])){
    $funcao = $_POST['funcao'];
  }
  if(isset($_POST['numero'])){
    $numero = $_POST['numero'];
  }

  $data = date("Y-m-d");
  $hora_br = intval(date("H"))-3;

  switch ($funcao) {
    case 0:
      adicionar($numero, $hora_br, $data); // CERTO
    break;
    case 1:
      atualizarContador($hora_br, $data); // CERTO
    break;
    case 2;
      remover($numero, $hora_br, $data); // CERTO
   break;
   case 3:
      turno($hora_br, $data); // CERTO
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
      $total = somaTurnos($data); // CERTO
   break;
  }

  // ADICIONAR PESSOAS
  function adicionar($pessoas, $hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);
      switch ($hora_br) {
        case ($hora_br >= 7 && $hora_br < 12): // PARTE MANHÃ 07:30 ÀS 12:00
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = manha+1 WHERE data = '{$data}'");
          echo $contagem['manha']+1;
        break;

        case ($hora_br >= 12 && $hora_br < 18): // PARTE TARDE 12:00 ÀS 18:00
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = tarde+1 WHERE data = '{$data}'");
          echo $contagem['tarde']+1;
        break;

        case ($hora_br >= 18 && $hora_br < 23): // PARTE NOITE 18:00 ÀS 19:30
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = noite+1 WHERE data = '{$data}'");
          echo $contagem['noite']+1;
        break;
      }
    } else {
    }
  }

  // REMOVER PESSOAS
  function remover($pessoas, $hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);

      switch ($hora_br) {
        case ($hora_br >= 7 && $hora_br < 12):
          if($contagem['manha'] != 0){
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = manha-1 WHERE data = '{$data}'");
            echo $contagem['manha']-1;
          } else {
            echo 0;
          }
        break;

        case ($hora_br >= 12 && $hora_br < 18):
          if($contagem['tarde'] != 0){
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = tarde-1 WHERE data = '{$data}'");
            echo $contagem['tarde']-1;
          } else {
            echo 0;
          }
        break;

        case ($hora_br >= 18 && $hora_br < 23):
          if($contagem['noite'] != 0){
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = noite-1 WHERE data = '{$data}'");
            echo $contagem['noite']-1;
          } else {
            echo 0;
          }
        break;

      }
    }
  }

  // ATUALIZAR CONTADOR
  function atualizarContador($hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    if(!verificarSql($sql)){
      $mes = intval(date("m"));
      $ano = intval(date("Y"));

      mysqli_query($conectar, "INSERT INTO estatistica_usuarios(manha, tarde, noite, n_mes, ano, data) VALUES ('0', '0', '0', '{$mes}', '{$ano}','{$data}') ");
    }
    $contagem = mysqli_fetch_array($sql);
    switch ($hora_br) {
      case ($hora_br >= 7 && $hora_br < 12):
        if($contagem['manha'] == 0){
          echo "00";
        } else {
          echo $contagem['manha'];
        }
      break;

      case ($hora_br >= 12 && $hora_br < 18):
        if($contagem['tarde'] == 0){
          echo "00";
        } else {
          echo $contagem['tarde'];
        }
      break;

      case ($hora_br >= 18 && $hora_br < 23):
        if($contagem['noite'] == 0){
          echo "00";
        } else {
          echo $contagem['noite'];
        }
      break;
    }
  }

  // ATUALIZA TURNO
  function turno($hora_br){
    switch ($hora_br) {
      case ($hora_br >= 7 && $hora_br < 12):
        echo "<a id='turno'><i>Manhã</i></a>";
      break;

      case ($hora_br >= 12 && $hora_br < 18):
        echo "<a id='turno'><i>Tarde</i></a>";
      break;

      case ($hora_br >= 18 && $hora_br < 23):
        echo "<a id='turno'><i>Noite</i></a>";
      break;
    }
  }

  // SOMA TURNOS
  function somaTurnos($dataH){
    if(isset($_SESSION['nivel']) && $_SESSION['nivel']>0){
      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM estatistica_usuarios WHERE data='{$dataH}'");

      $turnos = mysqli_fetch_array($sql);
      $total = $turnos['manha']+$turnos['tarde']+$turnos['noite'];

      echo $total;

    } else {
      return "ERROR";
    }
  }

 ?>
