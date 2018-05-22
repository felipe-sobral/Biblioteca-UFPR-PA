<?php
  session_start();

  include "../cfg.php";

  $funcao = $_POST['funcao'];
  $numero = $_POST['numero'];

  $sql_data = mysqli_query($conectar, "SELECT DATE(CURRENT_TIMESTAMP)"); // RETORNA DATA ATUAL
  $sql_hora = mysqli_query($conectar, "SELECT HOUR(CURRENT_TIMESTAMP)"); // RETORNA HORA ATUAL

  $data = mysqli_fetch_row($sql_data);
  $hora = mysqli_fetch_row($sql_hora);

  $hora_br = $hora[0]-3;

  $sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data[0]}'");
  $verificarDataExiste = mysqli_num_rows($sql); // RETORNO != 0 == EXISTE

  switch ($funcao) {
    case 0:
      adicionar($numero, $conectar, $hora_br, $data, $verificarDataExiste);
    break;
    case 1:
      atualizarContador($conectar, $hora_br, $data, $verificarDataExiste);
    break;
    case 2;
      remover($numero, $conectar, $hora_br, $data, $verificarDataExiste);
   break;
   case 3:
      turno($conectar, $hora_br, $data);
   break;
   case 4:
      datahora($conectar);
   break;
   case 5:
      verificarLogin($conectar);
   break;
  }

  // ADICIONAR PESSOAS
  function adicionar($pessoas, $conectar, $hora_br, $data, $verificarDataExiste){
    if($verificarDataExiste == 0){

      echo 0;

    } else {
      $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data[0]}'");
      $contagem = mysqli_fetch_array($sql);

      switch ($hora_br) {

        case ($hora_br >= 7 && $hora_br < 12):

          $pessoas = $pessoas + $contagem['manha'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = '{$pessoas}' WHERE data = '{$data[0]}'");

        break;

        case ($hora_br >= 12 && $hora_br < 18):

          $pessoas = $pessoas + $contagem['tarde'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = '{$pessoas}' WHERE data = '{$data[0]}'");

        break;

        case ($hora_br >= 18 && $hora_br < 20):

          $pessoas = $pessoas + $contagem['noite'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = '{$pessoas}' WHERE data = '{$data[0]}'");

        break;

      }

    }

  }

  // REMOVER PESSOAS
  function remover($pessoas, $conectar, $hora_br, $data, $verificarDataExiste){

    if($verificarDataExiste == 0){

      echo 0;

    } else {

      $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data[0]}'");
      $contagem = mysqli_fetch_array($sql);

      switch ($hora_br) {

        case ($hora_br >= 7 && $hora_br < 12):

          if($contagem['manha'] != 0){
            $pessoas = $contagem['manha'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = '{$pessoas}' WHERE data = '{$data[0]}'");
          } else {
            echo 0;
          }

        break;

        case ($hora_br >= 12 && $hora_br < 18):

          if($contagem['tarde'] != 0){
            $pessoas = $contagem['tarde'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = '{$pessoas}' WHERE data = '{$data[0]}'");
          } else {
            echo 0;
          }

        break;

        case ($hora_br >= 18 && $hora_br < 20):

          if($contagem['noite'] != 0){
            $pessoas = $contagem['noite'] - $pessoas;
            mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = '{$pessoas}' WHERE data = '{$data[0]}'");
          } else {
            echo 0;
          }

        break;

      }

    }

  }

  // ATUALIZAR CONTADOR
  function atualizarContador($conectar, $hora_br, $data, $verificarDataExiste){
    if($verificarDataExiste == 0){
      $sql_mes = mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"); // RETORNA MÊS ATUAL
      $sql_ano = mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"); // RETORNA ANO ATUAL
      $mes = mysqli_fetch_row($sql_mes);
      $ano = mysqli_fetch_row($sql_ano);

      mysqli_query($conectar, "INSERT INTO estatistica_usuarios(manha, tarde, noite, n_mes, ano, data) VALUES ('0', '0', '0', '{$mes[0]}', '{$ano[0]}','{$data[0]}') ");

    }

    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data[0]}'");
    $contagem = mysqli_fetch_array($sql);

    switch ($hora_br) {

      case ($hora_br >= 7 && $hora_br < 12):

        echo $contagem['manha'];

      break;

      case ($hora_br >= 12 && $hora_br < 18):

        echo $contagem['tarde'];

      break;

      case ($hora_br >= 18 && $hora_br < 20):

        echo $contagem['noite'];

      break;

    }

  }

  // ATUALIZA TURNO
  function turno($conectar, $hora_br, $data){

    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data[0]}'");
    $contagem = mysqli_fetch_array($sql);

    switch ($hora_br) {

      case ($hora_br >= 7 && $hora_br < 12):

        echo "<a id='turno'><i class='far fa-sun'></i> <i>Manhã</i></a>";

      break;

      case ($hora_br >= 12 && $hora_br < 18):

        echo "<a id='turno'><i class='fas fa-sun'></i> <i>Tarde</i></a>";

      break;

      case ($hora_br >= 18 && $hora_br < 20):

        echo "<a id='turno'><i class='fas fa-moon'></i> <i>Noite</i></a>";

      break;


    }

  }

  // DATA E HORA DO SERVIDOR
  function datahora($conectar){
    $sql = mysqli_query($conectar, "SELECT CURRENT_TIMESTAMP");
    $data = mysqli_fetch_row($sql);

    printf("<i id='ultAtualizacao'>%s (Horas -3)</i>", $data[0]);

  }

  // VERIFICAR SE JÁ EXISTE SESSÃO
  function verificarLogin($conectar){
    if(isset($_SESSION)){
      $user = $_SESSION['usuario'];
      $senha = $_SESSION['senha'];

      $sql = mysqli_query($conectar, "SELECT nivel FROM usuarios WHERE usuario='{$user}' AND senha='{$senha}'");
      $dado = mysqli_fetch_array($sql);

      if($dado['nivel'] >= 3){
        echo 1;
      }

    } else {
      echo 0;
    }
  }
  // ++ CONDIÇÕES $conectar, $hora_br, $data

 ?>
