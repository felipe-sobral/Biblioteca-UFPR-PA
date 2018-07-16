<?php

  session_start();

  include "cfg2.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  function imprimir_tarefa($titulo, $descricao, $id, $data){
    printf("
    <div class='card'>
      <div class='card-body'>
        <h5 class='card-title'>%s</h5>
        <h6 class='card-subtitle mb-2 text-muted'>%s</h6>
        <p class='card-text'>%s</p>
        <h6 class='card-subtitle mb-2 text-muted'>ID: %d</h6>
        <button class='waves-effect waves-light btn-small' onclick='finalizar_tarefa(%d, 0)'><i class='material-icons'>check</i></button>
        <button class='waves-effect waves-light btn-small' onclick='finalizar_tarefa(%d, 1)'><i class='material-icons'>clear</i></button>
      </div>
    </div>

    ", $titulo, $data, $descricao, $id, $id, $id);

  }

  $usuario = $_SESSION['usuario'];

  $sql_v = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
  if(verificarSql($sql_v)){
    $tb_linhas = mysqli_num_rows(mysqli_query($conectar2, "SELECT * FROM ".$usuario.""));
    if($tb_linhas>0){
      $sql = mysqli_query($conectar2, "SELECT * FROM ".$usuario."");
      while($tarefa = mysqli_fetch_array($sql)){
        if($tarefa['t_status'] == 1){

          imprimir_tarefa($tarefa['titulo'], $tarefa['descricao'], $tarefa['id'], $tarefa['data_registro']);

        }
      }

    }else{
      echo 0;
      exit;
    }
  } else {
    echo 0;
    exit;
  }

?>
