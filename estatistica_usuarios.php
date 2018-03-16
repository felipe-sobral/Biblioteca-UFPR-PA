<?php
  session_start();

  include "cfg.php";

  $funcao = 0;
  $numero = 1;

  $sql_data = mysqli_query($conectar, "SELECT DATE(CURRENT_TIMESTAMP)"); // RETORNA DATA ATUAL
  $sql_hora = mysqli_query($conectar, "SELECT HOUR(CURRENT_TIMESTAMP)"); // RETORNA HORA ATUAL

  $data = mysqli_fetch_row($sql_data);
  $hora = mysqli_fetch_row($sql_hora);

  $hora_br = $hora[0]-3;

  printf("Data: %s, Horas: %s", $data[0], $hora[0]-3);

  $sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data = '{$data[0]}'");
  $verificarDataExiste = mysqli_num_rows($sql); // RETORNO != 0 == EXISTE

  if($funcao == 0){
    if($verificarDataExiste == 0){

      mysqli_query($conectar, "INSERT INTO estatistica_usuarios(manha, tarde, noite, data) VALUES ('0', '0', '0', '{$data[0]}') ");

    } else {
      $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data[0]}'");
      $contagem = mysqli_fetch_array($sql);

      switch ($hora_br) {

        case ($hora_br >= 7 && $hora_br < 12):
          $numero = $numero + $contagem['manha'];
          echo $numero;
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = '{$numero}' WHERE data = '{$data[0]}'");
        break;

        case ($hora_br >= 12 && $hora_br < 18):
          $numero = $numero + $contagem['tarde'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = '{$numero}' WHERE data = '{$data[0]}'");
        break;

        case ($hora_br >= 18 && $hora_br < 20):
          $numero = $numero + $contagem['noite'];
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = '{$numero}' WHERE data = '{$data[0]}'");
        break;

        }

    }
  }

 ?>
