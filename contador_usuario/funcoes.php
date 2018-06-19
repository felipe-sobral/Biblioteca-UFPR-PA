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
  $hora_br = date("h"); // PROBLEMA AQUI!!!!!!!!!!!!!

  //$sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data}'");
  //$verificarDataExiste = mysqli_num_rows($sql); // RETORNO != 0 == EXISTE

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
      $total = somaTurnos(date("Y-m-d")); // CERTO
      echo $total;
   break;
  }

  // ADICIONAR PESSOAS
  // adicionar($numero, $hora_br, $data);
  function adicionar($pessoas, $hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);
      echo $hora_br;
      switch ($hora_br) {
        case ($hora_br >= 7 && $hora_br < 12): // PARTE MANHÃ 07:30 ÀS 12:00
          $pessoas = $pessoas + $contagem['manha'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = '{$pessoas}' WHERE data = '{$data}'");
          echo $pessoas;
        break;

        case ($hora_br >= 12 && $hora_br < 18): // PARTE TARDE 12:00 ÀS 18:00
          $pessoas = $pessoas + $contagem['tarde'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = '{$pessoas}' WHERE data = '{$data}'");
          echo $pessoas;
        break;

        case ($hora_br >= 18 && $hora_br < 23): // PARTE NOITE 18:00 ÀS 19:30
          $pessoas = $pessoas + $contagem['noite'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = '{$pessoas}' WHERE data = '{$data}'");
          echo $pessoas;
        break;
      }
    } else {
    }
  }

  // REMOVER PESSOAS
  // remover($numero, $hora_br, $data);
  function remover($pessoas, $hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);

      switch ($hora_br) {
        case ($hora_br >= 7 && $hora_br < 12):
          if($contagem['manha'] != 0){
            $pessoas = $contagem['manha'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = '{$pessoas}' WHERE data = '{$data}'");
            echo $pessoas;
          } else {
            echo 0;
          }
        break;

        case ($hora_br >= 12 && $hora_br < 18):
          if($contagem['tarde'] != 0){
            $pessoas = $contagem['tarde'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = '{$pessoas}' WHERE data = '{$data}'");
            echo $pessoas;
          } else {
            echo 0;
          }
        break;

        case ($hora_br >= 18 && $hora_br < 23):
          if($contagem['noite'] != 0){
            $pessoas = $contagem['noite'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = '{$pessoas}' WHERE data = '{$data}'");
            echo $pessoas;
          } else {
            echo 0;
          }
        break;

      }
    }
  }

  // ATUALIZAR CONTADOR
  // atualizarContador($hora_br, $data);
  function atualizarContador($hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $mes = date("m");
      $ano = date("Y");

      mysqli_query($conectar, "INSERT INTO estatistica_usuarios(manha, tarde, noite, n_mes, ano, data) VALUES ('0', '0', '0', '{$mes}', '{$ano}','{$data}') ");
    }
    $contagem = mysqli_fetch_array($sql);
    switch ($hora_br) {
      case ($hora_br >= 7 && $hora_br < 12):
        echo $contagem['manha'];
      break;

      case ($hora_br >= 12 && $hora_br < 18):
        echo $contagem['tarde'];
      break;

      case ($hora_br >= 18 && $hora_br < 23):
        echo $contagem['noite'];
      break;
    }
  }

  // ATUALIZA TURNO
  //turno($hora_br, $data);
  function turno($hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    $contagem = mysqli_fetch_array($sql);
    switch ($hora_br) {
      case ($hora_br >= 7 && $hora_br < 12):
        echo "<a id='turno'><i class='far fa-sun'></i> <i>Manhã</i></a>";
      break;

      case ($hora_br >= 12 && $hora_br < 18):
        echo "<a id='turno'><i class='fas fa-sun'></i> <i>Tarde</i></a>";
      break;

      case ($hora_br >= 18 && $hora_br < 23):
        echo "<a id='turno'><i class='fas fa-moon'></i> <i>Noite</i></a>";
      break;
    }

  }

  function somaTurnos($dataH){
    if(isset($_SESSION['nivel']) && $_SESSION['nivel']>0){
      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM estatistica_usuarios WHERE data='{$dataH}'");

      $turnos = mysqli_fetch_array($sql);
      $total = $turnos['manha']+$turnos['tarde']+$turnos['noite'];

      return $total;

    } else {
      return "ERROR";
    }
  }

 ?>
